<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorProfile;
use App\Models\Category;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    // Show current step
    public function index()
    {
        $profile = auth()->user()->vendorProfile;

        // Already completed
        if ($profile && $profile->onboarding_complete) {
            return redirect()->route('vendor.dashboard');
        }

        $step = $profile ? ($profile->onboarding_step + 1) : 1;
        $step = min($step, 5);

        return redirect()->route('vendor.onboarding.step', $step);
    }

    public function step($step)
    {
        $profile    = auth()->user()->vendorProfile;
        $categories = Category::whereNull('parent_id')->get();

        // Prevent skipping steps
        $currentStep = $profile ? $profile->onboarding_step : 0;
        if ($step > $currentStep + 1) {
            return redirect()->route('vendor.onboarding.step', $currentStep + 1);
        }

        // Already done
        if ($profile && $profile->onboarding_complete) {
            return redirect()->route('vendor.dashboard');
        }

        return view('vendor.onboarding.index', compact('step', 'profile', 'categories'));
    }

    // Step 1 — Shop Info
    public function saveStep1(Request $request)
    {
        $request->validate([
            'shop_name'        => 'required|string|max:255',
            'shop_description' => 'required|string|min:20|max:1000',
            'shop_category'    => 'required|string',
            'business_type'    => 'required|in:individual,company',
            'shop_logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'user_id'          => auth()->id(),
            'shop_name'        => $request->shop_name,
            'shop_description' => $request->shop_description,
            'shop_category'    => $request->shop_category,
            'business_type'    => $request->business_type,
            'onboarding_step'  => 1,
            'status'           => 'pending',
        ];

        if ($request->hasFile('shop_logo')) {
            $data['shop_logo'] = $request->file('shop_logo')
                ->store('vendor-logos', 'public');
        }

        VendorProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            $data
        );

        return redirect()->route('vendor.onboarding.step', 2);
    }

    // Step 2 — Contact Info
    public function saveStep2(Request $request)
    {
        $request->validate([
            'phone'   => 'required|string|min:10|max:15',
            'address' => 'required|string|max:255',
            'city'    => 'required|string|max:100',
            'state'   => 'required|string|max:100',
            'zip'     => 'required|string|max:10',
            'country' => 'required|string|max:100',
        ]);

        auth()->user()->vendorProfile->update([
            'phone'           => $request->phone,
            'address'         => $request->address,
            'city'            => $request->city,
            'state'           => $request->state,
            'zip'             => $request->zip,
            'country'         => $request->country,
            'onboarding_step' => 2,
        ]);

        return redirect()->route('vendor.onboarding.step', 3);
    }

    // Step 3 — Bank Info
    public function saveStep3(Request $request)
    {
        $request->validate([
            'bank_account_name'   => 'required|string|max:255',
            'bank_account_number' => [
                'required',
                'string',
                'min:9',
                'max:18',
                'regex:/^[0-9]+$/',
            ],
            'bank_ifsc'  => [
                'required',
                'string',
                'regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            ],
            'bank_name'  => 'required|string|max:255',
            'gst_number' => [
                'nullable',
                'string',
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/',
            ],
        ], [
            'bank_account_number.regex' => 'Account number must contain only digits.',
            'bank_ifsc.regex'           => 'Enter valid IFSC code (e.g. SBIN0001234).',
            'gst_number.regex'          => 'Enter valid 15-digit GST number.',
        ]);

        auth()->user()->vendorProfile->update([
            'bank_account_name'   => $request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_ifsc'           => strtoupper($request->bank_ifsc),
            'bank_name'           => $request->bank_name,
            'gst_number'          => $request->gst_number,
            'onboarding_step'     => 3,
        ]);

        return redirect()->route('vendor.onboarding.step', 4);
    }

    // Step 4 — Identity
    public function saveStep4(Request $request)
    {
        $request->validate([
            'id_type'     => 'required|in:aadhar,pan,passport',
            'id_number'   => 'required|string|max:20',
            'id_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'id_document.mimes' => 'Document must be JPG, PNG, or PDF.',
            'id_document.max'   => 'Document must be under 5MB.',
        ]);

        $docPath = $request->file('id_document')
            ->store('vendor-documents', 'public');

        auth()->user()->vendorProfile->update([
            'id_type'         => $request->id_type,
            'id_number'       => strtoupper($request->id_number),
            'id_document'     => $docPath,
            'onboarding_step' => 4,
        ]);

        return redirect()->route('vendor.onboarding.step', 5);
    }

    // Step 5 — Submit for Review
    public function submit()
    {
        auth()->user()->vendorProfile->update([
            'onboarding_step'     => 5,
            'onboarding_complete' => true,
            'status'              => 'pending',
        ]);

        return redirect()->route('vendor.onboarding.submitted');
    }

    public function submitted()
    {
        return view('vendor.onboarding.submitted');
    }
}