<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FormSubmissionNotification extends Notification
{
    use Queueable;

    protected $formName;
    protected $formData;

    public function __construct($formName, $formData)
    {
        $this->formName = $formName;
        $this->formData = $formData;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject("New {$this->formName} Submission")
                    ->line("A new {$this->formName} has been submitted.")
                    ->line("Form details:")
                    ->line(json_encode($this->formData, JSON_PRETTY_PRINT));
    }
}
