<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseAgreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'property_id',
        'buyer_name',
        'seller_name',
        'property_address',  // Add this line
        'purchase_price',
        'earnest_money',
        'closing_date',
        'possession_date',
        'contingencies',
        'additional_terms',
        'agree_terms',
        'status',
    ];

    protected $casts = [
        'contingencies' => 'array',
        'closing_date' => 'date',
        'possession_date' => 'date',
        'purchase_price' => 'decimal:2',
        'earnest_money' => 'decimal:2',
        'agree_terms' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
