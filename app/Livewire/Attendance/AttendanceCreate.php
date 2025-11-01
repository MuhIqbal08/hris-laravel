<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\EmployeeSchedule;
use App\Models\OfficeLocation;
use Carbon\Carbon;
use Livewire\Component;

class AttendanceCreate extends Component
{
    public $latitude, $longitude, $address;
    public $employees, $employee_id, $check_in_time, $check_out_time, $date, $work_schedule_id, $duration, $status, $remarks;
    public $check_in_latitude, $check_in_longitude, $check_in_address;
    public $check_out_latitude, $check_out_longitude, $check_out_address;

    protected $listeners = [
        'setLocation' => 'setUserLocation',
    ];

    public function mount()
    {
        $this->employees = Employee::with('user')->get();

    // Jika employee_id belum ada, set default ke data pertama
    if ($this->employees->isNotEmpty() && !$this->employee_id) {
        $this->employee_id = $this->employees->first()->uuid;
    }
    }

    public function render()
    {
        $employees = Employee::with('user')->get();
        return view('livewire.attendance.attendance-create', compact('employees'));
    }

     public function setUserLocation($latitude, $longitude, $address)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->address = $address;
    }

    public function submit()
    {
        // dd('Form submit terpicu!');
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

        // Cek apakah sudah absen hari ini
        $todayAttendanceExists = Attendance::where('employee_id', $this->employee_id)
            ->whereDate('date', Carbon::today())
            ->exists();

        if ($todayAttendanceExists) {
            session()->flash('error', 'Anda sudah melakukan absensi hari ini.');
            return;
        }

        // Cek apakah karyawan punya jadwal kerja
        $userSchedule = EmployeeSchedule::where('employee_id', $this->employee_id)
            ->latest()
            ->first();

        if (!$userSchedule) {
            session()->flash('error', 'Anda belum memiliki jadwal kerja.');
            return;
        }

        $scheduleDetail = $userSchedule->work_schedule_id;

        // Ambil lokasi kantor
        $officeLocation = OfficeLocation::first();
        if (!$officeLocation) {
            session()->flash('error', 'Lokasi kantor belum diset.');
            return;
        }

        // Hitung jarak ke kantor
        $distance = \App\Services\LocationService::calculateDistance(
            $officeLocation->latitude,
            $officeLocation->longitude,
            $this->check_in_latitude,
            $this->check_in_longitude
        );

        if ($distance > $officeLocation->radius_in_meters) {
            session()->flash('error', 'Anda belum berada di lokasi kantor.');
            return;
        }

        // $duration = Carbon::parse($this->check_out_time)->diffInMinutes(Carbon::parse($this->check_in_time));

        // dd($this->employee_id, $this->check_in_time, $this->check_out_time, $this->date, $this->status, $this->check_in_latitude, $this->check_in_longitude, $this->check_out_latitude, $this->check_out_longitude, $scheduleDetail, $duration);

        // Simpan absensi
        Attendance::create([
            'employee_id' => $this->employee_id,
            'check_in_time' => $this->check_in_time,
            'check_out_time' => $this->check_out_time,
            'date' => $this->date,
            'work_schedule_id' => $scheduleDetail,
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

        return redirect()->route('attendance.index')->with('success', 'Absensi berhasil disimpan!');
    }
}
