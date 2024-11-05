<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\PropertyDisclosure;

class PropertyDisclosureSubmitted extends Notification
{
    use Queueable;

    protected $disclosure;

    public function __construct(PropertyDisclosure $disclosure)
    {
        $this->disclosure = $disclosure;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('A new property disclosure form has been submitted.')
                    ->line('Seller: ' . $this->disclosure->seller_name)
                    ->line('Property: ' . $this->disclosure->property_address)
                    ->action('View Disclosure', url('/admin/property-disclosures/' . $this->disclosure->id))
                    ->line('Please review the details and take appropriate action.');
    }
}