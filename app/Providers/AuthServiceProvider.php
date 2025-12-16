<?php

namespace App\Providers;

use App\Models\ShippingDocument;
use App\Policies\ShippingDocumentPolicy;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ShippingDocument::class => ShippingDocumentPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register policies
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }

        // Listen for login events to update last login timestamp
        Event::listen(Login::class, function (Login $event) {
            if ($event->user) {
                $event->user->updateLastLogin();
            }
        });
    }
}
