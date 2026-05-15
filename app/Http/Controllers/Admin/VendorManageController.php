<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class VendorManageController extends Controller
{
    public function index()
    {
        $vendors = User::where('role', 'vendor')
            ->with('vendorProfile')
            ->when(request('status'), fn($q) =>
                $q->whereHas('vendorProfile', fn($q2) =>
                    $q2->where('status', request('status'))))
            ->when(request('search'), fn($q) =>
                $q->where('name', 'like', '%' . request('search') . '%'))
            ->latest()
            ->paginate(10);

        return view('admin.vendors.index', compact('vendors'));
    }

    public function approve(User $user)
    {
        $user->vendorProfile->update(['status' => 'approved']);
        return back()->with('success', 'Vendor approved successfully!');
    }

    public function reject(User $user)
    {
        $user->vendorProfile->update(['status' => 'rejected']);
        return back()->with('success', 'Vendor rejected.');
    }

    public function block(User $user)
    {
        $user->update(['status' => 'blocked']);
        return back()->with('success', 'Vendor blocked.');
    }

    public function unblock(User $user)
    {
        $user->update(['status' => 'active']);
        return back()->with('success', 'Vendor unblocked.');
    }
}