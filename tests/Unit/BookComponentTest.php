<?php

use App\Models\Address;
use App\Models\AddressSegment;
use App\Models\Route;
use App\Models\RoutePath;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    /* Define addresses */
    $this->ermeloAddress = Address::create([
        'city' => 'Ermelo',
        'street' => 'some ermelo street',
    ]);
    $this->belfastAddress = Address::create([
        'city' => 'Belfast',
        'street' => 'some belfast street',
    ]);
    $this->pretoriaAddress = Address::create([
        'city' => 'Pretoria',
        'street' => 'some pretoria street',
    ]);
    $this->middelburgAddress = Address::create([
        'city' => 'Middelburg',
        'street' => 'some middelburg street',
    ]);

    /* Define "edges" between addresses */
    $this->addressSegmentErmeloToBelfast = AddressSegment::create([
        'start_address_id' => $this->ermeloAddress->id,
        'end_address_id' => $this->belfastAddress->id,
        'distance' => 109,
        'travel_time_minutes' => 30
    ]);
    $this->addressSegmentBelfastToPretoria = AddressSegment::create([
        'start_address_id' => $this->belfastAddress->id,
        'end_address_id' => $this->pretoriaAddress->id,
        'distance' => 80,
        'travel_time_minutes' => 60
    ]);
    $this->addressSegmentErmeloToMiddelburg = AddressSegment::create([
        'start_address_id' => $this->ermeloAddress->id,
        'end_address_id' => $this->middelburgAddress->id,
        'distance' => 80,
        'travel_time_minutes' => 60
    ]);

    $this->route = Route::create([
        'start_time' => '10:00',
        'day_of_the_week' => 'friday'
    ]);

    RoutePath::insert([
        [
            'route_id' => $this->route->id,
            'address_segment_id' => $this->addressSegmentErmeloToBelfast->id,
            'segment_order_number' => 1
        ],
        [
            'route_id' => $this->route->id,
            'address_segment_id' => $this->addressSegmentBelfastToPretoria->id,
            'segment_order_number' => 2
        ]
    ]);

});

test('do not display addresses that aren\'t connected to a route path', function () {
    // Gets all the start addresses that are inside a route
    $citiesInARoute = Address::startAddressesConnectedToRoute()
        ->pluck('city');

    expect($citiesInARoute)->not->toContain('Middelburg');
    expect($citiesInARoute)
        ->toContain('Ermelo')
        ->toContain('Belfast');
});

test('getArrivalTime works properly', function () {
    expect($this->route->getArrivalTime($this->ermeloAddress->id)->eq(Carbon::parse('10:00')))->toBe(true);
    expect($this->route->getArrivalTime($this->belfastAddress->id)->eq(Carbon::parse('10:30')))->toBe(true);
    expect($this->route->getArrivalTime($this->pretoriaAddress->id)->eq(Carbon::parse('11:30')))->toBe(true);
    expect($this->route->getArrivalTime($this->middelburgAddress->id))->toBe(null);
});
