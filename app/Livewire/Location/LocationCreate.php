<?php

namespace App\Livewire\Location;

use App\Models\OfficeLocation;
use Livewire\Component;

class LocationCreate extends Component
{
    public $name, $latitude, $longitude, $radius_in_meters = 100;

    public function render()
    {
        return view('livewire.location.location-create');
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius_in_meters' => 'required|numeric|min:1',
        ]);

        OfficeLocation::create([
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'radius_in_meters' => $this->radius_in_meters,
        ]);

        session()->flash('success', 'Lokasi berhasil disimpan!');
        return redirect()->route('location.index');
    }
}
