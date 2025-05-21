<?php

namespace App\Providers;

<<<<<<< HEAD
use Illuminate\Support\ServiceProvider;
=======
use App\Models\ProductReturn;
use Illuminate\Support\ServiceProvider;
use App\Models\ProductVariant;
use App\Models\ReturnDetail;
use App\Models\SaleDetail;
use App\Observers\InventoryLogObserver;
use App\Observers\ProductReturnObserver;
use App\Observers\ReturnDetailObserver;
use App\Observers\SaleDetailObserver;
use App\Models\Expense;
use App\Models\ProfitLoss;
use App\Observers\ExpenseObserver;
use App\Observers\ProfitLossObserver;

>>>>>>> 4087c472f0dfb0ce89c282d5665377c5a352a50a

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
<<<<<<< HEAD
        //
=======
        ProductVariant::observe(InventoryLogObserver::class);
        SaleDetail::observe(SaleDetailObserver::class);
        ReturnDetail::observe(ReturnDetailObserver::class);
        ProductReturn::observe(ProductReturnObserver::class);
        Expense::observe(ExpenseObserver::class);
        ProfitLoss::observe(ProfitLossObserver::class);
>>>>>>> 4087c472f0dfb0ce89c282d5665377c5a352a50a
    }
}
