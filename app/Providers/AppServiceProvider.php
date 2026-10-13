<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// 1. Agrega estas dos líneas en la parte superior:
use App\Services\Payments\PaymentGatewayInterface;
use App\Services\Payments\MockPaymentService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 2. Inyecta el simulador aquí:
        $this->app->bind(PaymentGatewayInterface::class, MockPaymentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}