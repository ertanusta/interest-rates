<?php

namespace App\Providers;

use App\Interfaces\Repositories\BankRepositoryInterface;
use App\Interfaces\Repositories\InterestRateRepositoryInterface;
use App\Interfaces\Services\BankServiceInterface;
use App\Interfaces\Services\InterestRateServiceInterface;
use App\Models\InterestRate;
use App\Models\Log;
use App\Observers\InterestRateObserver;
use App\Repositories\BankRepoistory;
use App\Repositories\InterestRateRepository;
use App\Services\BankService;
use App\Services\InterestRateService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log as Logger;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        BankRepositoryInterface::class => BankRepoistory::class,
        BankServiceInterface::class => BankService::class,
        InterestRateRepositoryInterface::class => InterestRateRepository::class,
        InterestRateServiceInterface::class => InterestRateService::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        InterestRate::observe(InterestRateObserver::class);
        Logger::getLogger()->pushHandler(new class extends \Monolog\Handler\AbstractProcessingHandler {
            protected function write(array|\Monolog\LogRecord $record): void
            {
                Log::create([
                    'level' => $record['level_name'],
                    'message' => $record['message'],
                    'context' => json_encode($record['context']),
                ]);
            }

            public function isHandling(array|\Monolog\LogRecord $record): bool
            {
                return true; // Her log kaydını işle
            }
        });
    }
}
