<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Validation\Rule;
use WireUi\Traits\WireUiActions;

use App\Models\Route;
use App\Models\RoutePath;
use App\Models\Address;

#[Layout('components.layouts.marketing')]
class Book extends Component
{
    use WireUiActions;

    // Addresses
    public $departureAddresses = [];
    public $returnAddresses = [];

    // timeslots based off of selected address
    public $departureTimeslots = [];
    public $returnTimeslots = [];

    // Form fields, Todo: add membership pass
    public $selectedDeparture;
    public $selectedReturn;

    public function rules()
    {
        return [
            'selected_departure' => ['required', Rule::in($this->departure_timeslots)],
            'selected_return' => ['required', Rule::in($this->return_timeslots)],
        ];
    }

    public function book()
    {
        $this->validate();

        $this->notification()->success(
            $title = 'Booking Confirmed',
            $description = 'Your trip has been successfully saved.'
        );

        return $this->redirect(route('register'), navigate: true);
    }

    public function mount()
    {
        /* $startAddressesInARoute = Address::startAddressesConnectedToRoute() */
        /*     ->get(); */
        /* $endAddressesInARoute = Address::endAddressesConnectedToRoute() */
        /*     ->get(); */

        $this->departureAddresses = Route::with([
            'routePaths',
            'routePaths.addressSegment',
            'routePaths.addressSegment.startAddress'])
            ->get()
            ->flatmap(function (Route $route) {
            return $route->routePaths->map(function (RoutePath $routePath) use ($route) {
                $startAddressId = $routePath->addressSegment->start_address_id;
                return [
                    'id' => $startAddressId,
                    'name' => $routePath->addressSegment->startAddress->city,
                    'description' => $route->getArrivalTime($startAddressId)->format("H:i"),
                ];
            });
        });

        $this->returnAddresses = Route::with([
            'routePaths',
            'routePaths.addressSegment',
            'routePaths.addressSegment.startAddress'])
            ->get()
            ->flatmap(function (Route $route) {
            return $route->routePaths->map(function (RoutePath $routePath) use ($route) {
                $endAddressId = $routePath->addressSegment->end_address_id;
                return [
                    'id' => $endAddressId,
                    'name' => $routePath->addressSegment->endAddress->city,
                    'description' => $route->getArrivalTime($endAddressId)->format("H:i"),
                ];
            });
        });

    }

    public function render()
    {
        return view('livewire.book');
    }
}
