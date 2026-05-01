<?php

namespace Modules\Flutterwave\Providers;

use Modules\Flutterwave\Services\FlutterwaveGateway;
use Nwidart\Modules\Support\ModuleServiceProvider;
use Modules\PaymentCore\Enums\PaymentConfig;

class FlutterwaveServiceProvider extends ModuleServiceProvider
{
    /**
     * The name of the module.
     */
    protected string $name = 'Flutterwave';

    /**
     * The lowercase version of the module name.
     */
    protected string $nameLower = 'flutterwave';

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
        $this->mergeConfigFrom(module_path('Flutterwave', 'config/config.php'), 'flutterwave');

        $this->app->singleton(PaymentConfig::FLUTTER_GATEWAY_CLASS->value, function () {
            return app(FlutterwaveGateway::class);
        });
    }
}
