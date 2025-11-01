<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Models\OfficeLocation;
use Carbon\Carbon;
use Livewire\Component;

class AttendanceEdit extends Component
{
    public $attendance;
    public $latitude, $longitude, $address;
    public $employees, $employee_id, $check_in_time, $check_out_time, $date, $work_schedule_id, $duration, $status, $remarks;
    public $check_in_latitude, $check_in_longitude, $check_in_address;
    public $check_out_latitude, $check_out_longitude, $check_out_address;

    protected $listeners = [
        'setLocation' => 'setUserLocation',
    ];

    public function mount($uuid)
    {
        $this->attendance = Attendance::where('uuid', $uuid)->firstOrFail();

        $this->employees = Employee::with('user')->get();

        $this->employee_id = $this->attendance->employee_id;
        $this->check_in_time = $this->attendance->check_in_time;
        $this->check_out_time = $this->attendance->check_out_time;
        $this->date = $this->attendance->date;
        $this->work_schedule_id = $this->attendance->work_schedule_id;
        $this->duration = $this->attendance->duration;
        $this->status = $this->attendance->status;
        $this->remarks = $this->attendance->remarks;
        $this->check_in_latitude = $this->attendance->check_in_latitude;
        $this->check_in_longitude = $this->attendance->check_in_longitude;
        $this->check_in_address = $this->attendance->check_in_address;
        $this->check_out_latitude = $this->attendance->check_out_latitude;
        $this->check_out_longitude = $this->attendance->check_out_longitude;
        $this->check_out_address = $this->attendance->check_out_address;
    }

    public function render()
    {
        $employees = $this->employees;
        return view('livewire.attendance.attendance-edit', compact('employees'));
    }

    public function setUserLocation($latitude, $longitude, $address)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->address = $address;
    }

    public function update()
    {
        $this->validate([
            'employee_id' => 'required',
            'check_in_time' => 'required',
            'check_out_time' => 'required',
            'date' => 'required|date',
            'status' => 'required',
            'check_in_latitude' => 'required|numeric',
            'check_in_longitude' => 'required|numeric',
            'check_out_latitude' => 'required|numeric',
            'check_out_longitude' => 'required|numeric',
        ]);

        $officeLocation = OfficeLocation::first();
        if (!$officeLocation) {
            session()->flash('error', 'Lokasi kantor belum diset.');
            return;
        }

        // Validasi posisi jika perlu
        $distance = \App\Services\LocationService::calculateDistance(
            $officeLocation->latitude,
            $officeLocation->longitude,
            $this->check_in_latitude,
            $this->check_in_longitude
        );

        if ($distance > $officeLocation->radius_in_meters) {
            session()->flash('error', 'Lokasi check-in di luar area kantor.');
            return;
        }

        $this->attendance->update([
            'employee_id' => $this->employee_id,
            'check_in_time' => $this->check_in_time,
            'check_out_time' => $this->check_out_time,
            'date' => $this->date,
            'work_schedule_id' => $this->work_schedule_id,
            'duration' => Carbon::parse($this->check_out_time)->diffInMinutes(Carbon::parse($this->check_in_time)),
            'status' => $this->status,
            'remarks' => $this->remarks,
            'check_in_latitude' => $this->check_in_latitude,
            'check_in_longitude' => $this->check_in_longitude,
            'check_in_address' => $this->check_in_address ?? 'Lokasi Check-in',
            'check_out_latitude' => $this->check_out_latitude,
            'check_out_longitude' => $this->check_out_longitude,
            'check_out_address' => $this->check_out_address ?? 'Lokasi Check-out',
        ]);

        return redirect()->route('attendance.index')->with('success', 'Data absensi berhasil diperbarui!');
    }
}
