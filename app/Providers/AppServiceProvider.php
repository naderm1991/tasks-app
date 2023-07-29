<?php

namespace App\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;
use Nette\Utils\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        \Illuminate\Pagination\Paginator::defaultView('pagination');

        Builder::macro('orderByNullsLast', function ($column, $direction = 'asc') {
            $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';
            return $this->orderByRaw("{$column} IS NULL, {$column} {$direction}");
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
