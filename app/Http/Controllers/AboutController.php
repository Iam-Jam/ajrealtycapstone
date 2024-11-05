<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $companyName = "AJ Real Estate";
        $yearsOfExperience = 10;
        $services = [
            "Property sales",
            "Rentals",
            "Property management",
        ];
        $reasonsToChoose = [
            "Extensive market knowledge and expertise",
            "Personalized service tailored to your needs",
            "Cutting-edge technology for property searches and marketing",
            "Transparent and ethical business practices",
            "Ongoing support even after the transaction is complete",
        ];
        $helpOptions = [
            [
                'title' => 'Buying a Property',
                'description' => 'Our experienced agents will guide you through the entire buying process, from property search to closing the deal.',
            ],
            [
                'title' => 'Selling Your Property',
                'description' => 'We use advanced marketing strategies and our extensive network to help you sell your property quickly and at the best price.',
            ],
            [
                'title' => 'Property Management',
                'description' => 'Our property management services ensure that your investment is well-maintained and generates steady rental income.',
            ],
            [
                'title' => 'Market Analysis',
                'description' => 'We provide in-depth market analysis to help you make informed decisions about buying, selling, or investing in properties.',
            ],
        ];

        return view('about', compact('companyName', 'yearsOfExperience', 'services', 'reasonsToChoose', 'helpOptions'));
    }
}
