<?php
declare(strict_types=1);

namespace App\Providers;

use App\Events\EmailSent;
use App\Listeners\EmailNotification;
use App\Models\UserModel;
use App\Observers\UserObserver;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        EmailSent::class => [
            EmailNotification::class,
        ],
    ];

    public function boot()
    {
        UserModel::observe(UserObserver::class);

        parent::boot();
    }
}
