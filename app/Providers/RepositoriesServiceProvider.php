<?php

namespace App\Providers;

use App\Repositories\Eloquent\EloquentTaskRepository;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    
    public $bindings = [
        'App\Repositories\Interfaces\TaskRepositoryInterface' => 'App\Repositories\Eloquent\EloquentTaskRepository',
        'App\Repositories\Interfaces\UserRepositoryInterface' => 'App\Repositories\Eloquent\EloquentUserRepository',
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, EloquentTaskRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }
}
