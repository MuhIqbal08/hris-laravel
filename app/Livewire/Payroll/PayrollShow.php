<?php

namespace App\Livewire\Payroll;

use App\Models\PayrollRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class PayrollShow extends Component
{
    public $payroll;

    public function mount($uuid) {
        $this->payroll = PayrollRecord::where('uuid', $uuid)->firstOrFail();
    }
    public function render()
    {
        return view('livewire.payroll.payroll-show');
    }

    public function download($uuid)
{
    $payroll = PayrollRecord::with('employee.user')->where('uuid', $uuid)->firstOrFail();

    // Decode details
    $details = is_string($payroll->details)
        ? json_decode($payroll->details, true)
        : $payroll->details;

    // Sanitasi semua string agar aman dari error encoding
    $sanitizeUtf8 = function (&$value) {
        if (is_string($value) && !mb_check_encoding($value, 'UTF-8')) {
            $value = utf8_encode($value);
        }
    };

    array_walk_recursive($details, $sanitizeUtf8);

    // Load PDF view dengan model asli (tidak diubah ke array)
    $pdf = Pdf::loadView('pdf.payroll-slip', [
        'payroll' => $payroll, // model asli, relasi tetap aktif
        'details' => $details,
    ])->setPaper('A4', 'portrait');

    $filename = 'Slip-Gaji-' . ($payroll->employee->user->name ?? 'Employee') . '-' .
        $payroll->period_month . '-' . $payroll->period_year . '.pdf';

    return response()->streamDownload(function () use ($pdf) {
        echo $pdf->output();
    }, $filename);
}


}
