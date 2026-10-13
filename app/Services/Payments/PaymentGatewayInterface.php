<?php

namespace App\Services\Payments;

interface PaymentGatewayInterface
{
    /**
     * Procesa el pago de una cita médica.
     */
    public function processPayment(float $amount, string $method, array $data): array;
}