<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorProfile extends Model
{
    protected $fillable = [
        'user_id', 'shop_name', 'shop_description', 'shop_logo',
        'shop_category', 'status',

        // Contact
        'phone', 'address', 'city', 'state', 'zip', 'country',

        // Business
        'business_type', 'gst_number',

        // Bank
        'bank_account_name', 'bank_account_number',
        'bank_ifsc', 'bank_name',

        // Identity
        'id_type', 'id_number', 'id_document',

        // Onboarding
        'onboarding_step', 'onboarding_complete',
    ];

    protected $casts = [
        'onboarding_complete' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}