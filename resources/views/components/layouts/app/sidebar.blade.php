<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                @can('employee.view')
                    <flux:navlist.item icon="users" :href="route('employee.index')"
                        :current="request()->routeIs('employee.index')" wire:navigate>{{ __('Employees') }}
                    </flux:navlist.item>
                @endcan
                @can('role.view')
                    <flux:navlist.item icon="link-slash" :href="route('role.index')"
                        :current="request()->routeIs('role.index')" wire:navigate>{{ __('Roles') }}</flux:navlist.item>
                @endcan
                @can('department.view')
                    <flux:navlist.item icon="boxes" :href="route('department.index')"
                        :current="request()->routeIs('department.index')" wire:navigate>{{ __('Departments') }}
                    </flux:navlist.item>
                @endcan
                @can('work-schedule.view')
                    <flux:navlist.item icon="clipboard-clock" :href="route('work.schedule.index')"
                        :current="request()->routeIs('work.schedule.index')" wire:navigate>{{ __('Work Schedules') }}
                    </flux:navlist.item>
                @endcan
                @can('employee-schedule.view')
                    <flux:navlist.item icon="clipboard-clock" :href="route('employee.schedules.index')"
                        :current="request()->routeIs('employee.schedules.index')" wire:navigate>
                        {{ __('Employee Schedules') }}</flux:navlist.item>
                @endcan
                @can('location.view')
                    <flux:navlist.item icon="map-pin" :href="route('location.index')"
                        :current="request()->routeIs('location.index')" wire:navigate>{{ __('Locations') }}
                    </flux:navlist.item>
                @endcan
                @can('attendance.view')
                    <flux:navlist.item icon="calendar-cog" :href="route('attendance.index')"
                        :current="request()->routeIs('attendance.index')" wire:navigate>{{ __('Attendances') }}
                    </flux:navlist.item>
                @endcan
                @can('permission.view')
                    <flux:navlist.item icon="shield-user" :href="route('permission.index')"
                        :current="request()->routeIs('permission.index')" wire:navigate>{{ __('Permissions') }}
                    </flux:navlist.item>
                @endcan
                @can('leave.view')
                    <flux:navlist.item icon="calendar" :href="route('leave.index')"
                        :current="request()->routeIs('leave.index')" wire:navigate>{{ __('Leaves') }}</flux:navlist.item>
                @endcan
                @can('salary.view')
                    <flux:navlist.item icon="hand-coins" :href="route('salary.index')"
                        :current="request()->routeIs('salary.index')" wire:navigate>{{ __('Salaries') }}
                    </flux:navlist.item>
                @endcan
                @can('payroll.view')
                    <flux:navlist.item icon="wallet" :href="route('payroll.index')"
                        :current="request()->routeIs('payroll.index')" wire:navigate>{{ __('Payrolls') }}
                    </flux:navlist.item>
                @endcan
            </flux:navlist.group>
        </flux:navlist>

        <flux:spacer />

        {{-- <flux:navlist variant="outline">
            <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit"
                target="_blank">
                {{ __('Repository') }}
            </flux:navlist.item>

            <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire"
                target="_blank">
                {{ __('Documentation') }}
            </flux:navlist.item>
        </flux:navlist> --}}

        <!-- Desktop User Menu -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" data-test="sidebar-menu-button" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full"
                        data-test="logout-button">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full"
                        data-test="logout-button">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>
