<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Roles') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Create roles') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('role.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    <div class="">
        <form wire:submit="submit" class="mt-6 space-y-6">
            <flux:input wire:model="name" label="Name Role" placeholder="Name" />

            <div>
                <div class="flex flex-col lg:flex-row lg:items-center justify-normal lg:justify-between mb-3">
                    <label class="text-gray-700 font-semibold">Permissions</label>
                    <div class="space-x-2">
                        <flux:button type="button" wire:click="selectAll" size="sm">
                            Select All
                        </flux:button>
                        <flux:button type="button" wire:click="unselectAll" size="sm">
                            Unselect All
                        </flux:button>
                    </div>
                </div>

                {{-- Checkbox Group --}}
                <div
                    class="grid grid-rows-[100] lg:grid-rows-15 lg:grid-flow-col gap-2 p-3 border border-gray-100 rounded-lg bg-gray-50 max-h-[450px] overflow-y-auto">
                    @foreach ($allPermissions as $permission)
                        <flux:checkbox wire:model="permissions" value="{{ $permission->name }}"
                            label="{{ $permission->name }}" />
                    @endforeach
                </div>
            </div>
            <flux:button type="submit" variant="primary">
                Submit
            </flux:button>
        </form>
    </div>
</div>
