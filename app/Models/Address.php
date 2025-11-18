<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'city',
        'street',
    ];

    public function startAddressSegments()
    {
        return $this->hasMany(AddressSegment::class, 'start_address_id');
    }

    public function endAddressSegments()
    {
        return $this->hasMany(AddressSegment::class, 'end_address_id');
    }

    public static function startAddressesConnectedToRoute()
    {
        return static::whereHas('startAddressSegments', function ($query) {
            return $query->has('routePaths');
        });
    }

    public static function endAddressesConnectedToRoute()
    {
        return static::whereHas('endAddressSegments', function ($query) {
            return $query->has('routePaths');
        });
    }
}
