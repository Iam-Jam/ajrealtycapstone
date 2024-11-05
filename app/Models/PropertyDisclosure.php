<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyDisclosure extends Model
{
    protected $fillable = [
        'user_id',
        'seller_name',
        'property_address',
        'structural_issues',
        'system_issues',
        'environmental_issues',
        'additional_issues',
        'confirm_disclosure',
    ];

    protected $casts = [
        'structural_issues' => 'array',
        'system_issues' => 'array',
        'environmental_issues' => 'array',
        'confirm_disclosure' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
