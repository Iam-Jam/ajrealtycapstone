<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'property_id',
        'title',
        'description',
        'price',
        'property_type',
        'city',
        'beds',
        'baths',
        'area_sqft',
        'image',
        'featured',
        'location',
        'property_address',
        'bedrooms',
        'bathrooms',
        'sqm',
        'type',
        'contact_email',
        'contact_messenger',
        'contact_whatsapp',
        'swimming_pool',
        'gym_access',
        'living_room',
        'dining_room',
        'additional_features',
        'lot_size',
        'is_featured',
        'is_exclusive',
        'status',
        'user_id',
        'source',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area_sqft' => 'decimal:2',
        'sqm' => 'decimal:2',
        'lot_size' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_exclusive' => 'boolean',
        'featured' => 'boolean',
        'swimming_pool' => 'boolean',
        'gym_access' => 'boolean',
        'living_room' => 'boolean',
        'dining_room' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPrimaryImageAttribute()
    {
        return $this->images()->where('is_primary', true)->first();
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    public function scopeInPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function getFormattedPriceAttribute()
    {
        return '₱' . number_format($this->price, 2);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->property_address}, {$this->city}";
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            $property->property_id = self::generatePropertyId($property);
        });
    }

    protected static function generatePropertyId($property)
    {
        $cityPrefix = substr($property->city, 0, 2);
        $year = date('y');
        $latestProperty = self::latest()->first();
        $number = $latestProperty ? (intval(substr($latestProperty->property_id, -3)) + 1) : 1;
        return strtoupper($cityPrefix) . $year . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
