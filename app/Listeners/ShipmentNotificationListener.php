<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;

class ShipmentNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }

    public function onShipmentCreated($shipment)
    {
        $data = [
            'shipment_id' => $shipment->id,
            'consignee_name' => $shipment->consignee_name,
            // add any other relevant data
        ];

        $notification = new Notification;
        $notification->type = 'shipment_created';
        $notification->notifiable_name = $shipment->consignee_name; // or any other user ID
        $notification->notifiable_type = get_class($shipment->user);
        $notification->data = $data;
        $notification->save();
    }

    public function onShipmentUpdated($shipment)
    {
        $data = [
            'shipment_id' => $shipment->id,
            'consignee_name' => $shipment->consignee_name,
            // add any other relevant data
        ];

        $notification = new Notification;
        $notification->type = 'shipment_updated';
        $notification->notifiable_name = $shipment->consignee_name; // or any other user ID
        $notification->notifiable_type = get_class($shipment->user);
        $notification->data = $data;
        $notification->save();
    }
}
