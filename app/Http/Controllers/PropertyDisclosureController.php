<?php

namespace App\Http\Controllers;

use App\Models\PropertyDisclosure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PropertyDisclosureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $disclosures = auth()->user()->propertyDisclosures()->latest()->paginate(10);
        return view('profile.property-disclosures.index', compact('disclosures'));
    }

    public function create()
    {
        $user = auth()->user();
        if (!$user->hasAnyUserType('buyer', 'seller', 'renter')) {
            return redirect()->route('home')->with('error', 'Only registered buyers, sellers, and renters can create a property disclosure.');
        }
        return view('forms.property-disclosure');
    }

    public function store(Request $request)
    {
        Log::info('PropertyDisclosureController store method called');

        try {
            $validatedData = $request->validate([
                'seller_name' => 'required|string|max:255',
                'property_address' => 'required|string|max:255',
                'structural' => 'nullable|array',
                'systems' => 'nullable|array',
                'environmental' => 'nullable|array',
                'additional_issues' => 'nullable|string',
                'confirm_disclosure' => 'required|accepted',
            ]);

            $propertyDisclosure = auth()->user()->propertyDisclosures()->create([
                'seller_name' => $validatedData['seller_name'],
                'property_address' => $validatedData['property_address'],
                'structural_issues' => json_encode($validatedData['structural'] ?? []),
                'system_issues' => json_encode($validatedData['systems'] ?? []),
                'environmental_issues' => json_encode($validatedData['environmental'] ?? []),
                'additional_issues' => $validatedData['additional_issues'],
                'confirm_disclosure' => true,
            ]);

            Log::info('Property disclosure created', ['id' => $propertyDisclosure->id]);

            return redirect()->route('profile.property-disclosures.show', $propertyDisclosure)
                ->with('success', 'Property disclosure has been submitted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create property disclosure: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to submit property disclosure. Please try again.')
                ->withErrors($e->validator)
                ->withInput();
        }
    }

    public function show(PropertyDisclosure $propertyDisclosure)
    {
        $this->authorize('view', $propertyDisclosure);
        return view('profile.property-disclosures.show', compact('propertyDisclosure'));
    }

    public function edit(PropertyDisclosure $propertyDisclosure)
    {
        $this->authorize('update', $propertyDisclosure);

        $structuralItems = [
            'foundation' => 'Foundation issues',
            'roof' => 'Roof leaks or damage',
            'walls' => 'Wall cracks or damage',
            'floors' => 'Floor damage or unevenness',
            'ceilings' => 'Ceiling damage or leaks',
            'windows' => 'Window problems',
            'doors' => 'Door issues',
        ];

        return view('profile.property-disclosures.edit', compact('propertyDisclosure', 'structuralItems'));
    }

    public function update(Request $request, PropertyDisclosure $propertyDisclosure)
{
    $validatedData = $request->validate([
        'seller_name' => 'required|string|max:255',
        'property_address' => 'required|string|max:255',
        'structural' => 'nullable|array',
        'systems' => 'nullable|array',
        'environmental' => 'nullable|array',
        'additional_issues' => 'nullable|string',
        'confirm_disclosure' => 'required|accepted',
    ]);

    $propertyDisclosure->update([
        'seller_name' => $validatedData['seller_name'],
        'property_address' => $validatedData['property_address'],
        'structural_issues' => json_encode($validatedData['structural'] ?? []),
        'system_issues' => json_encode($validatedData['systems'] ?? []),
        'environmental_issues' => json_encode($validatedData['environmental'] ?? []),
        'additional_issues' => $validatedData['additional_issues'],
    ]);

    return redirect()->route('profile.property-disclosures.edit', $propertyDisclosure)
        ->with('success', 'Property disclosure updated successfully.');
}

    public function destroy(PropertyDisclosure $propertyDisclosure)
    {
        $this->authorize('delete', $propertyDisclosure);

        try {
            $propertyDisclosure->delete();

            Log::info('Property disclosure deleted', ['id' => $propertyDisclosure->id]);

            return redirect()->route('profile.submitted-forms')
                ->with('success', 'Property disclosure has been deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete property disclosure: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete property disclosure. Please try again.');
        }
    }
}
