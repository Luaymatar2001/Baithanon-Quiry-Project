<div class="container mx-auto p-6">
    @php
    $healthStatusArr = [
    '0' => 'سليم',
    '1' => 'مريض',
    '2' => 'مصاب',
    '3' => 'أمراض مزمنة',
    '4' => 'حالات حرجة',
    '5' => 'إعاقة جسدية',
    '6' => 'إعاقة سمعية',
    '7' => 'إعاقة عقلية',
    '8' => 'إعاقة بصرية',
    '9' => 'أخرى',
    ];
    @endphp
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
                    <input type="text" wire:model.defer="FName" class="w-full border rounded px-3 py-2" required>
                    @error('FName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">إسم الأب</label>
                    <input type="text" wire:model.defer="SName" class="w-full border rounded px-3 py-2" required>
                    @error('SName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1"> إسم الجد</label>
                    <input type="text" wire:model.defer="TName" class="w-full border rounded px-3 py-2" required>
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
                    <input type="text" wire:model.defer="PersonId" name="PersonId"
                        class="w-full border rounded px-3 py-2" required>
                    @error('PersonId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">رقم الجوال *</label>
                    <input type="text" wire:model.defer="Phone_Number" name="Phone_Number"
                        class="w-full border rounded px-3 py-2">
                    @error('Phone_Number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">تاريخ الميلاد</label>
                    <input type="date" wire:model.defer="BirthDate" name="BirthDate"
                        class="w-full border rounded px-3 py-2required="">
                           @error('BirthDate') <span class=" text-red-500 text-sm">{{ $message }}</span> @enderror
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

                <div>
                    <label class="block text-sm font-medium mb-1">عدد أعضاء الأسرة <label
                            style="color: red;">*</label></label>
                    <input type="number" name="num_Family_Members" wire:model.defer="num_Family_Members"
                        class="w-full border rounded px-3 py-2" min="1" required>
                    @error('num_Family_Members') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">
                        الحالة الإجتماعية <span class="text-red-500">*</span>
                    </label>

                    <select wire:model.defer="status" class="w-full border rounded px-3 py-2" required>

                        <option value="">اختر الحالة الإجتماعية </option>

                        @foreach([
                        '0' => 'متزوج',
                        '1' => 'متزوج متعدد',
                        '2' => 'مطلق / مطلقة',
                        '3' => 'أرمل / أرملة قبل حرب 2023',
                        '4' => 'أرمل / أرملة بعد حرب 2023',
                        '5' => 'أعزب/عزباء تعدى ال 45 عاماً'
                        ] as $key => $value)

                        <option value="{{ $key }}">
                            {{ $value }}
                        </option>

                        @endforeach
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

            </div>

            <!-- Location -->
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <p class="block text-sm font-medium mb-1">المحافظة </p>
                    <select wire:model.defer="governorate_id" name="governorate_id"
                        class="w-full border rounded px-3 py-2">
                        <option value="" selected>أختر المحافظة</option>
                        @foreach ($governorates as $gov)
                        <option value="{{ $gov->id }}">{{ $gov->name }}</option>
                        @endforeach
                    </select>
                    @error('governorate_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">المدينة </label>
                    <select wire:model.lazy="cityId" name="cityId" class="w-full border rounded px-3 py-2">
                        <option value="" selected>أختر المدينة</option>
                        @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @error('governorate_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">المنطقة </label>
                    <select wire:model.lazy="location_id" name="location_id" class="w-full border rounded px-3 py-2">
                        <option value="" selected> أختر المنطقة</option>
                        @foreach ($locations as $loc)
                        <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                        @endforeach
                    </select>
                    @error('location_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">العنوان </label>
                <input type="text" wire:model.defer="address" name="address" class="w-full border rounded px-3 py-2">
                @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            </div>

            <!-- Family & Health -->
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium mb-1">
                        الحالة الصحية
                    </label>

                    <select wire:model.defer="health_Status" class="w-full border rounded px-3 py-2">

                        <option value="">اختر الحالة الصحية</option>

                        @foreach($healthStatusArr as $key => $value)
                        <option value="{{ $key }}">
                            {{ $value }}
                        </option>
                        @endforeach
                    </select>
                    @error('health_Status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">مصادر الدخل</label>
                    <select name="Sources_income" wire:model.defer="Sources_income"
                        class="w-full border rounded px-3 py-2">
                        <option value="" selected>أختر مصدر الدخل</option>
                        @foreach(['بلا عمل',
                        'عامل يومي',
                        'موظف حكومي',
                        'موظف خاص',
                        'موظف عقود',
                        'موظف وكالة',
                        'مساعدات مؤسسات',
                        'مؤسسات شؤون إجتماعية',
                        'مساعدات من الأهل',
                        'أخرى'] as $source)
                        <option value="{{ $source }}"
                            {{ old('Sources_income', $household->Sources_income ?? '') == $source ? 'selected' : '' }}>
                            {{ $source }}
                        </option>
                        @endforeach
                    </select>
                    @error('Sources_income') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                </div>




                <div>
                    <label class="block text-sm font-medium mb-1">تاريخ أستشهاد الزوج</label>
                    <input type="date" name="Date_partner_martyrdom" wire:model.defer="Date_partner_martyrdom"
                        class="w-full border rounded px-3 py-2">
                    @error('Date_partner_martyrdom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                </div>
                <div class="flex items-center mt-6">
                    <input type="checkbox" name="legal_confirmation" wire:model.defer="legal_confirmation"
                        class="rounded" id="legal">
                    <label for="legal" class="ml-2 text-sm">Legal Confirmation</label>
                    @error('legal_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                </div>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium mb-1">Notes</label>
                <textarea wire:model.defer="Notes" name="Notes" class="w-full border rounded px-3 py-2"
                    rows="3"></textarea>
                @error('Notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

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