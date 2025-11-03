<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        
        <!-- Header Section -->
        <div class="mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Dashboard</h1>
            <p class="text-gray-600">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>

        <!-- Profile Section -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 mb-6 border border-gray-100">
            <div class="flex flex-col sm:flex-row gap-6">
                <div class="flex-shrink-0 mx-auto sm:mx-0">
                    <div class="relative">
                        <img src="{{ $user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=000&color=fff' }}"
                            alt="Profile"
                            class="w-24 h-24 rounded-2xl object-cover ring-2 ring-gray-900">
                    </div>
                </div>

                <div class="flex-1 text-center sm:text-left space-y-4">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1">{{ $user->name }}</h2>
                        <p class="text-lg text-gray-600">{{ $employee->position ?? '—' }}</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-6 text-sm">
                        <div class="inline-flex items-center justify-center sm:justify-start gap-2">
                            <span class="px-3 py-1 bg-gray-100 rounded-lg font-medium text-gray-900">
                                {{ $employee->department->name ?? '—' }}
                            </span>
                        </div>
                        <div class="text-gray-600">
                            Bergabung sejak 
                            <span class="font-semibold text-gray-900">
                                {{ $employee->join_date ? \Carbon\Carbon::parse($employee->join_date)->translatedFormat('F Y') : '—' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Payroll Card -->
            <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Informasi Gaji</h3>
                    <p class="text-sm text-gray-500">Data gaji terakhir Anda</p>
                </div>

                @if($lastPayroll)
                    <div class="space-y-6">
                        <div class="flex items-end justify-between pb-6 border-b border-gray-100">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Periode</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::create()->month($lastPayroll->period_month)->translatedFormat('F Y') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Gaji Bersih</p>
                                <p class="text-2xl sm:text-3xl font-bold text-gray-900">
                                    {{ number_format($lastPayroll->net_salary, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">IDR</p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('payroll.download', $lastPayroll->uuid) }}"
                                class="flex-1 px-6 py-3 bg-gray-900 text-white text-center rounded-xl font-semibold hover:bg-gray-800 transition-all duration-200 hover:shadow-lg">
                                Download Slip Gaji
                            </a>
                            <a href="{{ route('payroll.index') }}"
                                class="flex-1 px-6 py-3 bg-gray-100 text-gray-900 text-center rounded-xl font-semibold hover:bg-gray-200 transition-all duration-200">
                                Lihat Riwayat
                            </a>
                        </div>
                    </div>
                @else
                    <div class="py-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                            <span class="text-2xl text-gray-400">—</span>
                        </div>
                        <p class="text-gray-500">Belum ada data gaji tersedia</p>
                    </div>
                @endif
            </div>

            <!-- Attendance Card -->
            <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100">
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">Kehadiran</h3>
                    <p class="text-sm text-gray-500">Status dan statistik mingguan</p>
                </div>

                <!-- Today Status -->
                <div class="mb-6 p-5 bg-gradient-to-br from-gray-50 to-white rounded-xl border border-gray-100">
                    @if($todayAttendance)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status Hari Ini</p>
                                <p class="text-sm text-gray-700">Check in</p>
                            </div>
                            <div class="text-right">
                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-lg border border-gray-200">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-xl font-bold text-gray-900">
                                        {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status Hari Ini</p>
                                <p class="text-sm text-gray-700">Belum check in</p>
                            </div>
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-50 rounded-lg border border-yellow-200">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                                <span class="text-sm font-semibold text-yellow-700">Pending</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Weekly Statistics -->
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Minggu Ini</p>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <span class="font-medium text-gray-700">Hadir</span>
                            <span class="text-2xl font-bold text-gray-900">{{ $weeklyStats['present'] }}</span>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <span class="font-medium text-gray-700">Terlambat</span>
                            <span class="text-2xl font-bold text-gray-900">{{ $weeklyStats['late'] }}</span>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                            <span class="font-medium text-gray-700">Izin / Cuti</span>
                            <span class="text-2xl font-bold text-gray-900">{{ $weeklyStats['on_leave'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>