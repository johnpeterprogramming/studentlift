<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Address;
use App\Models\Route;
use Carbon\Carbon;

#[Layout('components.layouts.marketing')]
class BookingConfirm extends Component
{
    public float $price;

    public function mount()
    {
        /* $route_id = session('pending_booking')['route_id']; */
        /* $route = Route::find($route_id); */
        /**/
        /* $departure_address_id = session('pending_booking')['departure_address_id']; */
        /* $arrival_address_id = session('pending_booking')['arrival_address_id']; */
        /**/
        /* $this->bookingType = session('pending_booking')['booking_type']; */
        /**/
        /**/
        /* $this->departureAddress = Address::find($departure_address_id); */
        /* $this->arrivalAddress = Address::find($arrival_address_id); */
        /**/
        $this->price = 750.00;
    }

    public function render()
    {
        // payment-allowed middleware ensures pending_booking exists
        return view('livewire.booking-confirm');
    }


    public function getArrivalAddressProperty()
    {
        return Address::find(session('pending_booking')['arrival_address_id']);
    }

    public function getDepartureAddressProperty()
    {
        return Address::find(session('pending_booking')['departure_address_id']);
    }

    public function getArrivalTimeProperty()
    {
        $route = Route::find(session('pending_booking')['route_id']);
        $arrivalTime = $route->getArrivalTime(session('pending_booking')['arrival_address_id']);
        return $arrivalTime->format('h:i A');
    }

    public function getDepartureTimeProperty()
    {
        $route = Route::find(session('pending_booking')['route_id']);
        $departureTime = $route->getArrivalTime(session('pending_booking')['departure_address_id']);
        return $departureTime->format('h:i A');
    }
}
