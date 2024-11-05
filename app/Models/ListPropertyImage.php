<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListPropertyImage extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'list_sell_property_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'property_id',
        'image_path',
        'is_primary'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Get the property that owns the image.
     */
    public function property()
    {
        return $this->belongsTo(ListProperty::class, 'property_id');
    }

    /**
     * Get the URL for the image.
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }

    /**
     * Set this image as the primary image for the property.
     */
    public function makePrimary()
    {
        $this->property->images()->update(['is_primary' => false]);
        $this->update(['is_primary' => true]);
    }
}
