<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignee extends Model
{
    use HasFactory;

    protected $table = 'consignees';

    protected $fillable = ['user_id','name', 'tin', 'contact', 'address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
