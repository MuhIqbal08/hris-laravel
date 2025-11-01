<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Salaries') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Create your salaries') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('salary.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    <div class="w-full">
        <form wire:submit.prevent="submit" class="mt-6 space-y-6">
            <div class="grid grid-cols-2 gap-2 mb-2">
                {{-- Pilih Karyawan --}}
                <flux:select wire:key="employee-select" wire:model="employee_id" label="Pilih Karyawan"
                    placeholder="Pilih karyawan...">
                    @foreach ($employees as $emp)
                        <flux:select.option value="{{ $emp->uuid }}">
                            {{ $emp->user->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
    
                {{-- Gaji Pokok --}}
                <flux:input wire:model="basic_salary" type="number" label="Gaji Pokok" placeholder="Masukkan gaji pokok" />
            </div>

            {{-- Tunjangan --}}
            <div>
                <flux:heading class="text-base mb-2">Tunjangan</flux:heading>

                @foreach ($allowances as $index => $allowance)
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <flux:input wire:model="allowances.{{ $index }}.name" placeholder="Nama Tunjangan" />
                        <flux:input wire:model="allowances.{{ $index }}.amount" type="number" placeholder="Jumlah" />
                    </div>
                @endforeach

                <flux:button variant="primary" type="button" wire:click="addAllowance">
                    + Tambah Tunjangan
                </flux:button>
            </div>

            {{-- Potongan --}}
            <div>
                <flux:heading class="text-base mb-2">Potongan</flux:heading>

                @foreach ($deductions as $index => $deduction)
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <flux:input wire:model="deductions.{{ $index }}.name" placeholder="Nama Potongan" />
                        <flux:input wire:model="deductions.{{ $index }}.amount" type="number" placeholder="Jumlah" />
                    </div>
                @endforeach

                <flux:button variant="primary" type="button" wire:click="addDeduction">
                    + Tambah Potongan
                </flux:button>
            </div>

            {{-- Tombol Submit --}}
            <flux:button class="w-full" type="submit" variant="primary">Simpan</flux:button>
        </form>
    </div>
</div>
