<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmail;


class Registration extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'security_question',
        'security_answer',
        'verification_token',
        'expires_at',
    ];

    protected $hidden = [
        'password',
        'verification_token',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail($this->verification_token));
    }
}
