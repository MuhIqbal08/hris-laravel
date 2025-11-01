<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Payroll Slip</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td,
        .table th {
            padding: 6px;
            border: 1px solid #ddd;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Payroll Slip</h2>
        @php
            use Carbon\Carbon;
            Carbon::setLocale('id');
            $monthName = Carbon::createFromDate(null, $payroll->period_month, null)->translatedFormat('F');
        @endphp

        <p>Period: {{ ucfirst($monthName) }} {{ $payroll->period_year }}</p>
    </div>

    <div class="section">
        <table class="table">
            <tr>
                <td>Employee Name</td>
                <td>{{ $payroll->employee->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Employee ID</td>
                <td>{{ $payroll->employee->employee_id ?? '-' }}</td>
            </tr>
            <tr>
                <td>Working Days</td>
                <td>{{ $payroll->working_days ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h4>Salary Details</h4>
        <table class="table">
            <tr>
                <td>Basic Salary</td>
                <td class="text-right">Rp{{ number_format($details['basic_salary'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Earned Salary</td>
                <td class="text-right">Rp{{ number_format($details['earned_salary'] ?? 0, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h4>Allowances</h4>
        <table class="table">
            @foreach ($details['allowances'] ?? [] as $a)
                <tr>
                    <td>{{ $a['name'] }}</td>
                    <td class="text-right">Rp{{ number_format($a['amount'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="section">
        <h4>Deductions</h4>
        <table class="table">
            @foreach ($details['deductions'] ?? [] as $d)
                <tr>
                    <td>{{ $d['name'] }}</td>
                    <td class="text-right">Rp{{ number_format($d['amount'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <hr>

    <h3 class="text-right font-bold">
        Net Salary:
        Rp{{ number_format(
            ($details['earned_salary'] ?? 0) +
                collect($details['allowances'] ?? [])->sum(fn($a) => $a['amount']) -
                collect($details['deductions'] ?? [])->sum(fn($d) => $d['amount']),
            0,
            ',',
            '.',
        ) }}
    </h3>
</body>

</html>
