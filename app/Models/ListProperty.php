<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListProperty extends Model
{
    use HasFactory;

    protected $table = 'list_sell_properties';

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';

    protected $fillable = [
        'user_id',
        'property_option',
        'title',
        'type',
        'bedrooms',
        'bathrooms',
        'sqm',
        'price',
        'property_address',
        'city',
        'description',
        'swimming_pool',
        'gym_access',
        'living_room',
        'dining_room',
        'contact_whatsapp',
        'contact_messenger',
        'contact_email',
        'is_featured',
        'is_exclusive',
        'status'
    ];

    protected $attributes = [
        'status' => self::STATUS_PENDING,
        'is_featured' => false,
        'is_exclusive' => false
    ];

    protected $casts = [
        'swimming_pool' => 'boolean',
        'gym_access' => 'boolean',
        'living_room' => 'boolean',
        'dining_room' => 'boolean',
        'is_featured' => 'boolean',
        'is_exclusive' => 'boolean'
    ];

    /**
     * Get the user that owns the property listing
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the images for the property listing
     */
    public function images()
    {
        return $this->hasMany(ListPropertyImage::class, 'property_id');
    }

    /**
     * Check if the property is pending
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if the property is approved
     */
    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Get valid status values
     */
    public static function getValidStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_APPROVED
        ];
    }

    /**
     * Set the status of the property
     */
    public function setStatus(string $status): bool
    {
        if (!in_array($status, self::getValidStatuses())) {
            return false;
        }

        $this->status = $status;
        return $this->save();
    }

    /**
     * Toggle the featured status
     */
    public function toggleFeatured(): bool
    {
        $this->is_featured = !$this->is_featured;
        return $this->save();
    }

    /**
     * Toggle the exclusive status
     */
    public function toggleExclusive(): bool
    {
        $this->is_exclusive = !$this->is_exclusive;
        return $this->save();
    }

    /**
     * Scope a query to only include pending properties
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope a query to only include approved properties
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Scope a query to only include featured properties
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include exclusive properties
     */
    public function scopeExclusive($query)
    {
        return $query->where('is_exclusive', true);
    }

    /**
     * Get the property type formatted for display
     */
    public function getFormattedType(): string
    {
        return ucfirst(str_replace('_', ' ', $this->type));
    }

    /**
     * Get the formatted price
     */
    public function getFormattedPrice(): string
    {
        return '₱' . number_format($this->price, 2);
    }

    /**
     * Check if user can manage this property
     */
    public function canBeManageBy(User $user): bool
    {
        return $user->user_type === 'admin' ||
               ($user->id === $this->user_id &&
                in_array($user->user_type, ['agent1', 'agent2', 'seller']));
    }



public function getImageUrlAttribute()
{
    if ($this->images()->exists()) {
        $primaryImage = $this->images()->where('is_primary', true)->first();
        if ($primaryImage) {
            return Storage::disk('public')->url($primaryImage->image_path);
        }
    }

    return asset('images/no-image.jpg');
}




}
