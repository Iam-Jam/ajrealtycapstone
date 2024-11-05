<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use App\View\Components\PropertyCard;
use App\Filament\Resources\PropertyResource;
use App\Filament\Resources\ListPropertyResource;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\ContactInquiryResource;
use Filament\Facades\Filament;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::component('property-card', PropertyCard::class);

        View::composer('*', function ($view) {
            $formCategories = [
                'For Sellers' => [
                    'listing-agreement' => 'Listing Agreement',
                    'property-disclosure' => 'Property Disclosure Statement',
                ],
                'For Buyers' => [
                    'purchase-agreement' => 'Purchase Agreement',

                ],

                'For Viewers' => [
                    'contact-inquiry' => 'Contact/Inquiry Form',

                ],

            ];
            $view->with('formCategories', $formCategories);
        });

     
    }
}
