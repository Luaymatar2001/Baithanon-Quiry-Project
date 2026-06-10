<div class="container mx-auto p-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold mb-6">
            {{ $childrenId ? 'Edit Children' : 'Create Children' }}
        </h2>

        @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-4">
            <!-- Personal Information -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">الأسم الأول *</label>
                    <input type="text" wire:model.defer="FName" class="w-full border rounded px-3 py-2" required>
                    @error('FName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">إسم الأب</label>
                    <input type="text" wire:model.defer="SName" class="w-full border rounded px-3 py-2">
                    @error('SName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1"> إسم الجد</label>
                    <input type="text" wire:model.defer="TName" class="w-full border rounded px-3 py-2">
                    @error('TName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">الأسم الأخير *</label>
                    <input type="text" wire:model.defer="LName" class="w-full border rounded px-3 py-2" required>
                    @error('LName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Contact & Personal Details -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">رقم الهوية*</label>
                    <input type="text" wire:model.defer="PersonId" name="PersonId" class="w-full border rounded px-3 py-2"
                        required>
                    @error('PersonId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">تاريخ الميلاد</label>
                    <input type="date" wire:model.defer="BirthDate" name="BirthDate" class="w-full border rounded px-3 py-2">
                    @error('BirthDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium mb-1">رقم هوية رب الأسرة</label>
                    <input type="text" wire:model.defer="householdId" name="householdId"
                        class="w-full border rounded px-3 py-2">
                    @error('householdId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-1">الجنس *</label>
                    <select wire:model.defer="Gender" name="Gender" class="w-full border rounded px-3 py-2" required>
                        <option value="">أختر الجنس</option>
                        <option value="ذكر">ذكر</option>
                        <option value="أنثى">أنثى</option>
                    </select>
                    @error('Gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

            </div>
            <!-- Family & Health -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">العلاقة</label>
                    <select wire:model.defer="relationship" class="w-full border rounded px-3 py-2">
                        <option value="" selected>اختر العلاقة</option>
                        <option value="ابن">ابن</option>
                        <option value="ابنة">ابنة</option>
                    </select>
                    @error('relationship') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">الحالة الصحية</label>
                    <select wire:model.defer="health_Status" class="w-full border rounded px-3 py-2">
                        <option value="" selected>اختر الحالة الصحية</option>
                        <option value="سليم">سليم</option>
                        <option value="مريض">مريض</option>
                        <option value="مصاب">مصاب</option>
                        <option value="إعاقة سمعية">إعاقة سمعية</option>
                        <option value="إعاقة جسدية">إعاقة جسدية</option>
                        <option value="إعاقة عقلية">إعاقة عقلية</option>
                        <option value="إعاقة بصرية">إعاقة بصرية</option>
                        <option value="حالات حرجة">حالات حرجة</option>
                    </select>
                    @error('health_Status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    {{ $childrenId ? 'Update' : 'Create' }}
                </button>
                <a href="{{ route('children.index') }}"
                    class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>