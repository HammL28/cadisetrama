<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\ItemPenjualan;

// Impor Policy dari namespace App\Policies
use App\Policies\DashboardPolicy;
use App\Policies\PenjualanPolicy;
use App\Policies\ProdukPolicy;
use App\Policies\ItemPenjualanPolicy; // <-- Diperbaiki di sini

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class          => DashboardPolicy::class,
        Produk::class        => ProdukPolicy::class,
        Penjualan::class     => PenjualanPolicy::class,
        ItemPenjualan::class => ItemPenjualanPolicy::class,
    ];

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
        Paginator::useBootstrapFive();
        Carbon::setLocale('id');
        $this->registerPolicies();
    }
}