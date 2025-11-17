<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Validation\Rule;
use WireUi\Traits\WireUiActions;

#[Layout('components.layouts.marketing')]
class Book extends Component
{
    use WireUiActions;

    public $departure_timeslots = ['10am', '2pm'];
    public $return_timeslots = ['10am'];

    public $selected_departure;
    public $selected_return;

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

    public function render()
    {
        return view('livewire.book');
    }
}
