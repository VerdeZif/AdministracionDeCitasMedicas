<?php

namespace App\Services\Payments;

class MockPaymentService implements PaymentGatewayInterface
{
    public function processPayment(float $amount, string $method, array $data): array
    {
        // Aquí simulamos que el banco aprobó la transacción de la clínica
        return [
            'status' => 'success',
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'method' => $method,
            'amount' => $amount,
        ];
    }
}