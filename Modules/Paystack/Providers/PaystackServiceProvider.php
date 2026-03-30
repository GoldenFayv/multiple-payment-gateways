<?php

namespace Modules\Paystack\Providers;

use Nwidart\Modules\Support\ModuleServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class PaystackServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Paystack';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'paystack';

    /**
     * Command classes to register.
     *
     * @var string[]
     */
    // protected array $commands = [];

    /**
     * Provider classes to register.
     *
     * @var string[]
     */
    protected array $providers = [
        EventServiceProvider::class,
        RouteServiceProvider::class,
    ];

    /**
     * Define module schedules.
     *
     * @param $schedule
     */
    // protected function configureSchedules(Schedule $schedule): void
    // {
    //     $schedule->command('inspire')->hourly();
    // }

    public function register(): void
    {
        $this->mergeConfigFrom(module_path('Paystack', 'config/config.php'), 'paystack');

        $this->app->singleton('payment.gateway.paystack', function () {
            return app(PaystackGateway::class);
        });
    }

    public function boot(): void
    {
        $this->publishes([
            module_path('Paystack', 'config/config.php') => config_path('paystack.php'),
        ], 'paystack-config');
    }
}
