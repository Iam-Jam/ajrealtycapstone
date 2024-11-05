<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\ListProperty;

class NewPropertyListingNotification extends Notification
{
    use Queueable;

    protected $property;
    protected $type; // 'new' or 'status_change'
    protected $newStatus;
    protected $adminName;

    public function __construct(ListProperty $property, $type = 'new', $newStatus = null, $adminName = null)
    {
        $this->property = $property;
        $this->type = $type;
        $this->newStatus = $newStatus;
        $this->adminName = $adminName;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        if ($this->type === 'status_change') {
            return (new MailMessage)
                ->subject('Property Listing Status Updated')
                ->greeting('Hello ' . $notifiable->name)
                ->line("Your property listing '{$this->property->title}' status has been updated.")
                ->line('Current Status: ' . ucfirst($this->newStatus))
                ->action('View Listing', route('list-sell-property.show', $this->property))
                ->line('Thank you for using our application!');
        }

        return (new MailMessage)
            ->subject('New Property Listing Submitted')
            ->line('A new property listing has been submitted.')
            ->line('Title: ' . $this->property->title)
            ->line('Type: ' . $this->property->type)
            ->line('Price: ₱' . number_format($this->property->price, 2))
            ->action('View Listing', route('list-sell-property.show', $this->property))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        if ($this->type === 'status_change') {
            return [
                'property_id' => $this->property->id,
                'title' => $this->property->title,
                'status' => $this->newStatus,
                'updated_by' => $this->adminName,
                'timestamp' => now(),
                'type' => 'status_change',
                'message' => $this->getStatusMessage()
            ];
        }

        return [
            'property_id' => $this->property->id,
            'title' => $this->property->title,
            'type' => $this->property->type,
            'price' => $this->property->price,
            'type' => 'new_listing'
        ];
    }

    private function getStatusMessage(): string
    {
        return $this->newStatus === 'approved'
            ? "Your property listing '{$this->property->title}' has been approved."
            : "Your property listing '{$this->property->title}' has been marked as pending.";
    }
}
