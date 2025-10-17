<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Departments') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Create departments') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('department.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    <div class="w-150">
        <form action="" class="mt-6 space-y-6" wire:submit="submit">
                <flux:input wire:model="name" label="Name Department" placeholder="Name" />    
                <flux:button type="submit" variant="primary">Submit</flux:button>
        </form>
    </div>
</div>
