<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'start_time',
        'day_of_the_week',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
    ];

    public function routePaths()
    {
        return $this->hasMany(RoutePath::class, 'route_id')->orderBy('segment_order_number');
    }

    /**
    Given a certain endAddress it will go through address in
    order of routes and calculate the arrival time based
    off of travel_time_minutes of each addressSegment.
    @return null|Carbon
    */
    public function getArrivalTime(int $targetAddressId)
    {
        // Check if targetAddressId exists in the route
        if (!$this->routePaths()
                ->whereHas('addressSegment', function ($query) use ($targetAddressId) {
                return $query->where('end_address_id', $targetAddressId)
                    ->orWhere('start_address_id', $targetAddressId);
                })
                ->exists())
            return null;

        // Traverse through addresses and calculate arrival time
        $currentTime = $this->start_time;
        $paths = $this->routePaths()
            ->orderBy('segment_order_number')
            ->with(['addressSegment.endAddress'])
            ->get();

        // return start_time if the target is the first address in a route
        if ($paths->first()->addressSegment->start_address_id == $targetAddressId)
            return $this->start_time;

        foreach ($paths as $path) {
            $currentTime->addMinutes($path->addressSegment->travel_time_minutes);

            if ($path->addressSegment->end_address_id == $targetAddressId)
                break;
        }

        return $currentTime;
    }

    /**
    output format:
        [
            ['city' => 'Ermelo', 'address' => 'Total, 96 Fourie Street', 'time' => '10am'],
            ['city' => 'Middelburg', 'address' => 'Shell Ultra City Middelburg N4', 'time' => '11:30am'],
            ['city' => 'Pretoria', 'address' => 'Shell Ultra City Middelburg N4', 'time' => '1pm'],
        ]
     */
    public function getRoutePathArray()
    {
        $paths = $this->routePaths()
            ->orderBy('segment_order_number')
            ->with(['addressSegment.startAddress', 'addressSegment.endAddress', 'addressSegment.travel_time_minutes'])
            ->get();

        $currentTime = $this->start_time;

        $routesArray = $paths->map(function (RoutePath $routePath) use (&$currentTime) {
            /** @var Address $startAddress */
            $startAddress = $routePath->addressSegment->startAddress;

            $timeString = $currentTime->format('g:ia');
            $currentTime->addMinutes($routePath->addressSegment->travel_time_minutes);

            return [
                'city' => $startAddress->city,
                'address' => $startAddress->street,
                'time' => $timeString,
            ];
        });

        $lastRoutePath = $paths->last();
        $timeString = $currentTime->format('g:ia');
        $routesArray[] = [
            'city' => $lastRoutePath->addressSegment->endAddress->city,
            'address' => $lastRoutePath->addressSegment->endAddress->street,
            'time' => $timeString,
        ];

        return $routesArray;

    }
}
