<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\PurchaseAgreement;

class PurchaseAgreementNotification extends Notification
{
    use Queueable;

    protected $action;
    protected $agreement;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $action, PurchaseAgreement $agreement)
    {
        $this->action = $action;
        $this->agreement = $agreement;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line("Your purchase agreement has been {$this->action}.")
                    ->action('View Agreement', url("/purchase-agreements/{$this->agreement->id}"))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'action' => $this->action,
            'agreement_id' => $this->agreement->id,
        ];
    }
}
