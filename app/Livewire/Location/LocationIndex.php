<?php

namespace App\Livewire\Location;

use App\Models\OfficeLocation;
use Livewire\Component;

class LocationIndex extends Component
{
    public function render()
    {
        $locations = OfficeLocation::all();
        return view('livewire.location.location-index', compact('locations'));
    }
}
