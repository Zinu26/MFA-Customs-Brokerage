<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'consignee_name',
        'user_id',
        'shipment_details',
        'size',
        'weight',
        'bl_number',
        'entry_number',
        'shipping_line',
        'arrival_date',
        'port_of_origin',
        'destination_address',
        'shipment_status',
        'do_status',
        'billing_status',
    ];

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
