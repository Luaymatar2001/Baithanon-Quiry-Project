<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/details.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" />

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    @livewireStyles

    <title>{{ env('APP_NAME') }} - Details</title>
    <style>
        * {
            font-family: 'Cairo', sans-serif;
            font-size: 14px;
        }

        body {
            background-color: #f4f4f4;
            direction: rtl;
            margin: 0;
            padding: 0;
        }
    </style>
</head>


<body>

    @livewire('Navbar' , ['FName' => session('household_name')])

    <div style="margin:80px 20px 0 ;">
        @livewire('household-details')
    </div>
    @if(session('message'))
    <script>
        Swal.fire({
        icon: 'success',
        title: 'تمت العملية بنجاح',
        text: "{{ session('message') }}",
        confirmButtonText: 'حسناً'
    });
    </script>
    @endif
    <!-- IdExistedMessage -->
     @if(session('IdExistedMessage'))
    <script>
        Swal.fire({
        icon: 'error',
        title: 'خطأ',
        text: "{{ session('IdExistedMessage') }}",
        confirmButtonText: 'حسناً'
        });
    </script>
    @endif


    <div id="popup-overlay" class="overlay1">
        <div class="popup1">
        <div class="close-btn"> <span><i class="fa-solid fa-x"></i> </div>

            <h2>أضف بياناتك <i class="fa-solid fa-feather-pointed"></i></h2>

            <form id="popup-form" action="{{ route('submit-details') }}" method="POST">
                @csrf
                @method('PATCH')

                {{-- الحالة الاجتماعية --}}
                <div class="field">
                    <label class="field-label">الحالة الإجتماعية </label>
                    <div class="custom-select">
                        <select name="status" required>
                            @foreach(['متزوج','مطلق','مطلقة','أرمل','أرملة','أرملة بعد حرب 2023','أعزب تعدى ال 40 عام']
                            as $status)
                            <option value="{{ $status }}" {{ old('status', $household->status ?? '') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                            @endforeach
                        </select>
                        <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>

                        @error('status', 'popup_update_houseHold')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- تاريخ الاستشهاد --}}
                <div class="field" id="martyr-date-field"
                    style="display:{{ old('status', $household->status ?? '') == 'أرملة بعد حرب 2023' ? 'block' : 'none' }};">
                    <label class="field-label">تاريخ الاستشهاد</label>
                    <div class="custom-input">
                        <input type="date"
                            value="{{ old('Date_partner_martyrdom', $household->Date_partner_martyrdom ?? '') }}"
                            name="Date_partner_martyrdom">
                        @error('Date_partner_martyrdom', 'popup_update_houseHold')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                    const statusSelect = document.querySelector('select[name="status"]');
                    const dateField = document.getElementById('martyr-date-field');

                    statusSelect.addEventListener('change', function() {
                        if (this.value === "أرملة بعد حرب 2023") {
                            dateField.style.display = 'block';
                        } else {
                            dateField.style.display = 'none';
                        }
                    });
                });
                </script>

                {{-- مصادر الدخل --}}
                <div class="field">
                    <label class="field-label">مصادر الدخل </label>
                    <div class="custom-select">
                        <select name="Sources_income" required>
                            @foreach(['عاطل','موظف حكومي','موظف خاص','موظف عقود','موظف وكالة'] as $source)
                            <option value="{{ $source }}"
                                {{ old('Sources_income', $household->Sources_income ?? '') == $source ? 'selected' : '' }}>
                                {{ $source }}
                            </option>
                            @endforeach
                        </select>
                        <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        @error('Sources_income', 'popup_update_houseHold')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- الحالة الصحية --}}
                <div class="field">
                    <label class="field-label">الحالة الصحية</label>
                    <div class="custom-select">
                        <select name="health_status">
                            @foreach(['سليم','مريض','مصاب','متوفي','إعاقة سمعية','إعاقة جسدية','إعاقة عقلية','إعاقة
                            بصرية','حالات حرجة'] as $health)
                            <option value="{{ $health }}"
                                {{ old('health_status', $household->health_status ?? '') == $health ? 'selected' : '' }}>
                                {{ $health }}
                            </option>
                            @endforeach
                        </select>
                        <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>

                        @error('health_status', 'popup_update_houseHold')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                

@livewire('location-selector', [
    'governorateMessage' => $errors->getBag('popup_update_houseHold')->first('governorate_id'),
    'citiesMessage' => $errors->getBag('popup_update_houseHold')->first('city'),
    'locationsMessage' => $errors->getBag('popup_update_houseHold')->first('locations'),
    'selectedGovernorate' => old('governorate_id', $household->governorate_id ?? null),
    'selectedCity' => old('city', $household->city ?? null),
    'selectedLocation' => old('locations', $household->locations ?? null)
])                {{-- العنوان --}}
                <div class="field">
                    <label class="field-label">العنوان بالكامل</label>
                    <div class="custom-input">
                        <input type="text" id="address" name="address" placeholder="العنوان"
                            value="{{ old('address', $household->address ?? '') }}">
                        <script>
                            const input = document.getElementById('address');
                        input.addEventListener('input', function() {
                            if(this.value.length > 50) {
                                this.value = this.value.slice(0, 50);
                            }
                        });
                        </script>

                        @error('address', 'popup_update_houseHold')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

            <button
                type="submit"
                class="submitBtn submit-btn {{ $household->legal_confirmation ? '' : 'btn-disabled' }}"
                {{ $household->legal_confirmation ? '' : 'disabled' }}>
                إرسال
            </button>

            @if (!$household->legal_confirmation)
            <p class="legalMessage" style="color:red; font-size:15px; margin-top:8px;">
                يرجى تأكيد المسؤولية القانونية أعلاه لتمكين زر الإرسال.
            </p>
            @endif
            </form>

        </div>
    </div> 
    @if ($errors->popup_update_houseHold->any())
    <script>
        document.getElementById('popup-overlay').style.display = 'flex';
    </script>
    @endif

    <div id="popup-overlay2" class="overlay2">
        <div class="popup2">
        <div class="close-btn"> <span><i class="fa-solid fa-x"></i> </div>
         <h2>أضف بياناتك<i class="fa-solid fa-feather-pointed"></i>
            </h2>
            {{-- update --}}
            <form id="popup-form2" action="{{ route('addRowMember') }}" method="POST">
                @csrf

                <input type="hidden" name="member_id" id="member_id">
                <input type="hidden" name="member_type" id="member_type" value="">
                {{-- العنوان كامل  --}}
                <div class="field">
                    <label class="field-label">الإسم بالكامل <span class="requiredStar">*</span></label>
                    <div class="custom-input">
                        <div style="display: flex;">
                            <input class="NameBox" type="text" name="FName"
                                value="{{ old('FName', $member->FName ?? '') }}">
                            <input class="NameBox" value="{{ old('SName', $member->SName ?? '') }}" type="text"
                                id="SName" name="SName" required>
                            <input class="NameBox" value="{{ old('TName', $member->TName ?? '') }}" type="text"
                                id="TName" name="TName" required>
                            <input class="NameBox" value="{{ old('LName', $member->LName ?? '') }}" type="text"
                                id="LName" name="LName" required>

                        </div>

                        <div style="display:flex;">
                            @error('FName', 'popup_add_member')
                            <small class="error-msg">{{ $message }}</small>
                            @enderror

                            @error('SName', 'popup_add_member')
                            <small class="error-msg">{{ $message }}</small>
                            @enderror

                            @error('TName', 'popup_add_member')
                            <small class="error-msg">{{ $message }}</small>
                            @enderror

                            @error('LName', 'popup_add_member')
                            <small class="error-msg">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                </div>


                <div class="field">
                    <label class="field-label">رقم الهوية <span class="requiredStar">*</span></label>
                    <div class="custom-input">
                        <input type="number" name="PersonId" value="{{ old('PersonId', $member->PersonId ?? '') }}"
                            maxlength="9" required>
                        @error('PersonId', 'popup_add_member')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                        <script>
                            const form = document.getElementById('main-form');
                        const input = document.getElementById('Id');
                        
                        // منع إدخال أكثر من 9 أرقام
                        input.addEventListener('input', function () {
                        this.value = this.value.replace(/\D/g, ''); // أرقام فقط
                        if (this.value.length > 9) {
                        this.value = this.value.slice(0, 9);
                        }
                        });
                        </script>

                    </div>
                </div>

                <div class="field">
                    <label class="field-label">
                        العلاقة <span class="requiredStar">*</span>
                    </label>

                    <div class="custom-select">
                        <select name="relation" required>
                       @php
                            $allowedStatuses = ['أرملة', 'أرملة بعد حرب 2023', 'مطلقة'];
                        @endphp

                        @if($household && !in_array($household->status, $allowedStatuses))
                            <option value="زوجة">زوجة</option>
                        @endif


                            <option value="ابن">ابن</option>
                            <option value="ابنة">ابنة</option>
                        </select>


                        @error('relation', 'popup_add_member')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror

                        
                        <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>

                <div class="field">
                    <label class="field-label">
                        الحالة الصحية <span class="requiredStar">*

                    </label>

                    <div class="custom-select">


                        <select name="health_status" required>
                            <option value="سليم" selected>سليم</option>
                            <option value="مريض">مريض</option>
                            <option value="مصاب">مصاب</option>
                            <option value="إعاقة سمعية">إعاقة سمعية
                            </option>
                            <option value="إعاقة جسدية">إعاقة جسدية
                            </option>
                            <option value="إعاقة عقلية">إعاقة عقلية
                            </option>
                            <option value="إعاقة بصرية">إعاقة بصرية
                            </option>
                            <option value="حالات حرجة">حالات حرجة
                            </option>
                        </select>
                        @error('health_status', 'popup_add_member')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror

                        <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none">
                            <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <div class="field">
                    <label class="field-label">الإسم بالكامل <span class="requiredStar">*</span></label>
                    <div class="custom-input">
                        <input type="date" name="BirthDate" value="{{ old('BirthDate', $member->BirthDate ?? '') }}"
                            required>
                        @error('BirthDate', 'popup_add_member')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

            <button
                type="submit"
                class="submitBtn submit-btn {{ $household->legal_confirmation ? '' : 'btn-disabled' }}"
                {{ $household->legal_confirmation ? '' : 'disabled' }}>
                إرسال
            </button>

            @if (!$household->legal_confirmation)
            <p class="legalMessage" style="color:red; font-size:15px; margin-top:8px;">
                يرجى تأكيد المسؤولية القانونية أعلاه لتمكين زر الإرسال.
            </p>
            @endif





            </form>

        </div>
    </div>



</body>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const checkbox = document.getElementById('legalConfirm');
    const buttons  = document.querySelectorAll('.submitBtn');
    const editButtons  = document.querySelectorAll('.open-btn-edit');
    const deleteButtons  = document.querySelectorAll('.delete-member');
    const saveEditBtn  = document.getElementById('.SaveEditBtn');
    const messages = document.querySelectorAll('.legalMessage');

    checkbox.addEventListener('change', function () {

        if (this.checked) {
            buttons.forEach(btn => {
                btn.disabled = false;
                btn.classList.remove('btn-disabled');
            });

            messages.forEach(msg => msg.style.display = 'none');
            // .hidden-smooth
            editButtons.forEach(btn => btn.classList.remove('hidden-smooth'));
            deleteButtons.forEach(btn => btn.classList.remove('hidden-smooth'));
            saveEditBtn.classList.remove('hidden-smooth');
        } else {
            buttons.forEach(btn => {
                btn.disabled = true;
                btn.classList.add('btn-disabled');
            });

            messages.forEach(msg => msg.style.display = 'block');
            editButtons.forEach(btn => btn.classList.add('hidden-smooth'));
            deleteButtons.forEach(btn => btn.classList.add('hidden-smooth'));
            saveEditBtn.classList.add('hidden-smooth');
        }
    });

});
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
    const openBtn = document.querySelector('.open-btn');
    const overlay = document.getElementById('popup-overlay');
    const closeBtn = overlay.querySelector('.close-btn');

if(openBtn) {
    openBtn.addEventListener('click', () => {
    overlay.style.display = 'flex';
    });
}
if(closeBtn) {
    closeBtn.addEventListener('click', () => {
    overlay.style.display = 'none';
    });
}

const overlay2 = document.getElementById('popup-overlay2');
const closeBtn2 = overlay2.querySelector('.close-btn');
const openBtnAdd = document.querySelector('.open-btn-add');

// إغلاق popup
if (closeBtn2) {
    closeBtn2.addEventListener('click', function() {
    overlay2.style.display = 'none';
    });
}

// فتح popup إضافة
if (openBtnAdd) {
openBtnAdd.addEventListener('click', function(e) {
    e.preventDefault();
    overlay2.style.display = 'flex';

    const form = document.getElementById('popup-form2');
    form.action = "{{ route('addRowMember') }}";
    document.getElementById('member_id').value = '';

    // لا تمسح CSRF
    form.querySelectorAll('input, select').forEach(input => {
        if (input.name !== '_token') {
            input.value = '';
        }
    });

    const methodInput = form.querySelector('[name="_method"]');
    if (methodInput) methodInput.remove(); // ✅ مسح PUT إذا موجود
});

}

// فتح popup تعديل
function bindEditButtons() {
  document.querySelectorAll('.open-btn-edit').forEach(btn => {
  btn.addEventListener('click', function (e) {
    e.preventDefault();

    const form = document.getElementById('popup-form2'); // ✅ أول شيء
    const member = JSON.parse(btn.dataset.member);

    document.getElementById('member_id').value = member.id;

    document.querySelector('[name="FName"]').value = member.FName || '';
    document.querySelector('[name="SName"]').value = member.SName || '';
    document.querySelector('[name="TName"]').value = member.TName || '';
    document.querySelector('[name="LName"]').value = member.LName || '';
    document.querySelector('[name="PersonId"]').value = member.PersonId || '';


    const relationSelect = document.querySelector('[name="relation"]');

    // تعيين العلاقة بناءً على member object
    const relationType = member.relationship|| '';
    relationSelect.value = relationType;
    const memberTypeInput = document.getElementById('member_type');
  if (relationType === 'زوج' || relationType === 'زوجة') {
    
       memberTypeInput.value = 'partner';
  } else {
        console.log(relationType);
        memberTypeInput.value = 'child';
  }

const healthSelect = document.querySelector('[name="health_status"]');
healthSelect.value = member.health_Status || '';

document.querySelector('[name="BirthDate"]').value = member.BirthDate || '';

// action + method
form.action = "{{ route('updateRowMember') }}";

let methodInput = form.querySelector('[name="_method"]');
if (!methodInput) {
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
        }

         overlay2.style.display = 'flex';
        });
    });
}
// ربط الأزرار لأول مرة
bindEditButtons();

// دعم Livewire لإعادة ربط الأزرار بعد أي تحديث
if (window.Livewire) {
    Livewire.hook('message.processed', () => {
     bindEditButtons();
    });
}


@if ($errors->popup_add_member->any())
    overlay2.style.display = 'flex';
@endif
});

</script>
<script>
    function toggleDropdown() {
                document.getElementById('dropdownMenu').classList.toggle('show');
            }
</script>





@livewireScripts

</html>