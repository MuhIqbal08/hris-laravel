<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Location') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Edit location') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <a href="{{ route('location.index') }}"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Back
    </a>

    <div class="w-150">
        <p class="mt-6"><strong>Name: </strong>{{ $location->name }}</p>
        <p class="mt-6"><strong>Latitude: </strong>{{ $location->latiude }}</p>
        <p class="mt-6"><strong>Longitude: </strong>{{ $location->longitude }}</p>
        <p class="mt-6"><strong>Radius In Meter: </strong>{{ $location->radius_in_metes }} Meter</p>
    </div>
</div>
