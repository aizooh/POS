<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">{{ $service->name }}</h2>

                    <div class="space-y-3">
                        <p><strong>Price:</strong> ${{ number_format($service->price, 2) }}</p>
                        <p><strong>Duration:</strong> {{ $service->duration_minutes ? $service->duration_minutes.' minutes' : 'N/A' }}</p>
                        <p><strong>Description:</strong> {{ $service->description ?? 'No description' }}</p>
                        <p><strong>Created:</strong> {{ $service->created_at->format('Y-m-d H:i') }}</p>
                        <p><strong>Last Updated:</strong> {{ $service->updated_at->format('Y-m-d H:i') }}</p>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('services.edit', $service) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                        <a href="{{ route('services.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>