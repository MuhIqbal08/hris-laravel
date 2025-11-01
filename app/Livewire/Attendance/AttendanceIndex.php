<?php

namespace App\Livewire\Attendance;

use App\Http\Requests\Attendance\CheckInRequest;
use App\Models\Attendance;
use App\Models\OfficeLocation;
use Carbon\Carbon;
use Livewire\Component;
use LocationService;

class AttendanceIndex extends Component
{
    public $latitude;
    public $longitude;
    public $address;

    protected $rules = [
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'address' => 'required|string',
    ];

    protected $listeners = ['setLocation' => 'setUserLocation'];

    public function setUserLocation($data)
    {
        $this->latitude = $data['latitude'];
        $this->longitude = $data['longitude'];
        $this->address = 'Lokasi terdeteksi otomatis';
    }


    public function render()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $attendances = Attendance::with(['employee'])->paginate(15);    
        } else {
            $attendances = Attendance::where('employee_id', $user->employee->uuid)->with(['employee'])->paginate(15);
        }

        return view('livewire.attendance.attendance-index', ['attendances' => $attendances]);
    }

    public function checkIn()
    {
        // dd($this->latitude, $this->longitude);
        $this->validate(); // gunakan rules yang sudah kamu definisikan di atas

        $user = auth()->user();
        $today = Carbon::today();
        $employee = $user->employee;

        $todayAttendance = Attendance::where('employee_id', $employee->uuid)
            ->whereDate('date', $today)
            ->first();

        if ($todayAttendance) {
            session()->flash('error', 'Anda sudah melakukan absensi hari ini.');
            return;
        }

        $userSchedule = $employee->employeeSchedules()->latest()->first();
        if (!$userSchedule) {
            session()->flash('error', 'Anda belum memiliki jadwal kerja.');
            return;
        }

        $scheduleDetail = $userSchedule->workSchedule;
        $startTime = Carbon::parse($scheduleDetail->start_time)->format('H:i');

        $officeLocation = OfficeLocation::first();
        if (!$officeLocation) {
            session()->flash('error', 'Lokasi kantor belum diset.');
            return;
        }

        // Hitung jarak
        $distance = \App\Services\LocationService::calculateDistance(
            $officeLocation->latitude,
            $officeLocation->longitude,
            $this->latitude,
            $this->longitude
        );

        if ($distance > $officeLocation->radius_in_meters) {
            session()->flash('error', 'Anda berada di luar radius kantor.');
            return;
        }

        $isLate = Carbon::now()->format('H:i') > $startTime;

        Attendance::create([
            'employee_id' => $user->employee->uuid,
            'work_schedule_id' => $scheduleDetail->uuid,
            'date' => $today,
            'check_in_time' => now(),
            'status' => $isLate ? 'late' : 'present',
            'check_in_latitude' => $this->latitude,
            'check_in_longitude' => $this->longitude,
            'check_in_address' => $this->address,
        ]);

        session()->flash('success', 'Check-in berhasil.');
    }

    public function checkOut()
    {
        $user = auth()->user();
        $today = Carbon::today();
        $employee = $user->employee;

        $todayAttendance = Attendance::where('employee_id', $employee->uuid)
            ->whereDate('date', $today)
            ->first();

        if (!$todayAttendance) {
            session()->flash('error', 'Anda belum melakukan absensi hari ini.');
            return;
        }

        $officeLocation = OfficeLocation::first();
        if (!$officeLocation) {
            session()->flash('error', 'Lokasi kantor belum diset.');
            return;
        }

        // Hitung jarak
        $distance = \App\Services\LocationService::calculateDistance(
            $officeLocation->latitude,
            $officeLocation->longitude,
            $this->latitude,
            $this->longitude
        );

        if ($distance > $officeLocation->radius_in_meters) {
            session()->flash('error', 'Anda berada di luar radius kantor.');
            return;
        }

        $todayAttendance->update([
            'check_out_time' => now(),
            'status' => 'present',
            'duration' => Carbon::parse($todayAttendance->check_out_time)->diffInMinutes(Carbon::parse($todayAttendance->check_in_time)),
            'check_out_latitude' => $this->latitude,
            'check_out_longitude' => $this->longitude,
            'check_out_address' => $this->address,
        ]);

        session()->flash('success', 'Check-out berhasil.');
    }

    public function delete($uuid) {
        $attendance = Attendance::where('uuid', $uuid)->firstOrFail();
        $attendance->delete();

        return session()->flash('success', 'Attendance deleted successfully');
    }


    // Fungsi menghitung jarak (Haversine formula)
    // private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    // {
    //     $earthRadius = 6371000; // meter

    //     $dLat = deg2rad($lat2 - $lat1);
    //     $dLon = deg2rad($lon2 - $lon1);

    //     $a = sin($dLat / 2) * sin($dLat / 2) +
    //         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
    //         sin($dLon / 2) * sin($dLon / 2);
    //     $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    //     return $earthRadius * $c; // hasil meter
    // }
}
