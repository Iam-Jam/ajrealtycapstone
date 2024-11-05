<?php

// app/Models/ListingAgreement.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingAgreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seller_name',
        'seller_phone',
        'property_address',
        'property_city',
        'property_state',
        'property_zip',
        'listing_price',
        'commission_rate',
        'listing_start_date',
        'listing_end_date',
        'property_description',
        'special_conditions',
    ];

    protected $casts = [
        'listing_start_date' => 'date',
        'listing_end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
}


}
