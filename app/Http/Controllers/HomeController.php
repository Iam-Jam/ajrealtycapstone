<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProperties = [
            [
                'id' => 1,
                'title' => 'Luxury Penthouse',
                'description' => 'Experience the pinnacle of urban living with panoramic city views',
                'beds' => 3,
                'baths' => 3,
                'features' => ['Pool'],
                'image' => 'uploads/uploads/featuredphp1.jpg',
                'label' => 'Just Listed',
                'sqft' => 2500,
                'floors' => 2,
                'property_type' => 'Penthouse',
                'price' => 15000000
            ],
            [
                'id' => 2,
                'title' => 'Modern House',
                'description' => 'Sleek design meets comfort in this state-of-the-art family home',
                'beds' => 3,
                'baths' => 2,
                'features' => [],
                'image' => 'uploads/uploads/featuredphp2.jpg',
                'label' => 'New Listing',
                'sqft' => 2200,
                'floors' => 2,
                'property_type' => 'House',
                'price' => 8500000
            ],
            [
                'id' => 3,
                'title' => 'Stylish House',
                'description' => 'Perfect urban retreat for singles or couples in the heart of the city',
                'beds' => 1,
                'baths' => 1,
                'features' => [],
                'image' => 'uploads/uploads/featuredphp3.jpg',
                'label' => 'Hot Deal',
                'sqft' => 800,
                'floors' => 2,
                'property_type' => 'Apartment',
                'price' => 45000000
            ],
        ];

        return view('home', compact('featuredProperties'));
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
