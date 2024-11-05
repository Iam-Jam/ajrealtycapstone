<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Activity;
use App\Models\ContactInquiry;
use App\Models\ListProperty;
use App\Models\Appointment;
use App\Models\PurchaseAgreement;
use App\Models\PropertyDisclosure;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        try {
            $data = [
                // Basic Stats
                'totalProperties' => Property::count() + ListProperty::where('status', 'approved')->count(),
                'activeListings' => ListProperty::where('status', 'approved')->count(),
                'pendingInquiries' => ContactInquiry::where('status', 'pending')->count(),
                'totalUsers' => User::count(),

                // Listing Statistics
                'listingStats' => [
                    'pending' => ListProperty::where('status', 'pending')->count(),
                    'approved' => ListProperty::where('status', 'approved')->count(),
                    'featured' => ListProperty::where('is_featured', true)->count(),
                    'exclusive' => ListProperty::where('is_exclusive', true)->count()
                ],

                // Form Statistics
                'formStats' => [
                    'purchaseAgreements' => PurchaseAgreement::count(),
                    'propertyDisclosures' => PropertyDisclosure::count(),
                    'contactInquiries' => ContactInquiry::count(),
                ],

                // Recent Activities
                'recentActivities' => Activity::with('user')
                    ->latest()
                    ->take(5)
                    ->get(),

                // Appointments
                'appointments' => Appointment::with(['user', 'property'])
                    ->latest()
                    ->take(5)
                    ->get(),

                // Properties with pagination
                'properties' => Property::with(['images', 'user'])
                    ->latest()
                    ->paginate(10),

                // Users with pagination
                'users' => User::latest()
                    ->paginate(10),

                // Forms with pagination
                'forms' => $this->getAllForms(),

                // Monthly Statistics
                'monthlyStats' => $this->generateMonthlyStats(),
            ];

            return view('admin.dashboard', $data);

        } catch (\Exception $e) {
            Log::error('Dashboard Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('admin.dashboard')
                ->with('error', 'Error loading dashboard data. Please try again.')
                ->with($this->getBasicStats());
        }
    }

    public function getDashboardStats()
    {
        try {
            $stats = [
                'totalProperties' => Property::count() + ListProperty::where('status', 'approved')->count(),
                'activeListings' => ListProperty::where('status', 'approved')->count(),
                'pendingInquiries' => ContactInquiry::where('status', 'pending')->count(),
                'totalUsers' => User::count(),
                'formStats' => [
                    'purchaseAgreements' => PurchaseAgreement::count(),
                    'propertyDisclosures' => PropertyDisclosure::count(),
                    'contactInquiries' => ContactInquiry::count(),
                ]
            ];

            return response()->json($stats);

        } catch (\Exception $e) {
            Log::error('Dashboard Stats API Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Failed to fetch dashboard statistics'
            ], 500);
        }
    }

    private function getAllForms()
    {
        // Combine all form types into a single collection
        $purchaseAgreements = PurchaseAgreement::with('user')
            ->select('id', 'user_id', 'created_at', DB::raw("'purchase_agreement' as type"))
            ->latest();

        $propertyDisclosures = PropertyDisclosure::with('user')
            ->select('id', 'user_id', 'created_at', DB::raw("'property_disclosure' as type"))
            ->latest();

        $contactInquiries = ContactInquiry::with('user')
            ->select('id', 'user_id', 'created_at', DB::raw("'contact_inquiry' as type"))
            ->latest();

        return $purchaseAgreements
            ->union($propertyDisclosures)
            ->union($contactInquiries)
            ->latest()
            ->paginate(15);
    }

    private function generateMonthlyStats()
    {
        $months = collect(range(5, 0))->map(function($i) {
            return Carbon::now()->subMonths($i)->format('M Y');
        });

        return [
            'labels' => $months,
            'listings' => collect(range(5, 0))->map(function($i) {
                $date = Carbon::now()->subMonths($i);
                return ListProperty::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count();
            }),
            'inquiries' => collect(range(5, 0))->map(function($i) {
                $date = Carbon::now()->subMonths($i);
                return ContactInquiry::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count();
            }),
            'appointments' => collect(range(5, 0))->map(function($i) {
                $date = Carbon::now()->subMonths($i);
                return Appointment::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count();
            }),
        ];
    }

    private function getBasicStats()
    {
        return [
            'totalProperties' => Property::count(),
            'activeListings' => ListProperty::where('status', 'approved')->count(),
            'pendingInquiries' => ContactInquiry::where('status', 'pending')->count(),
            'totalUsers' => User::count(),
            'formStats' => [
                'purchaseAgreements' => PurchaseAgreement::count(),
                'propertyDisclosures' => PropertyDisclosure::count(),
                'contactInquiries' => ContactInquiry::count(),
            ],
            'listingStats' => [
                'pending' => ListProperty::where('status', 'pending')->count(),
                'approved' => ListProperty::where('status', 'approved')->count(),
                'featured' => ListProperty::where('is_featured', true)->count(),
                'exclusive' => ListProperty::where('is_exclusive', true)->count()
            ],
        ];
    }

    // API endpoints for handling CRUD operations
    public function updateListingStatus(Request $request, ListProperty $listing)
    {
        try {
            $listing->update(['status' => $request->status]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Listing Status Update Error:', [
                'listing_id' => $listing->id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Failed to update listing status'], 500);
        }
    }

    public function toggleFeatured(ListProperty $listing)
    {
        try {
            $listing->update(['is_featured' => !$listing->is_featured]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Toggle Featured Error:', [
                'listing_id' => $listing->id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Failed to toggle featured status'], 500);
        }
    }

    public function toggleExclusive(ListProperty $listing)
    {
        try {
            $listing->update(['is_exclusive' => !$listing->is_exclusive]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Toggle Exclusive Error:', [
                'listing_id' => $listing->id,
                'error' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Failed to toggle exclusive status'], 500);
        }
    }
}
