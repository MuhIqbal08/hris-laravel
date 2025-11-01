<?php

namespace App\Livewire\Location;

use Livewire\Component;

class LocationShow extends Component
{
    public function mount($uuid) {
        $this->location = \App\Models\OfficeLocation::where('uuid', $uuid)->first();
    }
    public function render()
    {
        return view('livewire.location.location-show');
    }
}
