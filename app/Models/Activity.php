<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'model_type',
        'model_id',
        'ip_address',
        'user_agent'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Relationship to user who performed the activity
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Polymorphic relation to the model that was acted upon
    public function subject()
    {
        return $this->morphTo();
    }

    // Scopes for filtering
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('model_type', $type);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }
}
