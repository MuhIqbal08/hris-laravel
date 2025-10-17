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

    <div class="w-150">
        <form wire:submit="submit" class="mt-6 space-y-6">
            <flux:input wire:model="name" label="Name Role" placeholder="Name" />

            <flux:checkbox.group wire:model="permissions" label="Permissions">
                @foreach ($allPermissions as $permissions)
                <flux:checkbox label="{{ $permissions->name }}" value="{{ $permissions->name }}"  />
                @endforeach
</flux:checkbox.group>

            <flux:button type="submit" variant="primary">
                Submit
            </flux:button>
        </form>
    </div>
</div>
