<?php

namespace App\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Task\Repositories\TaskRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\TaskRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
