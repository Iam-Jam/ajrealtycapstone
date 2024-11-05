<?php

namespace App\Services;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PropertyService
{
    public function getFeaturedProperties(int $limit = 6): Collection
    {
        return Property::where('is_featured', true)
                       ->with('images')
                       ->latest()
                       ->take($limit)
                       ->get();
    }

    public function getAllProperties(int $perPage = 15): LengthAwarePaginator
    {
        return Property::with('images')->latest()->paginate($perPage);
    }

    public function getExclusiveProperties(int $limit = 6): Collection
    {
        return Property::where('is_exclusive', true)
                       ->with('images')
                       ->latest()
                       ->take($limit)
                       ->get();
    }

    public function searchProperties(array $criteria): LengthAwarePaginator
    {
        $query = Property::query();

        if (isset($criteria['search'])) {
            $searchTerm = $criteria['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('location', 'like', "%{$searchTerm}%")
                  ->orWhere('property_address', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by property type
        $propertyTypes = ['lot', 'house_and_lot', 'townhouse', 'condominium', 'apartment', 'room'];
        $query->whereIn('type', $propertyTypes);

        // Filter by source (list property, sell property, and exclusive properties)
        $query->where(function ($q) {
            $q->whereIn('source', ['lister', 'seller', 'admin'])
              ->orWhere('is_exclusive', true);
        });

        if (isset($criteria['type'])) {
            $query->where('type', $criteria['type']);
        }

        if (isset($criteria['min_price'])) {
            $query->where('price', '>=', $criteria['min_price']);
        }

        if (isset($criteria['max_price'])) {
            $query->where('price', '<=', $criteria['max_price']);
        }

        if (isset($criteria['bedrooms'])) {
            $query->where('bedrooms', '>=', $criteria['bedrooms']);
        }

        if (isset($criteria['bathrooms'])) {
            $query->where('bathrooms', '>=', $criteria['bathrooms']);
        }

        if (isset($criteria['city'])) {
            $query->where('city', $criteria['city']);
        }

        if (isset($criteria['location'])) {
            $query->where('location', 'like', "%{$criteria['location']}%");
        }

        // Add logging
        Log::info('Search criteria: ' . json_encode($criteria));
        Log::info('SQL query: ' . $query->toSql());
        Log::info('Query bindings: ' . json_encode($query->getBindings()));

        $results = $query->with('images')->latest()->paginate(20);

        // Log the number of results
        Log::info('Number of results: ' . $results->total());

        return $results;
    }

    public function createProperty(array $data): Property
    {
        DB::beginTransaction();

        try {
            $property = Property::create($data);

            if (isset($data['images'])) {
                foreach ($data['images'] as $image) {
                    $path = $image->store('properties', 'public');
                    $property->images()->create(['image_path' => $path]);
                }
            }

            DB::commit();
            return $property;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create property: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateProperty(Property $property, array $data): Property
    {
        DB::beginTransaction();

        try {
            $property->update($data);

            if (isset($data['images'])) {
                // Delete old images
                $property->images()->delete();

                // Add new images
                foreach ($data['images'] as $image) {
                    $path = $image->store('properties', 'public');
                    $property->images()->create(['image_path' => $path]);
                }
            }

            DB::commit();
            return $property;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update property: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteProperty(Property $property): bool
    {
        return $property->delete();
    }

    public function listProperty(array $data): Property
    {
        $data['source'] = 'lister';
        $data['status'] = 'for_sale';
        return $this->createProperty($data);
    }

    public function sellProperty(array $data): Property
    {
        $data['source'] = 'seller';
        $data['status'] = 'for_sale';
        return $this->createProperty($data);
    }
}
