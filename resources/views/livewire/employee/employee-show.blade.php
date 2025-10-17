<div class="">
    <div class="">
        <!-- Header Section -->
        <div class="mb-8">
            <flux:heading size="xl" level="1" class="text-slate-900 dark:text-white">
                {{ __('Employees') }}
            </flux:heading>
            <flux:subheading size="lg" class="mt-2 text-slate-600 dark:text-slate-400">
                {{ __('Detail employees data') }}
            </flux:subheading>
            <flux:separator variant="subtle" class="mt-6" />
        </div>

        <!-- Back Button -->
        <div class="mb-6">
            <flux:button 
                wire:navigate 
                href="{{ route('employee.index') }}"
                variant="primary"
                icon="arrow-left"
                class="transition-all duration-200 hover:shadow-lg"
            >
                {{ __('Back to Employees') }}
            </flux:button>
        </div>

        <!-- Employee Details Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 px-6 py-5 sm:px-8 sm:py-6">
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                            <flux:icon.user class="w-8 h-8 text-white" />
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold text-white truncate">
                            {{ $employee->user->name }}
                        </h2>
                        <p class="text-blue-100 text-sm mt-1">
                            {{ $employee->position }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="px-6 py-6 sm:px-8 sm:py-8">
                <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Employee ID -->
                    <div class="group">
                        <dt class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 flex items-center">
                            <flux:icon.badge class="w-4 h-4 mr-2 text-slate-400" />
                            {{ __('Employee ID') }}
                        </dt>
                        <dd class="text-base font-medium text-slate-900 dark:text-slate-100 pl-6">
                            {{ $employee->employee_id }}
                        </dd>
                    </div>

                    <!-- Email -->
                    <div class="group">
                        <dt class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 flex items-center">
                            <flux:icon.envelope class="w-4 h-4 mr-2 text-slate-400" />
                            {{ __('Email Address') }}
                        </dt>
                        <dd class="text-base font-medium text-slate-900 dark:text-slate-100 pl-6 break-all">
                            <a href="mailto:{{ $employee->user->email }}" 
                               class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors duration-200">
                                {{ $employee->user->email }}
                            </a>
                        </dd>
                    </div>

                    <!-- Position -->
                    <div class="group">
                        <dt class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 flex items-center">
                            <flux:icon.briefcase class="w-4 h-4 mr-2 text-slate-400" />
                            {{ __('Position') }}
                        </dt>
                        <dd class="text-base font-medium text-slate-900 dark:text-slate-100 pl-6">
                            {{ $employee->position }}
                        </dd>
                    </div>

                    <!-- Department -->
                    <div class="group">
                        <dt class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 flex items-center">
                            <flux:icon.building-office class="w-4 h-4 mr-2 text-slate-400" />
                            {{ __('Department') }}
                        </dt>
                        <dd class="text-base font-medium text-slate-900 dark:text-slate-100 pl-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                {{ $employee->department->name }}
                            </span>
                        </dd>
                    </div>

                    <!-- Join Date -->
                    <div class="group sm:col-span-2">
                        <dt class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 flex items-center">
                            <flux:icon.calendar class="w-4 h-4 mr-2 text-slate-400" />
                            {{ __('Join Date') }}
                        </dt>
                        <dd class="text-base font-medium text-slate-900 dark:text-slate-100 pl-6">
                            {{ \Carbon\Carbon::parse($employee->join_date)->format('d F Y') }}
                            <span class="text-sm text-slate-500 dark:text-slate-400 ml-2">
                                ({{ \Carbon\Carbon::parse($employee->join_date)->diffForHumans() }})
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Card Footer (Optional Actions) -->
            <div class="bg-slate-50 dark:bg-slate-900/50 px-6 py-4 sm:px-8 border-t border-slate-200 dark:border-slate-700">
                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                    <flux:button 
                        variant="ghost"
                        icon="pencil"
                        href="{{ route('employee.edit', $employee->uuid) }}"
                        wire:navigate
                        class="w-full sm:w-auto"
                    >
                        {{ __('Edit Employee') }}
                    </flux:button>
                    <flux:button 
                        variant="danger"
                        icon="trash"
                        wire:click="$dispatch('confirmDelete', { id: {{ $employee->id }} })"
                        wire:confirm="Are you sure you want to delete this employee?"
                        class="w-full sm:w-auto"
                    >
                        {{ __('Delete') }}
                    </flux:button>
                </div>
            </div>
        </div>

        <!-- Additional Info Card (Optional) -->
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
            <div class="flex items-start">
                <flux:icon.information-circle class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0" />
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-1">
                        {{ __('Employee Information') }}
                    </h3>
                    <p class="text-sm text-blue-800 dark:text-blue-400">
                        {{ __('This page displays detailed information about the employee. You can edit or delete the employee record using the actions below.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>