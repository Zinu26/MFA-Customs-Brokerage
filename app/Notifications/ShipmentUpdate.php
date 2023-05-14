<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShipmentUpdate extends Notification
{
    use Queueable;

    protected $shipment;
    protected $message;
    protected $activity;
    protected $changes;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($shipment, $message, $changes, $activity)
    {
        $this->shipment = $shipment;
        $this->message = $message;
        $this->activity = $activity;
        $this->changes = $changes;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'shipment_id' => $this->shipment->id,
            'message' => $this->message,
            'changes' => $this->changes,
            'activity' => $this->activity,
        ];
    }
}
