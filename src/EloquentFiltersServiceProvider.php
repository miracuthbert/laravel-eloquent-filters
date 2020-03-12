<?php

namespace Miracuthbert\Filters;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Miracuthbert\Filters\Console\FilterMakeCommand;
use Miracuthbert\Filters\Console\FilterModelCommand;

class EloquentFiltersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->configure();

        $this->registerFacade();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishing();

        $this->registerCommands();

        $this->paginationResolver();
    }

    /**
     * Setup configuration for the package.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel-filters.php', 'filters'
        );
    }

    /**
     * Register the package's facade.
     *
     * @return void
     */
    protected function registerFacade()
    {
        $this->app->singleton(Filters::class, function ($app) {
            return new Filters();
        });

        $this->app->alias(Filters::class, 'filters');
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {

            // publish config
            $this->publishes([
                __DIR__ . '/../config/laravel-filters.php' => config_path('filters.php'),
            ], 'filters-config');
        }
    }

    /**
     * Register the package's commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FilterMakeCommand::class,
                FilterModelCommand::class,
            ]);
        }
    }

    /**
     * Resolve pagination for filters.
     *
     * @return void
     */
    protected function paginationResolver()
    {
        if (config('filters.pagination.append_filter_query', false)) {
            $this->app->resolving(LengthAwarePaginator::class, function ($paginator) {
                return $paginator->appends(filters_query([
                        $paginator->getPageName()
                    ])
                );
            });

            $this->app->resolving(Paginator::class, function ($paginator) {
                return $paginator->appends(filters_query([
                        $paginator->getPageName()
                    ])
                );
            });
        }
    }
}
