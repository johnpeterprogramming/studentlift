<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressSegment extends Model
{
    protected $fillable = [
        'start_address_id',
        'end_address_id',
        'distance',
        'travel_time_minutes',
    ];

    public function routePaths()
    {
        return $this->hasMany(RoutePath::class, 'address_segment_id')->orderBy('segment_order_number');
    }

    public function startAddress()
    {
        return $this->belongsTo(Address::class, 'start_address_id');
    }

    public function endAddress()
    {
        return $this->belongsTo(Address::class, 'end_address_id');
    }
}
