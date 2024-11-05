<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\ListProperty;
use App\Models\User;
use App\Models\Activity;
use App\Http\Requests\PropertyRequest;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected $propertyService;

    public function index()
    {
        try {
            // Fetch all properties with their images
            $properties = Property::with(['images'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Also fetch list properties if you're handling both types
            $listProperties = ListProperty::with(['images'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($property) {
                    return $this->transformListPropertyToProperty($property);
                });

            // Merge both collections if you're handling both types
            $allProperties = $properties->concat($listProperties);

            return view('admin.dashboard.properties-management', [
                'properties' => $allProperties
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching properties:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('admin.dashboard.properties-management', [
                'properties' => collect([])
            ])->with('error', 'Failed to load properties.');
        }
    }

    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function dashboard()
    {
        // Existing dashboard stats
        $totalUsers = User::count();
        $totalProperties = ListProperty::count();
        $activeListings = ListProperty::where('status', 'approved')->count();
        $recentActivities = Activity::with('user')->latest()->take(10)->get();

        // Get all properties with their relationships
        $dbProperties = Property::with(['images'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($property) {
                return [
                    'id' => $property->id,
                    'title' => $property->title,
                    'description' => $property->description,
                    'price' => $property->price,
                    'location' => $property->location,
                    'city' => $property->city,
                    'property_type' => $property->property_type,
                    'bedrooms' => $property->bedrooms ?? $property->beds,
                    'bathrooms' => $property->bathrooms ?? $property->baths,
                    'area_sqm' => $property->area_sqm ?? $property->sqm,
                    'image' => $property->image ? asset($property->image) : null,
                    'images' => $property->images->map(function($image) {
                        return [
                            'id' => $image->id,
                            'image_path' => asset($image->image_path)
                        ];
                    }),
                    'status' => $property->status,
                    'is_featured' => (bool)$property->is_featured,
                    'is_exclusive' => (bool)$property->is_exclusive,
                    'contact_whatsapp' => $property->contact_whatsapp,
                    'contact_messenger' => $property->contact_messenger,
                    'contact_email' => $property->contact_email,
                    'swimming_pool' => (bool)$property->swimming_pool,
                    'gym_access' => (bool)$property->gym_access,
                    'living_room' => (bool)$property->living_room,
                    'dining_room' => (bool)$property->dining_room,
                    'original_source' => 'database'
                ];
            });

        // Get list properties
        $listProperties = ListProperty::with(['images'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($property) {
                return [
                    'id' => $property->id,
                    'title' => $property->title,
                    'description' => $property->description,
                    'price' => $property->price,
                    'location' => $property->city,
                    'city' => $property->city,
                    'property_type' => $property->type,
                    'bedrooms' => $property->bedrooms,
                    'bathrooms' => $property->bathrooms,
                    'area_sqm' => $property->sqm,
                    'image' => $property->images->first() ? asset($property->images->first()->image_path) : null,
                    'images' => $property->images->map(function($image) {
                        return [
                            'id' => $image->id,
                            'image_path' => asset($image->image_path)
                        ];
                    }),
                    'status' => $property->status,
                    'is_featured' => (bool)$property->is_featured,
                    'is_exclusive' => (bool)$property->is_exclusive,
                    'contact_whatsapp' => $property->contact_whatsapp,
                    'contact_messenger' => $property->contact_messenger,
                    'contact_email' => $property->contact_email,
                    'swimming_pool' => (bool)$property->swimming_pool,
                    'gym_access' => (bool)$property->gym_access,
                    'living_room' => (bool)$property->living_room,
                    'dining_room' => (bool)$property->dining_room,
                    'original_source' => 'list_sell'
                ];
            });

        // Merge both collections
        $properties = $dbProperties->concat($listProperties);

        // Form stats
        $formStats = [
            'purchaseAgreements' => 0,
            'propertyDisclosures' => 0,
            'contactInquiries' => 0
        ];

        $pendingInquiries = 0;

        // Add routes for CRUD operations
        $routes = [
            'search' => route('admin.properties.search'),
            'toggleStatus' => '/admin/properties/:id/toggle-status',
            'toggleFeatured' => '/admin/properties/:id/toggle-featured',
            'toggleExclusive' => '/admin/properties/:id/toggle-exclusive',
            'edit' => '/admin/properties/:id/edit',
            'delete' => '/admin/properties/:id'
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProperties',
            'activeListings',
            'recentActivities',
            'pendingListings',
            'approvedListings',
            'properties',
            'formStats',
            'pendingInquiries',
            'routes'
        ));
    }

    // Add these methods for CRUD operations
    public function searchProperties(Request $request)
    {
        try {
            $query = Property::with(['images']);

            if ($request->filled('property_id')) {
                $query->where('id', $request->property_id);
            }

            if ($request->filled('type')) {
                $query->where('property_type', $request->type);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $properties = $query->get()->map(function($property) {
                // Map properties using the same structure as in dashboard method
                // ... (use the same mapping as above)
            });

            // Also search list properties
            $listQuery = ListProperty::with(['images']);

            if ($request->filled('property_id')) {
                $listQuery->where('id', $request->property_id);
            }

            if ($request->filled('type')) {
                $listQuery->where('type', $request->type);
            }

            if ($request->filled('status')) {
                $listQuery->where('status', $request->status);
            }

            $listProperties = $listQuery->get()->map(function($property) {
                // Map list properties using the same structure as in dashboard method
                // ... (use the same mapping as above)
            });

            $allProperties = $properties->concat($listProperties);

            return response()->json($allProperties);
        } catch (\Exception $e) {
            Log::error('Property search error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Search failed'], 500);
        }
    }

    // Add other necessary methods for toggleStatus, toggleFeatured, toggleExclusive, etc.

    public function propertiesIndex()
    {
        $properties = $this->propertyService->getAllProperties();
        return view('admin.properties.index', compact('properties'));
    }

    public function propertiesCreate()
    {
        return view('admin.properties.create');
    }

    public function propertiesStore(PropertyRequest $request)
    {
        try {
            $property = $this->propertyService->createProperty($request->validated());

            Log::info('Property created successfully', [
                'property_id' => $property->id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.properties.index')
                             ->with('success', 'Property created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create property', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Failed to create property. ' . $e->getMessage());
        }
    }

    public function propertiesEdit(Property $property)
    {
        return view('admin.properties.edit', compact('property'));
    }

    public function propertiesUpdate(PropertyRequest $request, Property $property)
    {
        try {
            $this->propertyService->updateProperty($property, $request->validated());

            Log::info('Property updated successfully', [
                'property_id' => $property->id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.properties.index')
                             ->with('success', 'Property updated successfully');
        } catch (\Exception $e) {
            Log::error('Failed to update property', [
                'property_id' => $property->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Failed to update property. ' . $e->getMessage());
        }
    }

    public function propertiesDestroy(Property $property)
    {
        try {
            $this->propertyService->deleteProperty($property);

            Log::info('Property deleted successfully', [
                'property_id' => $property->id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.properties.index')
                             ->with('success', 'Property deleted successfully');
        } catch (\Exception $e) {
            Log::error('Failed to delete property', [
                'property_id' => $property->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Failed to delete property. ' . $e->getMessage());
        }
    }

    // New property management methods
    public function togglePropertyStatus(ListProperty $property)
    {
        try {
            $property->status = $property->status === 'pending' ? 'approved' : 'pending';
            $property->approved_at = $property->status === 'approved' ? now() : null;
            $property->save();

            Log::info('Property status toggled successfully', [
                'property_id' => $property->id,
                'new_status' => $property->status,
                'user_id' => auth()->id()
            ]);

            return back()->with('success', 'Property status updated successfully');
        } catch (\Exception $e) {
            Log::error('Failed to toggle property status', [
                'property_id' => $property->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Failed to update property status.');
        }
    }

    public function togglePropertyFeatured(ListProperty $property)
    {
        try {
            $property->is_featured = !$property->is_featured;
            $property->save();

            Log::info('Property featured status toggled successfully', [
                'property_id' => $property->id,
                'is_featured' => $property->is_featured,
                'user_id' => auth()->id()
            ]);

            return back()->with('success', 'Featured status updated successfully');
        } catch (\Exception $e) {
            Log::error('Failed to toggle property featured status', [
                'property_id' => $property->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Failed to update featured status.');
        }
    }

    public function togglePropertyExclusive(ListProperty $property)
    {
        try {
            $property->is_exclusive = !$property->is_exclusive;
            $property->save();

            Log::info('Property exclusive status toggled successfully', [
                'property_id' => $property->id,
                'is_exclusive' => $property->is_exclusive,
                'user_id' => auth()->id()
            ]);

            return back()->with('success', 'Exclusive status updated successfully');
        } catch (\Exception $e) {
            Log::error('Failed to toggle property exclusive status', [
                'property_id' => $property->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return back()->with('error', 'Failed to update exclusive status.');
        }
    }
}
