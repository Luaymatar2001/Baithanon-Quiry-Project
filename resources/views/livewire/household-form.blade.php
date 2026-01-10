<div class="container mx-auto p-6">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-bold mb-6">
            {{ $householdId ? 'Edit Household' : 'Create Household' }}
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
                    <input type="text" wire:model="FName" class="w-full border rounded px-3 py-2" required>
                    @error('FName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">إسم الأب</label>
                    <input type="text" wire:model="SName" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1"> إسم الجد</label>
                    <input type="text" wire:model="TName" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">الأسم الأخير *</label>
                    <input type="text" wire:model="LName" class="w-full border rounded px-3 py-2" required>
                    @error('LName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Contact & Personal Details -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">رقم الهوية*</label>
                    <input type="text" wire:model="PersonId" name="PersonId" class="w-full border rounded px-3 py-2"
                        required>
                    @error('PersonId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">رقم الجوال</label>
                    <input type="text" wire:model="Phone_Number" name="Phone_Number"
                        class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">تاريخ الميلاد</label>
                    <input type="date" wire:model="BirthDate" name="BirthDate" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">الجنس *</label>
                    <select wire:model="Gender" name="Gender" class="w-full border rounded px-3 py-2" required>
                        <option value="">أختر الجنس</option>
                        <option value="ذكر">ذكر</option>
                        <option value="أنثى">أنثى</option>
                    </select>
                </div>
            </div>

            <!-- Location -->
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">المحافظة</label>
                    <select wire:model.defer="governorate_id" name="governorate_id"
                        class="w-full border rounded px-3 py-2">
                        <option value="" selected>أختر المحافظة</option>
                        @foreach ($governorates as $gov)
                        <option value="{{ $gov->id }}">{{ $gov->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">المدينة</label>
                    <select wire:model="cityId" name="cityId" class="w-full border rounded px-3 py-2">
                        <option value="" selected>أختر المدينة</option>
                        @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">المنطقة</label>
                    <select wire:model.defer="location_id" name="location_id" class="w-full border rounded px-3 py-2">
                        <option value="" selected> أختر المنطقة</option>
                        @foreach ($locations as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">العنوان</label>
                <input type="text" wire:model="address" name="address" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Family & Health -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">عدد أعضاء الأسرة</label>
                    <input type="number" name="num_Family_Members" wire:model="num_Family_Members"
                        class="w-full border rounded px-3 py-2" min="1">
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
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">مصادر الدخل</label>
                    <select name="Sources_income" wire:model.defer="Sources_income"
                        class="w-full border rounded px-3 py-2" required>
                        <option value="" selected>أختر مصدر الدخل</option>
                        @foreach(['عاطل','موظف حكومي','موظف خاص','موظف عقود','موظف وكالة'] as $source)
                        <option value="{{ $source }}"
                            {{ old('Sources_income', $household->Sources_income ?? '') == $source ? 'selected' : '' }}>
                            {{ $source }}
                        </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <!-- Status & Confirmation -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">الحالة الإجتماعية</label>
                    <select name="status" wire:model="status" class="w-full border rounded px-3 py-2">
                        <option value="" selected> أختر الحالة الإجتماعية</option>
                        @foreach(['متزوج','مطلق','مطلقة','أرمل','أرملة','أرملة بعد حرب 2023','أعزب تعدى ال 40 عام']
                        as $status)

                        <option value="{{ $status }}"
                            {{ old('status', $household->status ?? '') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">تاريخ أستشهاد الزوج</label>
                    <input type="date" name="Date_partner_martyrdom" wire:model="Date_partner_martyrdom"
                        class="w-full border rounded px-3 py-2">
                </div>
                <div class="flex items-center mt-6">
                    <input type="checkbox" name="legal_confirmation" wire:model="legal_confirmation" class="rounded"
                        id="legal">
                    <label for="legal" class="ml-2 text-sm">Legal Confirmation</label>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium mb-1">Notes</label>
                <textarea wire:model="Notes" name="Notes" class="w-full border rounded px-3 py-2" rows="3"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 mt-8">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    {{ $householdId ? 'Update' : 'Create' }}
                </button>
                <a href="{{ route('headhousehold.index') }}"
                    class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>