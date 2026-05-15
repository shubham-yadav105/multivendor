<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorProfile;
use Illuminate\Http\Request;

class VendorProfileController extends Controller
{
    public function edit()
    {
        $profile = auth()->user()->vendorProfile;
        return view('vendor.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'shop_name'        => 'required|string|max:255',
            'shop_description' => 'nullable|string|max:1000',
            'shop_logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'shop_name'        => $request->shop_name,
            'shop_description' => $request->shop_description,
        ];

        if ($request->hasFile('shop_logo')) {
            $data['shop_logo'] = $request->file('shop_logo')->store('vendor-logos', 'public');
        }

        VendorProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            $data
        );

        return back()->with('success', 'Shop profile updated!');
    }
}