<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserRegistered extends Notification
{
    public $registration;

    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New User Registered')
            ->line('A new user has registered on your website.')
            ->line('User Details:')
            ->line('Name: ' . $this->registration->name)
            ->line('Email: ' . $this->registration->email)
            ->line('User Type: ' . $this->registration->user_type);
    }
}
