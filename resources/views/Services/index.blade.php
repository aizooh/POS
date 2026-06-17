<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Services</h2>
                        <a href="{{ route('services.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded border border-blue-800 shadow-md">
                            + Add Service
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">Name</th>
                                <th class="border px-4 py-2 text-left">Price</th>
                                <th class="border px-4 py-2 text-left">Duration</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                            <tr>
                                <td class="border px-4 py-2">{{ $service->name }}</td>
                                <td class="border px-4 py-2">KSh {{ number_format($service->price, 2) }}</td>
                                <td class="border px-4 py-2">{{ $service->duration_minutes ? $service->duration_minutes.' min' : 'N/A' }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ route('services.show', $service) }}" class="text-blue-600 hover:underline">View</a>
                                    <a href="{{ route('services.edit', $service) }}" class="text-yellow-600 hover:underline ml-2">Edit</a>
                                    <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this service?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="border px-4 py-2 text-center">No services found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $services->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>