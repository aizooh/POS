<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Add New User</h2>
                    <form action="{{ route('users.store') }}" method="POST" class="max-w-lg">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
                            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2" required>
                            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Password *</label>
                            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
                            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Role *</label>
                            <select name="role" class="w-full border rounded px-3 py-2" required>
                                <option value="attendant" {{ old('role') == 'attendant' ? 'selected' : '' }}>Attendant</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Create User</button>
                        <a href="{{ route('users.index') }}" class="ml-2 text-gray-600">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>