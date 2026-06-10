<div class="container mx-auto p-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold mb-6">
            {{ $locationId ? 'Edit City' : 'Create City' }}
        </h2>

        @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-4">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1"> إسم المعلم أو المنطقة</label>
                    <input type="text" wire:model="name" class="w-full border rounded px-3 py-2">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">المدينة</label>
                    <select wire:model="city_id" class="w-full border rounded px-3 py-2">
                        <option value="">
                            اختر المدينة
                        </option>
                        @foreach ($AllCity as $id=>$name )
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                        @error('city_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                    </select>
                </div>
            </div>


            <!-- Buttons -->
            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    {{ $locationId ? 'Update' : 'Create' }}
                </button>
                <a href="{{ route('location.index') }}"
                    class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>