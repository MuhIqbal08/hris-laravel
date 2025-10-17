<div class="">
    {{-- Header --}}
    <div class="relative mb-6 w-full">
        <flux:heading size="2xl" level="1" class="mb-2">{{ __('Edit Employee') }}</flux:heading>
        <flux:subheading size="md" class="text-gray-600">
            {{ __('Edit a employee and assign their roles, department, and join date.') }}
        </flux:subheading>
        <flux:separator variant="subtle" class="mt-6" />
    </div>

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('employee.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 transition-colors duration-200">
            Back
        </a>
    </div>

    {{-- Form --}}
    <form wire:submit="submit" class="p-3 w-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Name --}}
            <flux:input wire:model.defer="name" label="Name" placeholder="Employee name" />

            {{-- Email --}}
            <flux:input wire:model.defer="email" label="Email" type="email" placeholder="example@email.com" />

            {{-- Password --}}
            <flux:input wire:model.defer="password" label="Password" type="password" placeholder="Enter password" />

            {{-- Confirm Password --}}
            <flux:input wire:model.defer="password_confirmation" label="Confirm Password" type="password"
                placeholder="Re-enter password" />

            {{-- Roles --}}
            <div class="col-span-full">
                <flux:checkbox.group wire:model="roles" label="Roles">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mt-2">
                        @foreach ($allRoles as $role)
                            <flux:checkbox label="{{ $role->name }}" value="{{ $role->name }}" />
                        @endforeach
                    </div>
                </flux:checkbox.group>
            </div>

            {{-- Position --}}
            <flux:input wire:model.defer="position" label="Position" placeholder="e.g. Staff, Manager, etc." />

            {{-- Department --}}
            <flux:select wire:key="department-select" wire:model="department_id" label="Department"
                placeholder="Choose department...">
                @foreach ($departments as $department)
                    <flux:select.option value="{{ $department->uuid }}">
                        {{ $department->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            {{-- Join Date --}}
            <div class="col-span-full">
                <flux:input wire:model="join_date" type="date" max="2999-12-31" label="Join Date" />
            </div>
        </div>

        {{-- Submit --}}
        <div class="mt-8 text-center">
            <flux:button type="submit" variant="primary" class="w-full px-8 py-2.5 text-base font-medium">
                Submit
            </flux:button>
        </div>
    </form>
</div>]
