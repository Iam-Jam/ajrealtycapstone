<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Property;
use App\Policies\PropertyPolicy;
use App\Models\PurchaseAgreement;
use App\Policies\PurchaseAgreementPolicy;
use App\Models\ListProperty;
use App\Policies\ListPropertyPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Property::class => PropertyPolicy::class,
        PurchaseAgreement::class => PurchaseAgreementPolicy::class,
        ListProperty::class => ListPropertyPolicy::class,
        ContactInquiry::class => ContactInquiryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define a gate for admin users
        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('view-submitted-forms', function ($user) {
            return true; // Allow all authenticated users
        });

        // Add new gate for property listing
        Gate::define('list-property', function ($user) {
            return in_array($user->type, ['admin', 'seller', 'agent1', 'agent2']);
        });

    }
}
