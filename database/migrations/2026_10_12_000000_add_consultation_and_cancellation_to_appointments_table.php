<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Si "status" es un ENUM, lo pasamos a texto para poder usar 'Cancelada'
        $col = DB::selectOne("SHOW COLUMNS FROM appointments WHERE Field = 'status'");

        if ($col && str_starts_with(strtolower($col->Type), 'enum')) {
            $null    = $col->Null === 'YES' ? 'NULL' : 'NOT NULL';
            $default = $col->Default !== null ? " DEFAULT '" . addslashes($col->Default) . "'" : '';
            DB::statement("ALTER TABLE appointments MODIFY status VARCHAR(30) {$null}{$default}");
        }

        Schema::table('appointments', function (Blueprint $table) {
            // Registro de la consulta
            $table->text('diagnosis')->nullable()->after('status');
            $table->text('instructions')->nullable()->after('diagnosis');
            $table->date('follow_up_date')->nullable()->after('instructions');
            $table->timestamp('attended_at')->nullable()->after('follow_up_date');

            // Cancelación
            $table->string('cancelled_by', 20)->nullable()->after('attended_at');
            $table->string('cancellation_reason')->nullable()->after('cancelled_by');
            $table->timestamp('cancelled_at')->nullable()->after('cancellation_reason');
            $table->boolean('refund_pending')->default(false)->after('cancelled_at');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'diagnosis', 'instructions', 'follow_up_date', 'attended_at',
                'cancelled_by', 'cancellation_reason', 'cancelled_at', 'refund_pending',
            ]);
        });
    }
};