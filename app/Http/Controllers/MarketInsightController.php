<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarketInsightController extends Controller
{
    public function index()
    {
        $propertySalesData = [
            ['month' => 'Jan', 'sales' => 4000, 'listings' => 2400],
            ['month' => 'Feb', 'sales' => 3000, 'listings' => 1398],
            ['month' => 'Mar', 'sales' => 2000, 'listings' => 9800],
            ['month' => 'Apr', 'sales' => 2780, 'listings' => 3908],
            ['month' => 'May', 'sales' => 1890, 'listings' => 4800],
            ['month' => 'Jun', 'sales' => 2390, 'listings' => 3800],
        ];

        $propertyPriceData = [
            ['year' => '2020', 'price' => 300000],
            ['year' => '2021', 'price' => 320000],
            ['year' => '2022', 'price' => 350000],
            ['year' => '2023', 'price' => 390000],
            ['year' => '2024', 'price' => 410000],
        ];

        $marketTrends = [
            [
                'title' => 'Rising Demand',
                'description' => 'Increased demand in suburban areas',
                'color' => 'blue',
                'percentage' => 35,
            ],
            [
                'title' => 'Low Interest Rates',
                'description' => 'Historically low rates for mortgages',
                'color' => 'green',
                'percentage' => 25,
            ],
            [
                'title' => 'Shifting Preferences',
                'description' => 'Trend towards homes with office spaces',
                'color' => 'yellow',
                'percentage' => 20,
            ],
            [
                'title' => 'Technological Integration',
                'description' => 'Growing importance of smart homes',
                'color' => 'red',
                'percentage' => 20,
            ],
        ];

        $regionalInsights = [
            [
                'title' => 'Urban Areas',
                'description' => 'High demand for modern apartments',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />',
                'color' => 'purple',
                'percentage' => 75,
            ],
            [
                'title' => 'Suburban Regions',
                'description' => 'Growing interest in family homes',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />',
                'color' => 'indigo',
                'percentage' => 85,
            ],
            [
                'title' => 'Coastal Properties',
                'description' => 'Increased popularity of beach homes',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />',
                'color' => 'pink',
                'percentage' => 60,
            ],
            [
                'title' => 'Rural Communities',
                'description' => 'Rising trend of remote workers',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />',
                'color' => 'teal',
                'percentage' => 45,
            ],
        ];

        return view('market-insights', compact('propertySalesData', 'propertyPriceData', 'marketTrends', 'regionalInsights'));
    }
}
