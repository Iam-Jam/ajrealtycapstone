<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactInquiry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'property_address',
        'inquiry_type',
        'message',
        'submitter_type',
        'assigned_to',
        'department',
        'subscribe_newsletter',
        'status',
        'internal_notes'
    ];

    protected $dates = [
        'responded_at',
        'resolved_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Relationship to user who submitted the inquiry
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to assigned agent/employee
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Scopes for filtering
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    // Helper methods
    public function isAssigned()
    {
        return !is_null($this->assigned_to);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function markAsResponded()
    {
        $this->responded_at = now();
        $this->save();
    }

    public function markAsResolved()
    {
        $this->resolved_at = now();
        $this->status = 'completed';
        $this->save();
    }
}
