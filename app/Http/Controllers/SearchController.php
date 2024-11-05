<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Property::query();

        // Basic search
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('location', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('property_type', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('city', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Price range filter
        if ($request->has('price_range') && $request->price_range != '') {
            list($min, $max) = explode('-', $request->price_range);
            if ($max === '+') {
                $query->where('price', '>=', $min);
            } else {
                $query->whereBetween('price', [$min, $max]);
            }
        }

        // Property type filter
        if ($request->has('type') && $request->type != '') {
            $query->where('property_type', $request->type);
        }

        // Bedrooms filter
        if ($request->has('beds') && $request->beds != '') {
            $query->where('bedrooms', '>=', $request->beds);
        }

        // Bathrooms filter
        if ($request->has('baths') && $request->baths != '') {
            $query->where('bathrooms', '>=', $request->baths);
        }

        // Amenities filter
        if ($request->has('amenities')) {
            foreach ($request->amenities as $amenity) {
                $query->where($amenity, true);
            }
        }

        // Area/Square meters filter
        if ($request->has('min_sqm')) {
            $query->where('sqm', '>=', $request->min_sqm);
        }
        if ($request->has('max_sqm')) {
            $query->where('sqm', '<=', $request->max_sqm);
        }

        // Featured properties filter
        if ($request->has('is_featured')) {
            $query->where('is_featured', true);
        }

        // Exclusive properties filter
        if ($request->has('is_exclusive')) {
            $query->where('is_exclusive', true);
        }

        // Location/City filter
        if ($request->has('city') && $request->city != '') {
            $query->where('city', 'LIKE', "%{$request->city}%");
        }

        // Sort options
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'date_new':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'date_old':
                    $query->orderBy('created_at', 'asc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc'); // Default sorting
        }

        // Execute query with pagination
        $properties = $query->paginate(9)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'properties' => $properties,
                'pagination' => view('pagination.custom', compact('properties'))->render()
            ]);
        }

        return view('properties.index', compact('properties'));
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('query');

        $suggestions = Property::where('title', 'LIKE', "%{$query}%")
            ->orWhere('location', 'LIKE', "%{$query}%")
            ->orWhere('city', 'LIKE', "%{$query}%")
            ->orWhere('property_type', 'LIKE', "%{$query}%")
            ->select('title', 'location', 'city', 'property_type')
            ->distinct()
            ->limit(5)
            ->get();

        return response()->json($suggestions);
    }
}
