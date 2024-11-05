<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\MarketInsightController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyDisclosureController;
use App\Http\Controllers\PurchaseAgreementController;
use App\Http\Controllers\ListPropertyController;
use App\Http\Controllers\ListPropertyImageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\DashboardController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/agents', [AgentController::class, 'index'])->name('agents');
Route::get('/market-insights', [MarketInsightController::class, 'index'])->name('market-insights');
Route::get('/list-sell-property', [ListPropertyController::class, 'listSellProperty'])->name('list-sell-property');
Route::get('/forms', [FormController::class, 'index'])->name('forms');
Route::get('/properties/search', [PropertyController::class, 'search'])->name('properties.search');
Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create')->middleware('auth');

// Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Legal pages
Route::get('/privacy-policy', [LegalController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/terms-of-service', [LegalController::class, 'termsOfService'])->name('terms-of-service');
Route::get('/cookie-policy', [LegalController::class, 'cookiePolicy'])->name('cookie-policy');

// Authentication Routes
Auth::routes(['verify' => false]);

// Email Verification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [RegisterController::class, 'verificationNotice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/resend', [RegisterController::class, 'resend'])->middleware('throttle:6,1')->name('verification.resend');
});

// Newsletter subscription
Route::post('/newsletter-subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');



Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');


Route::middleware(['auth'])->group(function () {
    // Contact Inquiry Routes
    Route::get('/profile/contact-inquiries/{contactInquiry}', [ProfileController::class, 'showContactInquiry'])
        ->name('profile.contact-inquiries.show');
    Route::get('/profile/contact-inquiries/{contactInquiry}/edit', [ProfileController::class, 'editContactInquiry'])
        ->name('profile.contact-inquiries.edit');
    Route::patch('/profile/contact-inquiries/{contactInquiry}', [ProfileController::class, 'updateContactInquiry'])
        ->name('profile.contact-inquiries.update');
    Route::delete('/profile/contact-inquiries/{contactInquiry}', [ProfileController::class, 'destroyContactInquiry'])
        ->name('profile.contact-inquiries.destroy');
});






//Appoinment

Route::middleware(['auth'])->group(function () {
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/user/submitted-forms', [AppointmentController::class, 'userSubmittedForms'])->name('user.submitted-forms');
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.update-status');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.delete');
    Route::get('/appointments/time-slots', [AppointmentController::class, 'getAvailableTimeSlots'])->name('appointments.time-slots');
});





// Forms routes
Route::prefix('forms')->name('forms.')->group(function () {

    Route::get('/', [FormController::class, 'index'])->name('index');
    Route::get('/listing-agreement', [FormController::class, 'listingAgreement'])->name('listing-agreement');
    Route::get('/property-disclosure', [FormController::class, 'propertyDisclosure'])->name('property-disclosure');
    Route::get('/purchase-agreement', [FormController::class, 'purchaseAgreement'])->name('purchase-agreement');
    Route::get('/buyers-agency', [FormController::class, 'buyersAgency'])->name('buyers-agency');
    Route::get('/rental-application', [FormController::class, 'rentalApplication'])->name('rental-application');
    Route::get('/lease-agreement', [FormController::class, 'leaseAgreement'])->name('lease-agreement');
    Route::get('/contact-inquiry', [FormController::class, 'contactInquiry'])->name('contact-inquiry');
    Route::get('/feedback', [FormController::class, 'feedback'])->name('feedback');
    Route::get('/pre-approval', [FormController::class, 'preApproval'])->name('pre-approval');
    Route::get('/digital-signature', [FormController::class, 'digitalSignature'])->name('digital-signature');
    Route::post('/{formType}', [FormController::class, 'submit'])->name('submit');
});





// Protected routes

Route::middleware(['auth'])->group(function () {
    // Appointment booking
    Route::post('/book-appointment', [AppointmentController::class, 'store'])->name('book.appointment');

    // User profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/submitted-forms', [ProfileController::class, 'submittedForms'])->name('profile.submitted-forms');

    // Listing routes
    Route::resource('listing-agreements', ListingController::class);
    Route::get('/listings/{listingAgreement}', [ListingController::class, 'show'])->name('listings.show');


    // PropertyDisclosure routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::resource('property-disclosures', PropertyDisclosureController::class);
        Route::post('/property-disclosures/{propertyDisclosure}/confirm-delete', [PropertyDisclosureController::class, 'confirmDelete'])->name('property-disclosures.confirm-delete');
    });

    // Purchase Agreement routes
    Route::resource('purchase-agreements', PurchaseAgreementController::class);
    Route::post('/purchase-agreements/{purchaseAgreement}/confirm-delete', [PurchaseAgreementController::class, 'confirmDelete'])->name('purchase-agreements.confirm-delete');


});


// Property routes
Route::prefix('properties')->group(function () {
    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/search', [PropertyController::class, 'apiSearch']);
    Route::get('/properties/search', [PropertyController::class, 'search'])->name('properties.search');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
    Route::get('/properties/{id}', [PropertyController::class, 'show'])->name('properties.show');


    // Protected routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
        Route::put('/{property}', [PropertyController::class, 'update'])->name('properties.update');
        Route::delete('/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
    });
});



// List/Sell Property Routes
Route::middleware(['auth'])->group(function () {
    // Basic CRUD routes
    Route::get('/list-sell-property', [ListPropertyController::class, 'listSellProperty'])
        ->name('list-sell-property');

    Route::get('/list-sell-property/create', [ListPropertyController::class, 'create'])
        ->name('list-sell-property.create');

    Route::post('/list-sell-property', [ListPropertyController::class, 'store'])
        ->name('list-sell-property.store');

    // Show route (removed duplicate)
    Route::get('/list-sell-property/{listProperty}', [ListPropertyController::class, 'show'])
        ->name('list-sell-property.show');

    Route::get('/list-sell-property/{listProperty}/edit', [ListPropertyController::class, 'edit'])
        ->name('list-sell-property.edit');

    Route::put('/list-sell-property/{listProperty}', [ListPropertyController::class, 'update'])
        ->name('list-sell-property.update');

    Route::delete('/list-sell-property/{listProperty}', [ListPropertyController::class, 'destroy'])
        ->name('list-sell-property.destroy');

  // Toggle status route
  Route::post('/list-sell-property/{listProperty}/toggle-status', [ListPropertyController::class, 'toggleStatus'])
  ->name('list-sell-property.toggle-status');

// Toggle featured/exclusive routes - Keep these route paths consistent
Route::post('/list-sell-property/{listProperty}/toggle-featured', [ListPropertyController::class, 'toggleFeatured'])
  ->name('toggle-featured');

Route::post('/list-sell-property/{listProperty}/toggle-exclusive', [ListPropertyController::class, 'toggleExclusive'])
  ->name('toggle-exclusive');



    Route::get('/admin/listings', [ListPropertyController::class, 'adminListings'])
        ->name('admin.listings');
    Route::get('/admin/pending-approvals', [ListPropertyController::class, 'pendingApprovals'])
        ->name('admin.pending-approvals');
    Route::post('/list-sell-property/{listProperty}/toggle-status', [ListPropertyController::class, 'toggleStatus'])
        ->name('list-sell-property.toggle-status');

});

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::resource('users', UserController::class);
    Route::resource('properties', PropertyController::class);

});







Route::post('/admin/properties/search', [PropertyController::class, 'apiAdminSearch'])
     ->name('admin.properties.search')
     ->middleware(['auth', 'admin']);

     Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            // Admin property routes
            Route::get('/properties/search', [PropertyController::class, 'adminSearch'])->name('admin.properties.search');
            Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('admin.properties.show');
            Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('admin.properties.update');
            Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('admin.properties.destroy');
        });

        Route::middleware(['auth', 'admin'])->group(function () {
            Route::resource('admin/users', UserManagementController::class)->names('admin.users');
        });



        // routes/web.php



Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

});


