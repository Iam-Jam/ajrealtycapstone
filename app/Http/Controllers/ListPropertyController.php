<?php

namespace App\Http\Controllers;

use App\Models\ListProperty;
use App\Models\ListPropertyImage;
use App\Models\User;
use App\Notifications\NewPropertyListingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ListPropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display listing index
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->user_type === 'admin') {
            // Admin sees all listings
            $allListings = ListProperty::with(['images', 'user'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('properties.index', [
                'allListings' => $allListings
            ]);
        } else {
            // Other users see their own listings
            $userListings = ListProperty::where('user_id', $user->id)
                ->with('images')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('properties.index', [
                'userListings' => $userListings
            ]);
        }
    }

    /**
     * Display list/sell property page
     */
    public function listSellProperty()
{
    if (!in_array(Auth::user()->user_type, ['admin', 'seller', 'agent1', 'agent2'])) {
        abort(403, 'Unauthorized action.');
    }

    $user = Auth::user();

    // Admin sees all pending listings plus their own
    if ($user->user_type === 'admin') {
        $pendingListings = ListProperty::where('status', 'pending')
            ->with(['images', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $approvedListings = ListProperty::where('status', 'approved')
            ->with(['images', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('properties.list-sell', [
            'pendingListings' => $pendingListings,
            'approvedListings' => $approvedListings
        ]);
    }

    // Other users see their own listings
    $userListings = ListProperty::where('user_id', $user->id)
        ->with('images')
        ->orderBy('created_at', 'desc')
        ->get();

    return view('properties.list-sell', [
        'userListings' => $userListings
    ]);
}


    /**
     * Show create form
     */
    public function create()
    {
        if (!in_array(Auth::user()->user_type, ['admin', 'seller', 'agent1', 'agent2'])) {
            return redirect()->route('forms.index')
                ->with('info', 'Please visit our Forms page and select Contact Inquiry to submit your inquiry.');
        }

        return view('properties.list-sell');
    }


        /**
     * Store request
     */
    public function store(Request $request)
{
    if (!in_array(Auth::user()->user_type, ['admin', 'seller', 'agent1', 'agent2'])) {
        abort(403, 'Unauthorized action.');
    }

    $validated = $request->validate([
        'property_option' => 'required|in:list,sell',
        'title' => 'required|string|max:255',
        'type' => 'required|in:lot,house_and_lot,townhouse,condominium,apartment,room',
        'bedrooms' => 'required|integer|min:0',
        'bathrooms' => 'required|integer|min:0',
        'sqm' => 'required|numeric|min:1',
        'price' => 'required|numeric|min:0',
        'property_address' => 'required|string',
        'city' => 'required|string',
        'description' => 'required|string',
        'contact_whatsapp' => 'nullable|string|max:50',
        'contact_messenger' => 'nullable|string|max:100',
        'contact_email' => 'required|email',
        'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        'images' => 'array|max:3'
    ]);

    try {
        DB::beginTransaction();

        // Create the property listing
        $property = ListProperty::create([
            'user_id' => Auth::id(),
            'property_option' => $validated['property_option'],
            'title' => $validated['title'],
            'type' => $validated['type'],
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'sqm' => $validated['sqm'],
            'price' => $validated['price'],
            'property_address' => $validated['property_address'],
            'city' => $validated['city'],
            'description' => $validated['description'],
            'swimming_pool' => $request->has('swimming_pool'),
            'gym_access' => $request->has('gym_access'),
            'living_room' => $request->has('living_room'),
            'dining_room' => $request->has('dining_room'),
            'contact_whatsapp' => $validated['contact_whatsapp'],
            'contact_messenger' => $validated['contact_messenger'],
            'contact_email' => $validated['contact_email'],
            'status' => 'pending'
        ]);

        if ($request->hasFile('images')) {
            $isFirst = true;
            foreach ($request->file('images') as $image) {
                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Store the file in storage/app/public/uploads/listproperties
                $path = $image->storeAs(
                    'uploads/listproperties',
                    $filename,
                    'public'
                );

                ListPropertyImage::create([
                    'property_id' => $property->id,
                    'image_path' => $path,
                    'is_primary' => $isFirst
                ]);

                $isFirst = false;
            }
        }

        DB::commit();

        $message = "Your {$validated['property_option']} property has been successfully submitted and is pending approval.";
        Log::info('Property listing created successfully', ['property_id' => $property->id]);

        return redirect()->route('list-sell-property')->with('success', $message);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Property submission error: ' . $e->getMessage(), [
            'user_id' => Auth::id(),
            'data' => $validated
        ]);

        return back()
            ->withInput()
            ->with('error', 'Unable to submit your property listing. Please try again.');
    }
}

    /**
     * Show property listing
     */
    public function show(ListProperty $listProperty)
    {
        try {
            if (!in_array(Auth::user()->user_type, ['admin', 'agent1', 'agent2', 'seller'])) {
                abort(403, 'Only administrators, agents, and sellers can view property listings.');
            }

            if (Auth::user()->user_type === 'admin' ||
                in_array(Auth::user()->user_type, ['agent1', 'agent2']) ||
                (Auth::user()->user_type === 'seller' && Auth::id() === $listProperty->user_id)) {

                return view('list-sell-properties.show', [
                    'listProperty' => $listProperty,
                    '_token' => csrf_token() // Explicitly passing CSRF token
                ]);
            }

            abort(403, 'You are not authorized to view this property listing.');

        } catch (\Exception $e) {
            Log::error('Property show error: ' . $e->getMessage());
            abort(403, 'An error occurred while accessing this property listing.');
        }
    }

/**
 * Show edit form
 */
public function edit(ListProperty $listProperty)
{
    if (!in_array(Auth::user()->user_type, ['admin', 'agent1', 'agent2', 'seller'])) {
        abort(403, 'Unauthorized action.');
    }

    if (Auth::user()->user_type !== 'admin' && Auth::id() !== $listProperty->user_id) {
        abort(403, 'You can only edit your own listings.');
    }

    return view('list-sell-properties.edit', compact('listProperty'));
}


    /**
     * Update property listing
     */
    public function update(Request $request, ListProperty $listProperty)
    {
        if (!in_array(Auth::user()->user_type, ['admin', 'agent1', 'agent2', 'seller'])) {
            abort(403, 'Unauthorized action.');
        }

        if (Auth::user()->user_type !== 'admin' && Auth::id() !== $listProperty->user_id) {
            abort(403, 'You can only update your own listings.');
        }

        $validated = $request->validate([
            'property_option' => 'required|in:list,sell',
            'title' => 'required|string|max:255',
            'type' => 'required|in:lot,house_and_lot,townhouse,condominium,apartment,room',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'sqm' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
            'property_address' => 'required|string',
            'city' => 'required|string',
            'description' => 'required|string',
            'contact_whatsapp' => 'nullable|string|max:50',
            'contact_messenger' => 'nullable|string|max:100',
            'contact_email' => 'required|email',
            'new_images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'new_images' => 'array|max:3'
        ]);

        try {
            DB::beginTransaction();

            $listProperty->update([
                ...$validated,
                'swimming_pool' => $request->has('swimming_pool'),
                'gym_access' => $request->has('gym_access'),
                'living_room' => $request->has('living_room'),
                'dining_room' => $request->has('dining_room'),
                'is_featured' => $request->has('is_featured'),
                'is_exclusive' => $request->has('is_exclusive'),
            ]);

            if ($request->has('delete_images')) {
                foreach ($request->input('delete_images') as $imageId) {
                    $image = $listProperty->images()->find($imageId);
                    if ($image) {
                        Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }
            }

            if ($request->hasFile('new_images')) {
                $this->uploadImages($listProperty, $request->file('new_images'));
            }

            DB::commit();

            return redirect()->route('list-sell-property.show', $listProperty)
                ->with('success', 'Property listing updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Property update error: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Failed to update property listing. Please try again.');
        }
    }

    /**
     * Delete property listing
     */
    public function destroy(ListProperty $listProperty)
    {
        if (!in_array(Auth::user()->user_type, ['admin', 'agent1', 'agent2', 'seller'])) {
            abort(403, 'Unauthorized action.');
        }

        if (Auth::user()->user_type !== 'admin' && Auth::id() !== $listProperty->user_id) {
            abort(403, 'You can only delete your own listings.');
        }

        try {
            DB::beginTransaction();

            foreach ($listProperty->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            $listProperty->delete();

            DB::commit();

            return redirect()->route('list-sell-property')
                ->with('success', 'Property listing deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Property deletion error: ' . $e->getMessage());
            return back()
                ->with('error', 'Failed to delete property listing. Please try again.');
        }
    }


/**
 * Toggle featured status
 */
public function toggleFeatured(ListProperty $listProperty)
{
    if (Auth::user()->user_type !== 'admin') {
        abort(403, 'Only administrators can modify featured status.');
    }

    // Check if property is approved first
    if ($listProperty->status !== 'approved') {
        return redirect()->back()->with('error', 'Property must be approved before it can be featured.');
    }

    try {
        $listProperty->update([
            'is_featured' => !$listProperty->is_featured
        ]);

        $message = $listProperty->is_featured
            ? 'Property marked as featured successfully.'
            : 'Property removed from featured successfully.';

        return redirect()->back()->with('success', $message);
    } catch (\Exception $e) {
        Log::error('Featured toggle error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to update featured status.');
    }
}

/**
 * Toggle exclusive status
 */
public function toggleExclusive(ListProperty $listProperty)
{
    if (Auth::user()->user_type !== 'admin') {
        abort(403, 'Only administrators can modify exclusive status.');
    }

    // Check if property is approved first
    if ($listProperty->status !== 'approved') {
        return redirect()->back()->with('error', 'Property must be approved before it can be exclusive.');
    }

    try {
        $listProperty->update([
            'is_exclusive' => !$listProperty->is_exclusive
        ]);

        $message = $listProperty->is_exclusive
            ? 'Property marked as exclusive successfully.'
            : 'Property removed from exclusive successfully.';

        return redirect()->back()->with('success', $message);
    } catch (\Exception $e) {
        Log::error('Exclusive toggle error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to update exclusive status.');
    }
}


/**
 * Toggle property status (Admin Only)
 */
public function toggleStatus(ListProperty $listProperty)
{
    if (Auth::user()->user_type !== 'admin') {
        abort(403, 'Only administrators can modify listing status.');
    }

    try {
        DB::beginTransaction();

        $oldStatus = $listProperty->status;
        $nextStatus = $oldStatus === 'pending' ? 'approved' : 'pending';

        $listProperty->update([
            'status' => $nextStatus,
            'approved_at' => $nextStatus === 'approved' ? now() : null,
            'approved_by' => $nextStatus === 'approved' ? Auth::id() : null
        ]);

        // Get the owner to notify
        $owner = User::find($listProperty->user_id);

        Log::info('Property status updated successfully', [
            'property_id' => $listProperty->id,
            'old_status' => $oldStatus,
            'new_status' => $nextStatus,
            'updated_by' => Auth::id(),
            'owner_id' => $owner->id
        ]);

        // Notify the property owner
        $owner->notify(new NewPropertyListingNotification(
            $listProperty,
            'status_change',
            $nextStatus,
            Auth::user()->name
        ));

        DB::commit();

        return redirect()->back()->with('success',
            $nextStatus === 'approved'
                ? 'Property listing has been approved successfully.'
                : 'Property listing has been marked as pending.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Status toggle error: ' . $e->getMessage());
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update property status. Please try again.');
    }
}
    /**
     * Upload images helper
     */
    private function uploadImages($property, $images)
    {
        foreach ($images as $image) {
            $path = $image->store('list-sell-images', 'public');
            $property->images()->create([
                'image_path' => $path
            ]);
        }
    }

     /**
     * Notify admins helper
     */
    private function notifyAdmins($property)
    {
        try {
            $admins = User::where('user_type', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewPropertyListingNotification($property));
            }
        } catch (\Exception $e) {
            Log::error('Failed to notify admins', [
                'property_id' => $property->id,
                'error' => $e->getMessage()
            ]);
    }
}
}
