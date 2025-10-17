<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Roles') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Detail roles') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('role.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    <div class="w-150">
        <p class="mt-6"><strong>Name: </strong>{{ $role->name }}</p>
        <p class="mt-6"><strong>Permissions: </strong>
            @if ($role->permissions)
                @foreach ($role->permissions as $permissions )
                                    <flux:badge class="mt-1">{{ $permissions->name }}</flux:badge>
                                @endforeach
            @endif
        </p>
    </div>
</div>
