<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactInquiry;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function index()
    {
        $categories = [
            'For Sellers' => [
                'listing-agreement' => 'Listing Agreement',
                'property-disclosure' => 'Property Disclosure Statement',
            ],
            'For Buyers' => [
                'purchase-agreement' => 'Purchase Agreement',
            ],
            'For Viewers' => [
                'contact-inquiry' => 'Contact/Inquiry Form',
            ],
        ];

        return view('forms.index', compact('categories'));
    }

    public function listingAgreement()
    {
        return view('forms.listing-agreement');
    }

    public function propertyDisclosure()
    {
        return view('forms.property-disclosure');
    }

    public function purchaseAgreement()
    {
        return view('forms.purchase-agreement');
    }

    public function contactInquiry()
    {
        return view('forms.contact-inquiry');
    }

    public function submit(Request $request, $formType)
    {
        \Log::info('Submitting form type: ' . $formType);

        $validator = $this->getValidator($request, $formType);

        if ($validator->fails()) {
            \Log::warning('Validation failed for ' . $formType, $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();
        \Log::info('Validated data for ' . $formType, $validatedData);

        try {
            switch ($formType) {
                case 'property-disclosure':
                    $result = app(PropertyDisclosureController::class)->store($request);
                    \Log::info('PropertyDisclosureController store method called');
                    return $result;

                case 'contact-inquiry':
                    return $this->handleContactInquiry($validatedData);

                case 'listing-agreement':
                    // Handle listing agreement submission
                    \Log::info('Listing agreement submission handled');
                    return redirect()->back()->with('success', 'Listing agreement submitted successfully.');

                case 'purchase-agreement':
                    // Handle purchase agreement submission
                    \Log::info('Purchase agreement submission handled');
                    return redirect()->back()->with('success', 'Purchase agreement submitted successfully.');

                default:
                    \Log::warning('Invalid form type: ' . $formType);
                    return redirect()->back()->with('error', 'Invalid form type.');
            }
        } catch (\Exception $e) {
            \Log::error('Error processing ' . $formType . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing your form.');
        }
    }

    private function handleContactInquiry($validatedData)
    {
        try {
            $inquiry = new ContactInquiry();

            // Basic information
            $inquiry->full_name = $validatedData['full_name'];
            $inquiry->email = $validatedData['email'];
            $inquiry->phone = $validatedData['phone'] ?? null;
            $inquiry->property_address = $validatedData['property_address'] ?? null;
            $inquiry->inquiry_type = $validatedData['inquiry_type'];
            $inquiry->message = $validatedData['message'];
            $inquiry->subscribe_newsletter = $validatedData['subscribe_newsletter'] ?? false;

            // Set user information
            if (Auth::check()) {
                $user = Auth::user();
                $inquiry->user_id = $user->id;
                $inquiry->submitter_type = $user->user_type;
            } else {
                $inquiry->submitter_type = 'viewer';
            }

            // Always set initial status to pending
            $inquiry->status = 'pending';

            $inquiry->save();

            \Log::info('Contact inquiry created successfully', [
                'inquiry_id' => $inquiry->id,
                'user_id' => $inquiry->user_id ?? 'guest',
                'status' => $inquiry->status
            ]);

            return redirect()
                ->back()
                ->with('success', 'Your inquiry has been submitted successfully. We will contact you soon.');

        } catch (\Exception $e) {
            \Log::error('Error creating contact inquiry: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getValidator(Request $request, $formType)
    {
        $rules = $this->getValidationRules($formType);
        return Validator::make($request->all(), $rules);
    }

    private function getValidationRules($formType)
    {
        switch ($formType) {
            case 'listing-agreement':
                return [
                    'seller_name' => 'required|string|max:255',
                    'property_address' => 'required|string|max:255',
                    'listing_price' => 'required|numeric|min:0',
                    'commission_rate' => 'required|numeric|min:0|max:100',
                    'listing_start_date' => 'required|date',
                    'listing_end_date' => 'required|date|after:listing_start_date',
                ];

            case 'property-disclosure':
                return [
                    'seller_name' => 'required|string|max:255',
                    'property_address' => 'required|string|max:255',
                    'structural' => 'nullable|array',
                    'systems' => 'nullable|array',
                    'environmental' => 'nullable|array',
                    'additional_issues' => 'nullable|string',
                    'confirm_disclosure' => 'required|accepted',
                ];

            case 'purchase-agreement':
                return [
                    'buyer_name' => 'required|string|max:255',
                    'seller_name' => 'required|string|max:255',
                    'property_address' => 'required|string|max:255',
                    'purchase_price' => 'required|numeric|min:0',
                    'closing_date' => 'required|date|after:today',
                ];

            case 'contact-inquiry':
                return [
                    'full_name' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'phone' => 'nullable|string|max:20',
                    'property_address' => 'nullable|string|max:255',
                    'inquiry_type' => 'required|in:general,property,showing,selling,other',
                    'message' => 'required|string',
                    'subscribe_newsletter' => 'nullable|boolean',
                ];

            default:
                return [];
        }
    }
}
