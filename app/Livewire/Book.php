<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Validation\Rule;
use WireUi\Traits\WireUiActions;

use App\Models\Route;
use App\Models\User;
use App\Models\RoutePath;
use App\Models\Booking;
use Illuminate\Support\Collection;

#[Layout('components.layouts.marketing')]
class Book extends Component
{
    use WireUiActions;

    // Addresses
    public $departureAddresses;
    public $arrivalAddresses;

    public $showMembershipPanel;
    public $selectedMembership; // null unless booking type is membership
    public $selectedDeparture;
    public $selectedArrival;

    public function rules()
    {
        return [
            'selectedDeparture' => ['required', Rule::in($this->departureAddresses->map(fn($item) => $item['value']))],
            'selectedArrival' => ['required', Rule::in($this->arrivalAddresses->map(fn($item) => $item['value']))],
        ];
    }

    public function book()
    {
        $this->validate();

        // Extract id's from hypen delimited value
        [$routeId, $departureAddressId] = explode('-', $this->selectedDeparture);
        [, $arrivalAddressId] = explode('-', $this->selectedArrival);


        // Save booking info to session incase user isn't logged in yet
        session()->put('pending_booking', [
            'route_id' => $routeId,
            'departure_address_id' => $departureAddressId,
            'arrival_address_id' => $arrivalAddressId,
            'booking_type' => $this->showMembershipPanel ? 'membership' : 'once-off',
        ]);

        return $this->redirect(route('booking.payment'), navigate: true);
        /* // Once-off Payments go straight to payment portal */
        /* if (!$this->showMembershipPanel) */
        /**/
        /* // For memberships; the user must be registered */
        /* if (!Auth::user()) */
        /*     return $this->redirect(route('register'), navigate: true); */
        /**/
        /* return $this->redirect(route('booking-success'), navigate: true); */
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function mapRouteToDepartureAddresses(Route $route): Collection
    {
        return $route->routePaths
            ->map(function (RoutePath $routePath) use ($route) {
            $startAddressId = $routePath->addressSegment->start_address_id;
            return [
                'value' => $route->id . '-' . $startAddressId,
                'name' => $routePath->addressSegment->startAddress->city,
                'description' => $route->getArrivalTime($startAddressId)?->format("H:i") ?? '',
            ];
        });
    }

    public function updatedSelectedDeparture($value) : void
    {
        $this->selectedArrival = null;

        // It's possible for no value to be selected - handle that case
        if ($value == null) {
            $this->arrivalAddresses = collect();
            return;
        }

        // Extract Route ID and Address ID
        \Log::debug("Departure Info: ", ["value" => $value]);
        [$routeId, $addressId] = explode('-', $value);

        $this->loadArrivalAddresses((int)$routeId, (int)$addressId);
    }

    private function loadArrivalAddresses(int $routeId, int $departureAddressId) : void
    {
        $route = Route::with([
            'routePaths',
            'routePaths.addressSegment',
            'routePaths.addressSegment.endAddress',
        ])->find($routeId);

        // Get segment order number from departure address
        // This will be used to ensure arrivalAddresses only display addresses that are reachable from a certain address within a route
        $departureSegmentOrderNum = (int) RoutePath::where('route_id', $routeId)
            ->whereHas('addressSegment', function ($query) use ($departureAddressId) {
                $query->where('start_address_id', $departureAddressId);
            })
            ->first()
            ->segment_order_number;

        $this->arrivalAddresses = $route->routePaths
            ->filter(function (RoutePath $routePath) use ($departureSegmentOrderNum) {
                // Only display addresses that come after the selected from address in a route
                return $routePath->segment_order_number >= $departureSegmentOrderNum;
            })
            ->map(function (RoutePath $routePath) use ($route) {
                $endAddressId = $routePath->addressSegment->end_address_id;
                return [
                    'value' => $route->id . '-' . $endAddressId,
                    'name' => $routePath->addressSegment->endAddress->city,
                    'description' => $route->getArrivalTime($endAddressId)?->format("H:i") ?? '',
                ];
            });
        \Log::debug("Arrival Addresses: " . $this->arrivalAddresses);
    }

    public function mount()
    {
        $this->showMembershipPanel = true;
        // TODO: improve readability and maybe extract logic in helper function
        // TODO: use caching here
        $this->departureAddresses = Route::with([
            'routePaths',
            'routePaths.addressSegment',
            'routePaths.addressSegment.startAddress'])
            ->get()
            ->flatmap(fn(Route $route) => $this->mapRouteToDepartureAddresses($route));

        /* \Log::debug($this->departureAddresses->map(fn($item) => $item['value'])); */
        // TODO: use caching
        $this->arrivalAddresses = collect();
    }


    public function render()
    {
        return view('livewire.book');
    }
}
