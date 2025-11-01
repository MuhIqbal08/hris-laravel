<?php

namespace App\Livewire\Location;

use Livewire\Component;

class LocationEdit extends Component
{
    public $location, $name, $latitude, $longitude, $radius_in_meters;
    public function mount($uuid) {
        $this->location = \App\Models\OfficeLocation::where('uuid', $uuid)->first();
        $this->name = $this->location->name;
        $this->latitude = $this->location->latitude;
        $this->longitude = $this->location->longitude;
        $this->radius_in_meters = $this->location->radius_in_meters;
    }
    public function render()
    {
        return view('livewire.location.location-edit');
    }

    public function submit () {
        $this->validate([
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'radius_in_meters' => 'required|numeric|min:1',
        ]);
        
        $this->location->name = $this->name;
        $this->location->latitude = $this->latitude;
        $this->location->longitude = $this->longitude;
        $this->location->radius_in_meters = $this->radius_in_meters;
        $this->location->save();

        return to_route('location.index',)->with('success', 'Lokasi berhasil disimpan!');
    }
}
