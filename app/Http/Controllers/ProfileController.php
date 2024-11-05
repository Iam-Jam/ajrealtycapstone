<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\ListingAgreement;
use App\Models\PropertyDisclosure;
use App\Models\PurchaseAgreement;
use App\Models\ListProperty;
use App\Models\ContactInquiry;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $purchaseAgreements = $user->purchaseAgreements;
        $listingAgreements = $user->listingAgreements;
        $propertyDisclosures = $user->propertyDisclosures;
        $contactInquiries = $user->contactInquiries;

        return view('profile.index', compact('purchaseAgreements', 'listingAgreements', 'propertyDisclosures', 'contactInquiries'));
    }

    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'user_type' => 'required|in:seller,buyer,renter,viewer',
        ]);

        $user->update($validated);

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    public function submittedForms()
    {
        $user = Auth::user();

        if ($user->user_type === 'admin') {
            // Admin sees all listings and inquiries
            $allListings = ListProperty::with(['images', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();

            $pendingListings = $allListings->where('status', 'pending');
            $approvedListings = $allListings->where('status', 'approved');

            // Get ALL contact inquiries for admin, regardless of who submitted them
            $contactInquiries = ContactInquiry::with(['user', 'assignedTo'])
                ->orderBy('created_at', 'desc')
                ->get();

            \Log::info('Admin viewing all contact inquiries', [
                'total_inquiries' => $contactInquiries->count(),
                'pending_inquiries' => $contactInquiries->where('status', 'pending')->count()
            ]);

            return view('user.submitted_forms', compact(
                'pendingListings',
                'approvedListings',
                'contactInquiries'
            ));
        } else {
            // Regular user logic remains the same
            $purchaseAgreements = $user->purchaseAgreements;
            $listingAgreements = $user->listingAgreements;
            $propertyDisclosures = $user->propertyDisclosures;
            $userListings = ListProperty::where('user_id', $user->id)
                ->with('images')
                ->orderBy('created_at', 'desc')
                ->get();

            $contactInquiries = ContactInquiry::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('user.submitted_forms', compact(
                'purchaseAgreements',
                'listingAgreements',
                'propertyDisclosures',
                'userListings',
                'contactInquiries'
            ));
        }
    }

    // Contact Inquiry Methods
    public function showContactInquiry(ContactInquiry $contactInquiry)
    {
        $this->authorize('view', $contactInquiry);
        return view('profile.contact-inquiries.show', compact('contactInquiry'));
    }

    public function editContactInquiry(ContactInquiry $contactInquiry)
    {
        $this->authorize('update', $contactInquiry);
        return view('profile.contact-inquiries.edit', compact('contactInquiry'));
    }

    public function updateContactInquiry(Request $request, ContactInquiry $contactInquiry)
    {
        $this->authorize('update', $contactInquiry);

        $validatedData = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,archived',
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'property_address' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'internal_notes' => 'nullable|string',
        ]);

        // Update status and other fields if provided
        $contactInquiry->update($validatedData);

        // Add timestamps based on status change
        if ($validatedData['status'] === 'completed' && $contactInquiry->completed_at === null) {
            $contactInquiry->completed_at = now();
            $contactInquiry->save();
        }

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Contact inquiry updated successfully',
                'status' => $validatedData['status']
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Contact inquiry status updated successfully');
    }
    public function destroyContactInquiry(ContactInquiry $contactInquiry)
    {
        $this->authorize('delete', $contactInquiry);

        $contactInquiry->delete();

        if (request()->ajax()) {
            return response()->json(['message' => 'Contact inquiry deleted successfully']);
        }

        return redirect()
            ->route('profile.submitted-forms')
            ->with('success', 'Contact inquiry deleted successfully');
    }

    // Existing Property Disclosure Methods
    public function propertyDisclosures()
    {
        $propertyDisclosures = auth()->user()->propertyDisclosures()->latest()->paginate(10);
        return view('profile.property-disclosures.index', compact('propertyDisclosures'));
    }

    public function showPropertyDisclosure(PropertyDisclosure $propertyDisclosure)
    {
        $this->authorize('view', $propertyDisclosure);
        return view('profile.property-disclosures.show', compact('propertyDisclosure'));
    }

    public function editPropertyDisclosure(PropertyDisclosure $propertyDisclosure)
    {
        $this->authorize('update', $propertyDisclosure);
        return view('profile.property-disclosures.edit', compact('propertyDisclosure'));
    }

    public function updatePropertyDisclosure(Request $request, PropertyDisclosure $propertyDisclosure)
    {
        $this->authorize('update', $propertyDisclosure);

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
            'structural_issues' => $validatedData['structural'] ?? [],
            'system_issues' => $validatedData['systems'] ?? [],
            'environmental_issues' => $validatedData['environmental'] ?? [],
            'additional_issues' => $validatedData['additional_issues'],
        ]);

        return redirect()
            ->route('profile.property-disclosures.show', $propertyDisclosure)
            ->with('success', 'Property disclosure updated successfully.');
    }

    public function destroyPropertyDisclosure(PropertyDisclosure $propertyDisclosure)
    {
        $this->authorize('delete', $propertyDisclosure);

        $propertyDisclosure->delete();

        return redirect()
            ->route('profile.property-disclosures.index')
            ->with('success', 'Property disclosure deleted successfully.');
    }
}
