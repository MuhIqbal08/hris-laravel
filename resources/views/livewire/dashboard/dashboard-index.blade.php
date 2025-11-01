<div class="space-y-3 p-3">
    {{-- Header --}}
    <div class="pb-6">
        <flux:heading size="xl" level="1">{{ __('Dashboards') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Here your Dashboards!') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        {{-- Total Employees --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between text-right">
                <div class="flex-1">
                    <div class="bg-black rounded-full w-10 h-10 flex items-center justify-center">
                        <flux:icon.users color="white" />
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <p class="text-sm font-medium text-gray-600 mb-2">Total Employees</p>
                    <p class="text-xl font-bold text-gray-900">
                        {{ $users ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Today's Attendances --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between text-right">
                <div class="flex-1">
                    <div class="bg-black rounded-full w-10 h-10 flex items-center justify-center">
                        <flux:icon.calendar-cog color="white" />
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <p class="text-sm font-medium text-gray-600 mb-2">Attendances Today</p>
                    <p class="text-xl font-bold text-gray-900">
                        {{ $todayAttendances ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Leaves Today --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between text-right">
                <div class="flex-1">
                    <div class="bg-black rounded-full w-10 h-10 flex items-center justify-center">
                        <flux:icon.calendar color="white" />
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <p class="text-sm font-medium text-gray-600 mb-2">Leaves Today</p>
                    <p class="text-xl font-bold text-gray-900">
                        {{ $leavesToday ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Payroll This Month --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between text-right">
                <div class="flex-1">
                    <div class="bg-black rounded-full w-10 h-10 flex items-center justify-center">
                        <flux:icon.wallet color="white" />
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <p class="text-sm font-medium text-gray-600 mb-2">Payroll This Month</p>
                    <p class="text-xl font-bold text-gray-900">
                        Rp {{ number_format($payrollThisMonth ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Attendance by Month --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Attendance Trend {{ date('Y') }}</h3>
                <p class="mt-1 text-sm text-gray-600">Monthly attendance for current year</p>
            </div>
            <div class="p-6" wire:ignore>
                <canvas id="attendanceChart" class="w-full" style="height: 300px;" loading="lazy"></canvas>
            </div>
        </div>

        {{-- Attendance Pie Chart --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Attendance Summary</h3>
                <p class="mt-1 text-sm text-gray-600">Distribution of monthly attendance</p>
            </div>
            <div class="p-6" wire:ignore>
                <canvas id="attendancePieChart" class="w-full" style="height: 300px;" loading="lazy"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Destroy existing charts to prevent memory leaks
            const destroyChart = (id) => {
                const chartInstance = Chart.getChart(id);
                if (chartInstance) chartInstance.destroy();
            };

            // === Bar Chart (Monthly Attendance) ===
            const ctx = document.getElementById('attendanceChart');
            if (ctx) {
                destroyChart('attendanceChart');    

                // Filter data untuk tahun saat ini
                const currentYear = new Date().getFullYear();
                const allMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                    'Dec'
                ];

                // Data dari server
                const serverData = {!! json_encode(
                    $attendancesChart->map(function ($item) {
                        return [
                            'month' => $item->month,
                            'year' => $item->year,
                            'total' => $item->total,
                        ];
                    }),
                ) !!};

                // Filter hanya tahun saat ini dan buat mapping
                const dataMap = {};
                serverData.forEach(item => {
                    if (item.year === currentYear) {
                        dataMap[item.month] = item.total;
                    }
                });

                // Buat data untuk semua 12 bulan
                const chartData = allMonths.map((month, index) => {
                    return dataMap[index + 1] || 0;
                });

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: allMonths,
                        datasets: [{
                            label: 'Total Attendances',
                            data: chartData,
                            backgroundColor: '#1f2937',
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#1f2937',
                                padding: 12,
                                cornerRadius: 8,
                                titleFont: {
                                    size: 14,
                                    weight: '600'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f3f4f6',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#6b7280',
                                    font: {
                                        size: 12
                                    },
                                    precision: 0
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#6b7280',
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // === Pie Chart (Today's Attendance Summary) ===
            const pie = document.getElementById('attendancePieChart');
            if (pie) {
                destroyChart('attendancePieChart');
                new Chart(pie, {
                    type: 'doughnut',
                    data: {
                        labels: ['Present', 'Late', 'Absent', 'On Leave'],
                        datasets: [{
                            data: [
                                {{ $attendacesPie['present'] }},
                                {{ $attendacesPie['late'] }},
                                {{ $attendacesPie['absent'] }},
                                {{ $attendacesPie['on leave'] }}
                            ],
                            backgroundColor: ['#22c55e', '#3b82f6', '#ef4444', '#f59e0b'],
                            borderWidth: 3,
                            borderColor: '#ffffff',
                            hoverBorderColor: '#ffffff',
                            hoverBorderWidth: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 15,
                                    color: '#374151',
                                    font: {
                                        size: 13,
                                        weight: '500'
                                    },
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: '#1f2937',
                                padding: 12,
                                cornerRadius: 8,
                                titleFont: {
                                    size: 14,
                                    weight: '600'
                                },
                                bodyFont: {
                                    size: 13
                                },
                                callbacks: {
                                    label: (context) => {
                                        const total = context.chart._metasets[0].total;
                                        const val = context.raw;
                                        const percent = ((val / total) * 100).toFixed(1);
                                        return ` ${context.label}: ${val} (${percent}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
