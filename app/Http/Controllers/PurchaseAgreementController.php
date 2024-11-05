<?php

namespace App\Http\Controllers;

use App\Models\PurchaseAgreement;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PurchaseAgreementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('buyer')->except(['show']);
    }

    public function index()
    {
        $user = Auth::user();
        $purchaseAgreements = $user->isAdmin()
            ? PurchaseAgreement::with('property', 'user')->latest()->paginate(10)
            : $user->purchaseAgreements()->with('property')->latest()->paginate(10);

        return view('purchase-agreements.index', compact('purchaseAgreements'));
    }

    public function create()
    {
        $properties = Property::where('status', 'for_sale')->get();
        return view('purchase-agreements.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validatePurchaseAgreement($request);
        $validatedData['user_id'] = Auth::id();
        $validatedData['status'] = 'pending';

        DB::beginTransaction();
        try {
            $purchaseAgreement = PurchaseAgreement::create($validatedData);
            DB::commit();
            return redirect()->route('purchase-agreements.show', $purchaseAgreement)
                ->with('success', 'Purchase agreement submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred while submitting the purchase agreement. Please try again.')
                ->withInput();
        }
    }

    public function show(PurchaseAgreement $purchaseAgreement)
    {
        $this->authorize('view', $purchaseAgreement);
        return view('forms.purchase-agreements.show', compact('purchaseAgreement'));
    }

    public function edit(PurchaseAgreement $purchaseAgreement)
    {
        $this->authorize('update', $purchaseAgreement);
        return view('forms.purchase-agreements.edit', compact('purchaseAgreement'));
    }

    public function update(Request $request, PurchaseAgreement $purchaseAgreement)
    {
        $this->authorize('update', $purchaseAgreement);

        $validatedData = $this->validatePurchaseAgreement($request);

        DB::beginTransaction();
        try {
            $purchaseAgreement->update($validatedData);
            DB::commit();
            return redirect()->route('purchase-agreements.show', $purchaseAgreement)
                ->with('success', 'Purchase agreement updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred while updating the purchase agreement. Please try again.')
                ->withInput();
        }
    }

    public function destroy(Request $request, PurchaseAgreement $purchaseAgreement)
{
    $this->authorize('delete', $purchaseAgreement);

    if ($request->input('confirm') !== 'yes') {
        return redirect()->back()->with('warning', 'Please confirm deletion.');
    }

    DB::beginTransaction();
    try {
        $purchaseAgreement->delete();
        DB::commit();
        return redirect()->route('profile.submitted-forms')
            ->with('success', 'Purchase agreement deleted successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->with('error', 'An error occurred while deleting the purchase agreement. Please try again.');
    }
}


    public function confirmDelete(PurchaseAgreement $purchaseAgreement)
{
    $this->authorize('delete', $purchaseAgreement);
    return view('forms.purchase-agreements.confirm-delete', compact('purchaseAgreement'));
}

    private function validatePurchaseAgreement(Request $request)
    {
        return $request->validate([
            'property_id' => ['required', 'exists:properties,id'],
            'buyer_name' => ['required', 'string', 'max:255'],
            'seller_name' => ['required', 'string', 'max:255'],
            'property_address' => ['required', 'string', 'max:255'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'earnest_money' => ['required', 'numeric', 'min:0'],
            'closing_date' => ['required', 'date', 'after_or_equal:today'],
            'possession_date' => ['required', 'date', 'after_or_equal:closing_date'],
            'contingencies' => ['nullable', 'array'],
            'contingencies.*' => [Rule::in(['financing', 'inspection', 'appraisal', 'sale'])],
            'additional_terms' => ['nullable', 'string', 'max:1000'],
            'agree_terms' => ['required', 'accepted'],
        ]);
    }
}
