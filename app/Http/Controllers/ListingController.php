<?php

namespace App\Http\Controllers;

use App\Models\ListingAgreement;
use App\Models\Registration;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index()
    {
        $listingAgreements = ListingAgreement::latest()->paginate(10);
        return view('listings.index', compact('listingAgreements'));
    }

    public function create()
    {
        $user = auth()->user();
        if (!in_array($user->user_type, ['buyer', 'seller', 'renter'])) {
            return redirect()->route('home')->with('error', 'Only registered buyers, sellers, and renters can create a listing agreement.');
        }
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->user_type, ['buyer', 'seller', 'renter'])) {
            return redirect()->back()->with('error', 'Only registered buyers, sellers, and renters can submit the form.');
        }

        $validatedData = $request->validate([
            'seller_name' => 'required|string|max:255',
            'seller_phone' => 'required|string|max:255',
            'property_address' => 'required|string|max:255',
            'property_city' => 'required|string|max:255',
            'property_state' => 'required|string|max:255',
            'property_zip' => 'required|string|max:255',
            'listing_price' => 'required|numeric|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'listing_start_date' => 'required|date',
            'listing_end_date' => 'required|date|after_or_equal:listing_start_date',
            'property_description' => 'required|string',
            'special_conditions' => 'nullable|string',
        ]);

        $listingAgreement = new ListingAgreement($validatedData);
        $listingAgreement->user_id = $user->id;
        $listingAgreement->save();

        return redirect()->route('listings.show', $listingAgreement->id)->with('success', 'Listing agreement submitted successfully.');
    }

    public function show(ListingAgreement $listingAgreement)
    {
        return view('listings.show', compact('listingAgreement'));
    }

    public function edit(ListingAgreement $listingAgreement)
    {
        $user = auth()->user();
        if ($user->id !== $listingAgreement->user_id) {
            return redirect()->route('listings.index')->with('error', 'You are not authorized to edit this listing agreement.');
        }
        return view('listings.edit', compact('listingAgreement'));
    }

    public function update(Request $request, ListingAgreement $listingAgreement)
    {
        $user = auth()->user();
        if ($user->id !== $listingAgreement->user_id) {
            return redirect()->route('listings.index')->with('error', 'You are not authorized to update this listing agreement.');
        }

        $validatedData = $request->validate([
            'seller_name' => 'required|string|max:255',
            'seller_phone' => 'required|string|max:255',
            'property_address' => 'required|string|max:255',
            'property_city' => 'required|string|max:255',
            'property_state' => 'required|string|max:255',
            'property_zip' => 'required|string|max:255',
            'listing_price' => 'required|numeric|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'listing_start_date' => 'required|date',
            'listing_end_date' => 'required|date|after_or_equal:listing_start_date',
            'property_description' => 'required|string',
            'special_conditions' => 'nullable|string',
        ]);

        $listingAgreement->update($validatedData);

        return redirect()->route('listings.show', $listingAgreement->id)->with('success', 'Listing agreement updated successfully.');
    }

    public function destroy(ListingAgreement $listingAgreement)
    {
        $user = auth()->user();
        if ($user->id !== $listingAgreement->user_id) {
            return redirect()->route('listings.index')->with('error', 'You are not authorized to delete this listing agreement.');
        }

        $listingAgreement->delete();

        return redirect()->route('listings.index')->with('success', 'Listing agreement deleted successfully.');
    }
}
