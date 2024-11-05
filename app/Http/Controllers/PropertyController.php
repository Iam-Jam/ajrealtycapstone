<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\ListProperty;
use App\Http\Requests\PropertyRequest;
use App\Services\PropertyService;
use App\Http\Resources\PropertyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
        $this->authorizeResource(Property::class, 'property');
    }

    /**
     * Display the property listing page with featured and exclusive properties
     */
    public function index()
    {
        try {
            // Get featured properties from main Property model
            $featuredDbProperties = Property::with('images')
                ->where('is_featured', true)
                ->latest()
                ->get();

            // Get featured properties from approved ListProperty
            $featuredListProperties = ListProperty::with('images')
                ->where('status', 'approved')
                ->where('is_featured', true)
                ->latest()
                ->get()
                ->map(function ($property) {
                    return $this->transformListPropertyToProperty($property);
                });

            // Merge featured properties
            $featuredProperties = $featuredDbProperties
                ->concat($featuredListProperties)
                ->take(6);

            // Get exclusive properties from the hardcoded list
            $exclusiveHardcodedProperties = collect($this->getExclusiveProperties());

            // Get exclusive properties from approved ListProperty
            $exclusiveListProperties = ListProperty::with('images')
                ->where('status', 'approved')
                ->where('is_exclusive', true)
                ->latest()
                ->get()
                ->map(function ($property) {
                    return $this->transformListPropertyToPropertyArray($property);
                });

            // Merge exclusive properties
            $exclusiveProperties = $exclusiveHardcodedProperties->concat($exclusiveListProperties);

            return view('properties.index', compact('featuredProperties', 'exclusiveProperties'));

        } catch (\Exception $e) {
            Log::error('Error in property index', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('properties.index')->with('error', 'An error occurred while loading properties.');
        }
    }

    /**
     * Transform ListProperty model to match Property model structure
     */
    private function transformListPropertyToProperty($listProperty)
    {
        $property = new Property();

        // Map basic fields
        $property->id = $listProperty->id;
        $property->title = $listProperty->title;
        $property->description = $listProperty->description;
        $property->price = $listProperty->price;
        $property->property_type = $listProperty->type;
        $property->city = $listProperty->city;
        $property->location = $listProperty->city; // Using city as location
        $property->property_address = $listProperty->property_address;
        $property->beds = $listProperty->bedrooms; // Support for both beds and bedrooms
        $property->bedrooms = $listProperty->bedrooms;
        $property->baths = $listProperty->bathrooms; // Support for both baths and bathrooms
        $property->bathrooms = $listProperty->bathrooms;
        $property->sqm = $listProperty->sqm;
        $property->area_sqm = $listProperty->sqm; // Support for both sqm and area_sqm

        // Map amenities
        $property->swimming_pool = $listProperty->swimming_pool;
        $property->gym_access = $listProperty->gym_access;
        $property->living_room = $listProperty->living_room;
        $property->dining_room = $listProperty->dining_room;

        // Map contact information
        $property->contact_email = $listProperty->contact_email;
        $property->contact_messenger = $listProperty->contact_messenger;
        $property->contact_whatsapp = $listProperty->contact_whatsapp;

        // Map status and flags
        $property->is_featured = $listProperty->is_featured;
        $property->is_exclusive = $listProperty->is_exclusive;
        $property->status = 'for_sale';

        // Handle images
        if ($listProperty->images && $listProperty->images->isNotEmpty()) {
            $primaryImage = $listProperty->images->where('is_primary', true)->first()
                          ?? $listProperty->images->first();

            $property->image = 'storage/' . $primaryImage->image_path;

            // Transform all images for the relationship
            $transformedImages = $listProperty->images->map(function($image) {
                return (object)[
                    'id' => $image->id,
                    'property_id' => $image->property_id,
                    'image_path' => 'storage/' . $image->image_path,
                    'is_primary' => $image->is_primary
                ];
            });

            $property->setRelation('images', $transformedImages);
        }


       // Add source identification
            $property->list_property_id = $listProperty->id;
            $property->original_source = 'list_sell';


        return $property;
    }

    /**
     * Transform ListProperty model to match exclusive properties array structure
     */
    private function transformListPropertyToPropertyArray($listProperty)
    {
        // Get primary image or first image
        $primaryImage = $listProperty->images
            ->where('is_primary', true)
            ->first() ?? $listProperty->images->first();



        return [
            'id' => $listProperty->id,
            'title' => $listProperty->title,
            'description' => $listProperty->description,
            'price' => $listProperty->price,
            'property_type' => $listProperty->type,
            'city' => $listProperty->city,
            'location' => $listProperty->city,
            'beds' => $listProperty->bedrooms,
            'bedrooms' => $listProperty->bedrooms,
            'baths' => $listProperty->bathrooms,
            'bathrooms' => $listProperty->bathrooms,
            'sqm' => $listProperty->sqm,
            'area_sqm' => $listProperty->sqm,
            'image' => $primaryImage ? 'storage/' . $primaryImage->image_path : null,
            'images' => $listProperty->images->map(function($img) {
                return [
                    'id' => $img->id,
                    'image_path' => 'storage/' . $img->image_path,
                    'is_primary' => $img->is_primary
                ];
            })->toArray(),
            'property_address' => $listProperty->property_address,
            'contact_email' => $listProperty->contact_email,
            'contact_messenger' => $listProperty->contact_messenger,
            'contact_whatsapp' => $listProperty->contact_whatsapp,
            'swimming_pool' => $listProperty->swimming_pool,
            'gym_access' => $listProperty->gym_access,
            'living_room' => $listProperty->living_room,
            'dining_room' => $listProperty->dining_room,
            'is_featured' => $listProperty->is_featured,
            'is_exclusive' => $listProperty->is_exclusive,
            'status' => 'for_sale',
            'list_property_id' => $listProperty->id,
            'original_source' => 'list_sell',
        ];



    }

    /**
     * Search properties based on criteria
     */

     public function search(Request $request)
    {
        try {
            if ($request->filled('search')) {
                $searchTerm = strtolower($request->search);

                // Query the database including images
                $searchResults = Property::with('images')
                    ->where(function($query) use ($searchTerm) {
                        $query->where('title', 'LIKE', "%{$searchTerm}%")
                              ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                              ->orWhere('location', 'LIKE', "%{$searchTerm}%")
                              ->orWhere('city', 'LIKE', "%{$searchTerm}%")
                              ->orWhere('type', 'LIKE', "%{$searchTerm}%")
                              ->orWhere('property_type', 'LIKE', "%{$searchTerm}%");
                    })
                    ->paginate(9)
                    ->withQueryString();

                // Get exclusive properties and filter them
                $exclusiveProperties = collect($this->getExclusiveProperties())
                    ->filter(function ($property) use ($searchTerm) {
                        return str_contains(strtolower($property['title']), $searchTerm) ||
                               str_contains(strtolower($property['description']), $searchTerm) ||
                               str_contains(strtolower($property['location']), $searchTerm) ||
                               str_contains(strtolower($property['property_type']), $searchTerm);
                    });

                return view('properties.index', [
                    'searchResults' => $searchResults,
                    'exclusiveProperties' => $exclusiveProperties,
                    'featuredProperties' => collect([]), // Empty when searching
                    'searchPerformed' => true
                ]);
            }

            return $this->index();

        } catch (\Exception $e) {
            Log::error('Search error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'An error occurred while searching properties.');
        }
    }

   /**
 * Display property details
 */
public function show(Property $property): View
{
    try {
        // Check if the property is from exclusive list
        $exclusiveProperties = collect($this->getExclusiveProperties());
        $isExclusive = $exclusiveProperties->contains('id', $property->id);

        if ($isExclusive) {
            $propertyData = $exclusiveProperties->firstWhere('id', $property->id);
            // Convert array to object for consistent view handling
            $property = json_decode(json_encode($propertyData));
        }

        // Get similar properties
        $similarProperties = Property::where('status', 'for_sale')
            ->where('id', '!=', $property->id)
            ->where('property_type', $property->property_type)
            ->take(3)
            ->get();

        return view('properties.show', [
            'property' => $property,
            'similarProperties' => $similarProperties,
            'isExclusive' => $isExclusive
        ]);

    } catch (\Exception $e) {
        Log::error('Error showing property details', [
            'property_id' => $property->id,
            'error' => $e->getMessage()
        ]);

        return view('properties.index')->with('error', 'An error occurred while loading property details.');
    }
}

    /**
     * Show property edit form
     */
    public function edit(Property $property): View
    {
        // Check if property is exclusive before allowing edit
        $exclusiveProperties = collect($this->getExclusiveProperties());
        if ($exclusiveProperties->contains('id', $property->id)) {
            return back()->with('error', 'Exclusive properties cannot be edited.');
        }

        return view('properties.edit', compact('property'));
    }

    /**
     * Update property details
     */
    public function update(PropertyRequest $request, Property $property): RedirectResponse
    {
        try {
            // Check if property is exclusive before allowing update
            $exclusiveProperties = collect($this->getExclusiveProperties());
            if ($exclusiveProperties->contains('id', $property->id)) {
                return back()->with('error', 'Exclusive properties cannot be updated.');
            }

            $this->propertyService->updateProperty($property, $request->validated());
            return redirect()->route('properties.show', $property)
                           ->with('success', 'Property updated successfully');

        } catch (\Exception $e) {
            Log::error('Failed to update property', [
                'property_id' => $property->id,
                'error' => $e->getMessage()
            ]);

            return back()->withInput()
                        ->with('error', 'Failed to update property. Please try again.');
        }
    }

    /**
     * Delete property
     */
    public function destroy(Property $property): RedirectResponse
    {
        try {
            // Check if property is exclusive before allowing deletion
            $exclusiveProperties = collect($this->getExclusiveProperties());
            if ($exclusiveProperties->contains('id', $property->id)) {
                return back()->with('error', 'Exclusive properties cannot be deleted.');
            }

            $this->propertyService->deleteProperty($property);
            return redirect()->route('properties.index')
                           ->with('success', 'Property deleted successfully');

        } catch (\Exception $e) {
            Log::error('Failed to delete property', [
                'property_id' => $property->id,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Failed to delete property. Please try again.');
        }
    }

    /**
     * Get exclusive properties data
     */
    private function getExclusiveProperties(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Luxurious Makati Penthouse',
                'description' => 'Experience unparalleled luxury in this stunning penthouse with panoramic city views',
                'price' => 75000000,
                'property_type' => 'penthouse',
                'city' => 'Makati City',
                'beds' => 4,
                'baths' => 5,
                'area_sqm' => 350,
                'image' => 'uploads/uploads/property9.jpg',
                'featured' => true,
                'location' => 'Makati City, Metro Manila',
                'property_address' => '123 Ayala Avenue, Makati City, 1226 Metro Manila',
                'bedrooms' => 4,
                'bathrooms' => 5,
                'sqm' => 350,
                'type' => 'condominium',
                'contact_email' => 'makatiluxury@example.com',
                'contact_messenger' => 'https://m.me/makatiluxury',
                'contact_whatsapp' => '+639123456789',
                'swimming_pool' => true,
                'gym_access' => true,
                'living_room' => true,
                'dining_room' => true,
                'additional_features' => 'Private elevator, Smart home system, Wine cellar',
                'lot_size' => null,
                'is_featured' => true,
                'is_exclusive' => true,
                'status' => 'for_sale',
            ],
            [
                'id' => 2,
                'title' => 'Contemporary Condo Suite',
                'description' => 'Experience the pinnacle of urban living in this sleek, stunning condo.',
                'price' => 25000000,
                'property_type' => 'condominium',
                'city' => 'Taguig City',
                'beds' => 2,
                'baths' => 2,
                'area_sqm' => 111,
                'image' => 'uploads/uploads/property8.jpg',
                'featured' => true,
                'location' => 'Bonifacio Global City, Taguig',
                'property_address' => '456 High Street, BGC, Taguig City, 1634 Metro Manila',
                'bedrooms' => 2,
                'bathrooms' => 2,
                'sqm' => 111,
                'type' => 'condominium',
                'contact_email' => 'bgccondo@example.com',
                'contact_messenger' => 'https://m.me/bgccondo',
                'contact_whatsapp' => '+639234567890',
                'swimming_pool' => true,
                'gym_access' => true,
                'living_room' => true,
                'dining_room' => true,
                'additional_features' => 'Concierge Service, Rooftop Lounge',
                'lot_size' => null,
                'is_featured' => true,
                'is_exclusive' => true,
                'status' => 'for_sale',
            ],
            [
                'id' => 3,
                'title' => 'Exquisite Mansion',
                'description' => 'Indulge in luxury living with this exquisite mansion. From its awe-inspiring views to its premium features.',
                'price' => 75000000,
                'property_type' => 'mansion',
                'city' => 'Quezon City',
                'beds' => 6,
                'baths' => 7,
                'area_sqm' => 500,
                'image' => 'uploads/uploads/property7.jpg',
                'featured' => true,
                'location' => 'Quezon City, Metro Manila',
                'property_address' => '789 Commonwealth Avenue, Quezon City, 1121 Metro Manila',
                'bedrooms' => 6,
                'bathrooms' => 7,
                'sqm' => 500,
                'type' => 'house_and_lot',
                'contact_email' => 'luxurymansion@example.com',
                'contact_messenger' => 'https://m.me/luxurymansion',
                'contact_whatsapp' => '+639345678901',
                'swimming_pool' => true,
                'gym_access' => true,
                'living_room' => true,
                'dining_room' => true,
                'additional_features' => 'Home Theater, Wine Cellar, Expansive Garden',
                'lot_size' => 1000,
                'is_featured' => true,
                'is_exclusive' => true,
                'status' => 'for_sale',
            ],
            [
                'id' => 4,
                'title' => 'Urban Loft Retreat',
                'description' => 'Discover the epitome of urban living in this stunning loft.',
                'price' => 20000000,
                'property_type' => 'loft',
                'city' => 'Makati City',
                'beds' => 1,
                'baths' => 2,
                'area_sqm' => 100,
                'image' => 'uploads/uploads/property11.jpg',
                'featured' => true,
                'location' => 'Makati City, Metro Manila',
                'property_address' => '101 Urban Street, Makati City, 1229 Metro Manila',
                'bedrooms' => 1,
                'bathrooms' => 2,
                'sqm' => 100,
                'type' => 'condominium',
                'contact_email' => 'urbanloft@example.com',
                'contact_messenger' => 'https://m.me/urbanloft',
                'contact_whatsapp' => '+639456789012',
                'swimming_pool' => false,
                'gym_access' => true,
                'living_room' => true,
                'dining_room' => true,
                'additional_features' => 'High Ceilings, Industrial Design, City View',
                'lot_size' => null,
                'is_featured' => true,
                'is_exclusive' => true,
                'status' => 'for_sale',
            ],
            [
                'id' => 5,
                'title' => 'Elegant Penthouse Suite',
                'description' => 'Sleek and stylish penthouse in the heart of the city with stunning skyline views.',
                'price' => 40000000,
                'property_type' => 'penthouse',
                'city' => 'Taguig City',
                'beds' => 3,
                'baths' => 3,
                'area_sqm' => 200,
                'image' => 'uploads/uploads/property4.jpg',
                'featured' => true,
                'location' => 'Bonifacio Global City, Taguig',
                'property_address' => '789 Skyscraper Avenue, BGC, Taguig City, 1634 Metro Manila',
                'bedrooms' => 3,
                'bathrooms' => 3,
                'sqm' => 200,
                'type' => 'condominium',
                'contact_email' => 'elegantpenthouse@example.com',
                'contact_messenger' => 'https://m.me/elegantpenthouse',
                'contact_whatsapp' => '+639567890123',
                'swimming_pool' => true,
                'gym_access' => true,
                'living_room' => true,
                'dining_room' => true,
                'additional_features' => 'Private Terrace, 360-degree City View, Smart Home Features',
                'lot_size' => null,
                'is_featured' => true,
                'is_exclusive' => true,
                'status' => 'for_sale',
            ],
            [
                'id' => 6,
                'title' => 'Chic City Apartment',
                'description' => 'Immerse yourself in urban sophistication with this contemporary apartment.',
                'price' => 15000000,
                'property_type' => 'apartment',
                'city' => 'Manila',
                'beds' => 2,
                'baths' => 1,
                'area_sqm' => 80,
                'image' => 'uploads/uploads/property10.jpg',
                'featured' => true,
                'location' => 'Malate, Manila',
                'property_address' => '567 Adriatico Street, Malate, Manila, 1004 Metro Manila',
                'bedrooms' => 2,
                'bathrooms' => 1,
                'sqm' => 80,
                'type' => 'apartment',
                'contact_email' => 'chiccity@example.com',
                'contact_messenger' => 'https://m.me/chiccity',
                'contact_whatsapp' => '+639678901234',
                'swimming_pool' => false,
                'gym_access' => true,
                'living_room' => true,
                'dining_room' => true,
                'additional_features' => 'Modern Kitchen, Walk-in Closet, City View',
                'lot_size' => null,
                'is_featured' => true,
                'is_exclusive' => true,
                'status' => 'for_sale',
            ],
            [
                'id' => 7,
                'title' => 'Contemporary Townhouse',
                'description' => 'Experience modern living in this stylish townhouse featuring state-of-the-art amenities.',
                'price' => 30000000,
                'property_type' => 'townhouse',
                'city' => 'Pasig City',
                'beds' => 3,
                'baths' => 3,
                'area_sqm' => 150,
                'image' => 'uploads/uploads/property14.png',
                'featured' => true,
                'location' => 'Pasig City, Metro Manila',
                'property_address' => '123 Townhouse Lane, Pasig City, 1600 Metro Manila',
                'bedrooms' => 3,
                'bathrooms' => 3,
                'sqm' => 150,
                'type' => 'townhouse',
                'contact_email' => 'contemporarytownhouse@example.com',
                'contact_messenger' => 'https://m.me/contemporarytownhouse',
                'contact_whatsapp' => '+639789012345',
                'swimming_pool' => true,
                'gym_access' => true,
                'living_room' => true,
                'dining_room' => true,
                'additional_features' => 'Roof Deck, Smart Home Features, Gated Community',
                'lot_size' => 100,
                'is_featured' => true,
                'is_exclusive' => true,
                'status' => 'for_sale',
            ],
            [
                'id' => 8,
                'title' => 'Exclusive Sky Residence',
                'description' => 'Elevate your lifestyle in this magnificent sky residence. From its awe-inspiring views to its premium features, every aspect is crafted to deliver an extraordinary living experience.',
                'price' => 60000000,
                'property_type' => 'penthouse',
                'city' => 'Makati City',
                'beds' => 4,
                'baths' => 4,
                'area_sqm' => 300,
                'image' => 'uploads/uploads/property15.png',
                'featured' => true,
                'location' => 'Makati City, Metro Manila',
                'property_address' => '888 Skyline Boulevard, Makati City, 1229 Metro Manila',
                'bedrooms' => 4,
                'bathrooms' => 4,
                'sqm' => 300,
                'type' => 'condominium',
                'contact_email' => 'skyresidence@example.com',
                'contact_messenger' => 'https://m.me/skyresidence',
                'contact_whatsapp' => '+639890123456',
                'swimming_pool' => true,
                'gym_access' => true,
                'living_room' => true,
                'dining_room' => true,
                'additional_features' => 'Private Elevator, Panoramic Views, Home Automation',
                'lot_size' => null,
                'is_featured' => true,
                'is_exclusive' => true,
                'status' => 'for_sale',
            ],
            [
                'id' => 9,
                'title' => 'Serene Garden Estate',
                'description' => 'Immerse yourself in the tranquility of this garden estate. Enjoy lush greenery and premium amenities in a highly sought-after location.',
                'price' => 80000000,
                'property_type' => 'house',
                'city' => 'Antipolo',
                'beds' => 5,
                'baths' => 6,
                'area_sqm' => 500,
                'image' => 'uploads/uploads/property16.png',
                'featured' => true,
                'location' => 'Antipolo, Rizal',
                'property_address' => '777 Hillside Drive, Antipolo, 1870 Rizal',
                'bedrooms' => 5,
                'bathrooms' => 6,
                'sqm' => 500,
                'type' => 'house_and_lot',
                'contact_email' => 'gardenestate@example.com',
                'contact_messenger' => 'https://m.me/gardenestate',
                'contact_whatsapp' => '+639901234567',
                'swimming_pool' => true,
                'gym_access' => true,
                'living_room' => true,
                'dining_room' => true,
                'additional_features' => 'Expansive Gardens, Outdoor Kitchen, Mountain View',
                'lot_size' => 2000,
                'is_featured' => true,
                'is_exclusive' => true,
                'status' => 'for_sale',
            ]
        ];
    }

    /**
     * API endpoints for mobile/frontend applications
     */
    public function apiIndex()
    {
        try {
            // Get database properties
            $dbProperties = Property::with(['images', 'user'])
                                  ->where('status', 'for_sale')
                                  ->get();

            // Get exclusive properties and convert to collection
            $exclusiveProperties = collect($this->getExclusiveProperties())
                ->map(function ($property) {
                    return (object) $property;
                });

            // Merge and paginate all properties
            $allProperties = $dbProperties->concat($exclusiveProperties)
                                        ->sortByDesc('created_at')
                                        ->paginate(20);

            return PropertyResource::collection($allProperties);

        } catch (\Exception $e) {
            Log::error('API error: Failed to fetch properties', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Failed to fetch properties'
            ], 500);
        }
    }

    /**
     * API endpoint for property search with filters and images
     */
    public function apiSearch(Request $request)
    {
        try {
            Log::info('API Search initiated', ['parameters' => $request->all()]);

            // Start with a base query and eager load relationships
            $query = Property::with(['images', 'amenities', 'user']);

            // Property type filter with specific type handling
            if ($request->filled('type')) {
                $propertyType = strtolower($request->type);
                switch($propertyType) {
                    case 'house':
                        $query->where('type', 'house');
                        break;
                    case 'house_and_lot':
                        $query->where('type', 'house_and_lot');
                        break;
                    case 'condo':
                    case 'condominium':
                        $query->where('type', 'condominium');
                        break;
                    case 'apartment':
                        $query->where('type', 'apartment');
                        break;
                    case 'townhouse':
                        $query->where('type', 'townhouse');
                        break;
                    case 'lot':
                        $query->where('type', 'lot');
                        break;
                }
            }

            // Keyword search across multiple fields
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('title', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('location', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('city', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('property_address', 'LIKE', "%{$searchTerm}%");
                });
            }

            // Price range filter
            if ($request->filled('min_price')) {
                $query->where('price', '>=', $request->min_price);
            }
            if ($request->filled('max_price')) {
                $query->where('price', '<=', $request->max_price);
            }

            // Location/City filter
            if ($request->filled('city')) {
                $query->where('city', 'LIKE', "%{$request->city}%");
            }

            // Bedrooms filter
            if ($request->filled('beds')) {
                $query->where('bedrooms', '>=', $request->beds);
            }

            // Bathrooms filter
            if ($request->filled('baths')) {
                $query->where('bathrooms', '>=', $request->baths);
            }

            // Area size filter
            if ($request->filled('min_area')) {
                $query->where('sqm', '>=', $request->min_area);
            }
            if ($request->filled('max_area')) {
                $query->where('sqm', '<=', $request->max_area);
            }

            // Lot size filter
            if ($request->filled('min_lot_size')) {
                $query->where('lot_size', '>=', $request->min_lot_size);
            }
            if ($request->filled('max_lot_size')) {
                $query->where('lot_size', '<=', $request->max_lot_size);
            }

            // Amenities filters
            if ($request->filled('amenities')) {
                $amenities = explode(',', $request->amenities);
                foreach ($amenities as $amenity) {
                    $query->where($amenity, true);
                }
            }

            // Status filter
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Featured properties filter
            if ($request->boolean('featured')) {
                $query->where('is_featured', true);
            }

            // Sort options
            $sortField = $request->input('sort_by', 'created_at');
            $sortOrder = $request->input('sort_order', 'desc');
            $allowedSortFields = ['price', 'created_at', 'sqm', 'lot_size'];

            if (in_array($sortField, $allowedSortFields)) {
                $query->orderBy($sortField, $sortOrder);
            }

            // Pagination
            $perPage = $request->input('per_page', 12);
            $properties = $query->paginate($perPage);

            // Transform the results using PropertyResource
            return response()->json([
                'status' => 'success',
                'data' => PropertyResource::collection($properties)->additional([
                    'image_base_url' => url('storage/properties/'), // Base URL for images
                ]),
                'meta' => [
                    'current_page' => $properties->currentPage(),
                    'last_page' => $properties->lastPage(),
                    'per_page' => $properties->perPage(),
                    'total' => $properties->total()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('API Search error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while searching properties'
            ], 500);
        }
    }

    public function apiShow(Property $property)
    {
        try {
            $exclusiveProperties = collect($this->getExclusiveProperties());
            $exclusiveProperty = $exclusiveProperties->firstWhere('id', $property->id);

            if ($exclusiveProperty) {
                return new PropertyResource((object) $exclusiveProperty);
            }

            $property->load(['images', 'user', 'amenities']);
            return new PropertyResource($property);

        } catch (\Exception $e) {
            Log::error('API error: Failed to fetch property details', [
                'property_id' => $property->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Failed to fetch property details'
            ], 500);
        }
    }



// PropertyController.php - Add this new method
public function apiAdminSearch(Request $request)
{
    try {
        $query = Property::query();

        // Search by ID
        if ($request->filled('property_id')) {
            return $query->where('id', $request->property_id)
                        ->get()
                        ->map(function($property) {
                            return [
                                'id' => $property->id,
                                'type' => $property->type,
                                'price' => $property->price,
                                'title' => $property->title
                            ];
                        });
        }

        // Search by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        return $query->get()
                    ->map(function($property) {
                        return [
                            'id' => $property->id,
                            'type' => $property->type,
                            'price' => $property->price,
                            'title' => $property->title
                        ];
                    });

    } catch (\Exception $e) {
        Log::error('Admin property search error:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json(['error' => 'Search failed'], 500);
    }
}





// Add this method to PropertyController
public function apiDestroy(Property $property)
{
    try {
        $property->delete();
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        Log::error('Property deletion failed:', [
            'property_id' => $property->id,
            'error' => $e->getMessage()
        ]);
        return response()->json(['error' => 'Deletion failed'], 500);
    }
}



    /**
 * Handle admin property view request
 */
public function adminView(Property $property)
{
    try {
        $exclusiveProperties = collect($this->getExclusiveProperties());
        $isExclusive = $exclusiveProperties->contains('id', $property->id);

        if ($isExclusive) {
            $propertyData = $exclusiveProperties->firstWhere('id', $property->id);
            $property = json_decode(json_encode($propertyData));
        }

        // Store property data in session if needed
        session(['viewing_property' => $property]);

        return response()->json([
            'success' => true,
            'redirect' => route('admin.properties.show', $property->id)
        ]);

    } catch (\Exception $e) {
        Log::error('Error in admin property view', [
            'property_id' => $property->id,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to view property'
        ], 500);
    }

}

}
