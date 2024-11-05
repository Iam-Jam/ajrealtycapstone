<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use Notifiable;

    const TYPE_ADMIN = 'admin';
    const TYPE_SELLER = 'seller';
    const TYPE_RENTER = 'renter';
    const TYPE_BUYER = 'buyer';
    const TYPE_VIEWER = 'viewer';
    const TYPE_AGENT1 = 'agent1';
    const TYPE_AGENT2 = 'agent2';
    const TYPE_EMPLOYEE = 'employee';

    protected $fillable = [
        'name', 'username', 'email', 'password', 'user_type', 'security_question', 'security_answer', 'admin_level'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function loginLogs()
    {
        return $this->hasMany(LoginLog::class);
    }

    // Contact Inquiry Relations
    public function contactInquiries()
    {
        return $this->hasMany(ContactInquiry::class);
    }

    public function assignedInquiries()
    {
        return $this->hasMany(ContactInquiry::class, 'assigned_to');
    }

    public function isSeller()
    {
        return $this->user_type === self::TYPE_SELLER;
    }

    public function isRenter()
    {
        return $this->user_type === self::TYPE_RENTER;
    }

    public function isBuyer()
    {
        return $this->user_type === self::TYPE_BUYER;
    }

    public function isViewer()
    {
        return $this->user_type === self::TYPE_VIEWER;
    }

    public function isAgent1()
    {
        return $this->user_type === self::TYPE_AGENT1;
    }

    public function isAgent2()
    {
        return $this->user_type === self::TYPE_AGENT2;
    }

    public function isEmployee()
    {
        return $this->user_type === self::TYPE_EMPLOYEE;
    }

    public function isAgent()
    {
        return $this->isAgent1() || $this->isAgent2();
    }

    public function hasUserType($type)
    {
        return $this->user_type === $type;
    }

    public function hasAnyUserType(...$types)
    {
        return in_array($this->user_type, $types);
    }

  

    public function listingAgreements()
    {
        return $this->hasMany(ListingAgreement::class);
    }

    public function propertyDisclosures()
    {
        return $this->hasMany(PropertyDisclosure::class);
    }

    public function purchaseAgreements()
    {
        return $this->hasMany(PurchaseAgreement::class);
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }



    public function canListProperty()
    {
        return $this->hasAnyUserType(
            self::TYPE_ADMIN,
            self::TYPE_SELLER,
            self::TYPE_AGENT1,
            self::TYPE_AGENT2
        );
    }

    // Helper method for contact inquiry permissions
    public function canManageInquiries()
    {
        return $this->hasAnyUserType(
            self::TYPE_ADMIN,
            self::TYPE_AGENT1,
            self::TYPE_AGENT2,
            self::TYPE_EMPLOYEE
        );
    }

    // Helper method to get all forms including contact inquiries
    public function getAllForms()
    {
        return [
            'listingAgreements' => $this->listingAgreements,
            'propertyDisclosures' => $this->propertyDisclosures,
            'purchaseAgreements' => $this->purchaseAgreements,
            'contactInquiries' => $this->contactInquiries,
        ];
    }
}
