<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\DoctorBlock;
use App\Models\User;
use Carbon\Carbon;

class AvailabilityService
{
    public const SLOTS = ['08:00', '09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'];
    public const HOLD_MINUTES = 15;

    public function doctorIds(?int $specialtyId, ?int $doctorId): array
    {
        return User::where('role', 'doctor')
            ->when($specialtyId, fn ($q) => $q->where('specialty_id', $specialtyId))
            ->when($doctorId, fn ($q) => $q->where('id', $doctorId))
            ->pluck('id')->all();
    }

    /** Devuelve [fecha => [hora => [ids de médicos libres]]] */
    public function availability(Carbon $from, Carbon $to, ?int $specialtyId, ?int $doctorId): array
    {
        $doctors = $this->doctorIds($specialtyId, $doctorId);
        if (!$doctors) {
            return [];
        }

        $range = [$from->toDateString(), $to->toDateString()];

        // Citas ocupadas (las pendientes de pago solo bloquean 15 min)
        $busy = [];
        Appointment::whereIn('doctor_id', $doctors)
            ->whereBetween('date', $range)
            ->where(fn ($q) => $q->where('status', '!=', 'Pendiente de Pago')
                ->orWhere('created_at', '>=', now()->subMinutes(self::HOLD_MINUTES)))
            ->get(['doctor_id', 'date', 'time'])
            ->each(function ($a) use (&$busy) {
                $busy[substr((string) $a->date, 0, 10) . '|' . substr($a->time, 0, 5) . '|' . $a->doctor_id] = true;
            });

        $blocks = DoctorBlock::whereIn('doctor_id', $doctors)
            ->whereBetween('date', $range)->get()
            ->groupBy(fn ($b) => $b->doctor_id . '|' . substr((string) $b->date, 0, 10));

        $result = [];
        for ($d = $from->copy()->startOfDay(); $d->lte($to); $d->addDay()) {
            $date = $d->toDateString();
            $result[$date] = [];
            if ($d->isBefore(today()) || $d->isSunday()) {
                continue;
            }

            foreach (self::SLOTS as $slot) {
                if ($d->isToday() && $slot <= now()->format('H:i')) {
                    continue;
                }

                $free = array_values(array_filter($doctors, function ($id) use ($busy, $blocks, $date, $slot) {
                    if (isset($busy["$date|$slot|$id"])) {
                        return false;
                    }
                    return !$blocks->get("$id|$date", collect())->contains(
                        fn ($b) => $slot >= substr($b->start_time, 0, 5) && $slot < substr($b->end_time, 0, 5)
                    );
                }));

                if ($free) {
                    $result[$date][$slot] = $free;
                }
            }
        }
        return $result;
    }
}