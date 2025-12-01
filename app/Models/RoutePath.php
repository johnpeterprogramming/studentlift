<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoutePath extends Model
{
    protected $fillable = [
        'route_id',
        'address_segment_id',
        'segment_order_number',
    ];

    public function route() : BelongsTo
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function addressSegment() : BelongsTo
    {
        return $this->belongsTo(AddressSegment::class, 'address_segment_id');
    }
}
