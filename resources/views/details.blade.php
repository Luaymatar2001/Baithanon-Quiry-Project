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
    <script src="{{ asset('js/image-compress.js') }}"></script>

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

        .open-btn-app,
        .open-reg_married {
            background-color: #258efd;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<script>
    document.addEventListener("DOMContentLoaded", () => {

    if (typeof Swal === 'undefined') return;

    const key = 'family_update_alert_shown';

    // إذا تم عرضه سابقًا → لا تعرضه
    if (localStorage.getItem(key) === '1') {
        return;
    }

    Swal.fire({
        html: `<br><br>
        <div
            style=" background:#FFF8E1; border-right:4px solid #FFC107; padding:10px 12px; border-radius:8px; font-size:16px; line-height:1.9; color:#6c4f00; ">
            <strong style="font-size:18px; color:red;">📢 تنبيه مهم:</strong><br> يرجى تحديث بيانات الأسرة بشكل دوري عند حدوث أي
            تغيير، مثل تغيير مكان النزوح، أو إضافة فرد جديد، أو تسجيل حالة زواج، أو تغيير الحالة الاجتماعية (أرمل/أرملة أو
            مطلق/مطلقة)، وذلك لضمان دقة البيانات وتمكين الجهات الشريكة من تقديم الخدمات والمساعدات وفق أحدث المعلومات المتوفرة.
        </div>`,
        confirmButtonText: 'متابعة عملية التحديث',
        confirmButtonColor: '#1BC5BD',
        width: 500
    }).then(() => {
        // 🔥 أهم سطر: تسجيل أنه تم العرض
        localStorage.setItem(key, '1');
    });

});
</script>

<body>
    <div id="popup-overlay-update-member" class="overlay-update-member">
        <div class="popup-update-member">
            <button type="button" class="close-btn">
                <i class="fa-solid fa-x"></i>
            </button>
            <form id="popup-form-update-member" action="{{ route('updateRowMember') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')


                <input type="hidden" name="member_id" id="member_id">
                <input type="hidden" name="member_type" id="member_type">

                {{-- العلاقة --}}
                <div class="field">
                    <label class="field-label">
                        العلاقة <span class="requiredStar">*</span>
                    </label>

                    <div class="custom-select">
                        {{-- <input type="text" name="relation" id="relation" value="{{ old('relation', $member->relationship ?? '') }}"
                        required> --}}
                        {{--زوجة ابن ابنه--}}
                        <select name="relation" id="relationship" class="notallowCurser" disabled>
                            <option value="">اختر العلاقة </option>
                            @foreach (['زوجة','ابن','ابنه'] as $relation)
                            <option value="{{ $relation }}"
                                {{ old('relation', $member->relation?? '') == $relation ? 'selected' : '' }}>
                                {{ $relation }}
                            </option>
                            @endforeach
                        </select>
                        @error('relation')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                {{-- العنوان كامل  --}}
                <div class="field">

                    <label class="field-label">الإسم بالكامل <span class="requiredStar">*</span></label>
                    <div class="custom-input">
                        <div style="display: flex;">
                            <input class="NameBox notallowCurser" type="text" name="FName" id="FName"
                                value="{{ old('FName', $household->FName ?? '') }}" disabled>
                            <input class="NameBox notallowCurser" value="{{ old('SName', $household->SName ?? '') }}"
                                type="text" id="SName" name="SName" disabled>
                            {{-- <input type="hidden" name="SName_hid" value="{{ $household->SName??'' }}"> --}}

                            <input class="NameBox notallowCurser" value="{{ old('TName', $household->TName ?? '') }}"
                                type="text" id="TName" name="TName" disabled>
                            {{-- <input type="hidden" name="TName_hid" value="{{ $household->TName }}"> --}}
                            <input class="NameBox notallowCurser" value="{{ old('LName', $household->LName ?? '') }}"
                                type="text" id="LName" name="LName" disabled>
                            {{-- <input type="hidden" name="LName_hid" value="{{ $household->LName }}"> --}}

                        </div>


                        <div style="display:flex;">
                            @error('FName')
                            <small class="error-msg">{{ $message }}</small>
                            @enderror

                            @error('SName')
                            <small class="error-msg">{{ $message }}</small>
                            @enderror

                            @error('TName')
                            <small class="error-msg">{{ $message }}</small>
                            @enderror

                            @error('LName')
                            <small class="error-msg">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                </div>




                <div class="field">
                    <label class="field-label">رقم الهوية <span class="requiredStar">*</span></label>
                    <div class="custom-input">
                        <input type="text" class="notallowCurser" name="PersonId"
                            value="{{ old('PersonId', $member->PersonId ?? '') }}" maxlength="9" required id="Id"
                            disabled placeholder="000000000">
                        @error('PersonId')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                        <script>
                            // منع إدخال أكثر من 9 أرقام (لا تكرر متغيرات عامة مثل input)
                                    const idInputUM = document.getElementById('Id');
                                    if (idInputUM) {
                                        idInputUM.addEventListener('input', function () {
                                            this.value = this.value.replace(/\D/g, ''); // أرقام فقط
                                            if (this.value.length > 9) {
                                                this.value = this.value.slice(0, 9);
                                            }
                                        });
                                    }
                        </script>

                    </div>
                </div>




                <div class="field">
                    <label class="field-label">تاريخ الميلاد <span class="requiredStar">*</span></label>
                    <div class="custom-input ">
                        <input type="date" class="notallowCurser" name="BirthDate"
                            value="{{ old('BirthDate', $member->BirthDate ?? '') }}" disabled>
                        @error('BirthDate')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label class="field-label">
                        الحالة الصحية
                    </label>


                    <div class="custom-select">
                        <select name="health_status" id="health_status2">
                            <option value="">اختر الحالة الصحية</option>

                            <option value="0" {{ old('health_status') == '0' ? 'selected' : '' }}>سليم</option>
                            <option value="1" {{ old('health_status') == '1' ? 'selected' : '' }}>مريض</option>
                            <option value="2" {{ old('health_status') == '2' ? 'selected' : '' }}>مصاب</option>
                            <option value="3" {{ old('health_status') == '3' ? 'selected' : '' }}>أمراض مزمنة</option>
                            <option value="4" {{ old('health_status') == '4' ? 'selected' : '' }}>حالات حرجة</option>
                            <option value="5" {{ old('health_status') == '5' ? 'selected' : '' }}>إعاقة جسدية</option>
                            <option value="6" {{ old('health_status') == '6' ? 'selected' : '' }}>إعاقة سمعية</option>
                            <option value="7" {{ old('health_status') == '7' ? 'selected' : '' }}>إعاقة عقلية</option>
                            <option value="8" {{ old('health_status') == '8' ? 'selected' : '' }}>إعاقة بصرية</option>
                            <option value="9" {{ old('health_status') == '9' ? 'selected' : '' }}>أخرى</option>
                        </select>

                        @error('health_status')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror

                        <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none">
                            <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>

                {{-- وصف الحالة الصحية --}}
                <div class="field">
                    <div class="custom-input">
                        <p class="field-label">وصف الحالة الصحية :</p>
                        <input type="text" name="desc_health_status_member" class="desc_health_status_member"
                            id="desc_health_status_member"
                            value="{{ old('desc_health_status_member', $household->child ?? '') }}">
                        @error('desc_health_status_member', 'popup_member')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <button type="submit"
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
    @livewire('Navbar' , ['FName' => session('household_name')])

    <div style="margin:80px 20px 0;">
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

    <div id="popup-overlay-reg_married" class="overlay-reg_married">

        <div class="popup-reg_married">
            <h2>أضف بيانات تسجيل طلب زواج جديد</h2>
            <button type="button" class="close-btn">
                <i class="fa-solid fa-x"></i>
            </button>


            {{-- action="{{ route('submit-details') }}" --}}
            <form id="popup-form" method="POST" action="{{ route('marriage-requests.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="husband-data-box">

                    <h3 class="section-title">
                        بيانات الزوج <i class="fa-solid fa-mars"></i>
                    </h3>

                    {{-- الاسم الكامل --}}
                    <div class="field">
                        <div class="custom-input">
                            <label class="field-label">
                                الإسم بالكامل <span class="requiredStar">*</span>
                            </label>

                            <div>
                                <div style="display: flex;">
                                    <input class="NameBox" type="text" name="FName_h" id="FName"
                                        value="{{ old('FName_h') }}" required>

                                    <input class="NameBox" type="text" name="SName_h" id="SName"
                                        value="{{ old('SName_h') }}" required>

                                    <input class="NameBox" type="text" name="TName_h" id="TName"
                                        value="{{ old('TName_h') }}" required>

                                    <input class="NameBox" type="text" name="LName_h" id="LName"
                                        value="{{ old('LName_h') }}" required>
                                </div>

                                <div style="display:flex;">
                                    @error('FName_h')
                                    <small class="error-msg">{{ $message }}</small>
                                    @enderror

                                    @error('SName_h')
                                    <small class="error-msg">{{ $message }}</small>
                                    @enderror

                                    @error('TName_h')
                                    <small class="error-msg">{{ $message }}</small>
                                    @enderror

                                    @error('LName_h')
                                    <small class="error-msg">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- رقم الهوية --}}
                    <div class="field">
                        <p class="field-label">
                            رقم هوية الزوج
                            <label style="color: red;">*</label>
                        </p>

                        <div class="custom-input">
                            <input type="text" name="IdNumHouseHold_h" class="IdNumHouseHold" maxlength="9"
                                inputmode="numeric" pattern="[0-9]{9}" required>
                        </div>
                    </div>

                    {{-- تاريخ الميلاد --}}
                    <div class="field">
                        <p class="field-label">
                            تاريخ الميلاد
                            <label style="color: red;">*</label>
                        </p>

                        <div class="custom-input">
                            <input type="date" name="BirthDate_h" class="BirthDate" required>
                        </div>
                    </div>

                    {{-- تاريخ الميلاد --}}
                    <div class="field">
                        <p class="field-label">
                            رقم هاتف معتمد للتواصل
                            <label style="color: red;">*</label>
                        </p>
                        <div class="custom-input">
                            <input type="text" name="MobailNumber_h" class="MobailNumber" placeholder="0500000000"
                                required maxlength="10" inputmode="numeric">
                        </div>
                    </div>

                    <div class="field">
                        <p class="field-label">
                            أدخل صورة هوية الزوج مع السليب
                            <label style="color: red;">*</label>
                        </p>
                        <div class="custom-input">
                            <input type="file" name="husband_national_id" id="husband_national_id" accept="image/*"
                                required>
                        </div>
                    </div>


                </div>

                <div class="wife-data-box">
                    <h3 class="section-title">
                        بيانات الزوجة <i class="fa-solid fa-venus"></i>
                    </h3>

                    {{-- الاسم الكامل --}}
                    <div class="field">
                        <div class="custom-input">
                            <label class="field-label">
                                الإسم بالكامل <span class="requiredStar">*</span>
                            </label>

                            <div>
                                <div style="display: flex;">
                                    <input class="NameBox" type="text" name="FName_w" id="FName"
                                        value="{{ old('FName_w') }}" required>

                                    <input class="NameBox" type="text" name="SName_w" id="SName"
                                        value="{{ old('SName_w') }}" required>

                                    <input class="NameBox" type="text" name="TName_w" id="TName"
                                        value="{{ old('TName_w') }}" required>

                                    <input class="NameBox" type="text" name="LName_w" id="LName"
                                        value="{{ old('LName_w') }}" required>
                                </div>

                                <div style="display:flex;">
                                    @error('FName_w')
                                    <small class="error-msg">{{ $message }}</small>
                                    @enderror

                                    @error('SName_w')
                                    <small class="error-msg">{{ $message }}</small>
                                    @enderror

                                    @error('TName_w')
                                    <small class="error-msg">{{ $message }}</small>
                                    @enderror

                                    @error('LName_w')
                                    <small class="error-msg">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- رقم الهوية --}}
                    <div class="field">
                        <p class="field-label">
                            رقم هوية الزوجة
                            <label style="color: red;">*</label>
                        </p>

                        <div class="custom-input">
                            <input type="text" name="IdNumWifeId" class="IdNumWifeId" maxlength="9" inputmode="numeric"
                                pattern="[0-9]{9}" required>
                        </div>
                    </div>

                    {{-- تاريخ الميلاد --}}
                    <div class="field">
                        <p class="field-label">
                            تاريخ الميلاد
                            <label style="color: red;">*</label>
                        </p>

                        <div class="custom-input">
                            <input type="date" name="BirthDate_w" class="BirthDate" required>
                        </div>
                    </div>

                    <div class="field">
                        <p class="field-label">
                            أدخل صورة هوية الزوجة مع السليب أو عقد الزواج <label style="color: red;">*</label>
                        </p>
                        <div class="custom-input">
                            <input type="file" name="wife_national_id" id="wife_national_id" accept="image/*">
                        </div>
                    </div>
                </div>

                <button type="submit"
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
          const open_reg_married = document.querySelector('.open-reg_married');
          const overlay_reg_married = document.querySelector(".overlay-reg_married");
          const overlay_application = document.querySelector('.overlay-application');
          const close_married_btn = overlay_reg_married.querySelector('.close-btn');
          open_reg_married.addEventListener('click', () => {
            overlay_reg_married.style.display = 'flex';
            overlay_application.style.display = 'none';
            });
          close_married_btn.addEventListener('click' , ()=>{
            overlay_reg_married.style.display = 'none';
            overlay_application.style.display = 'flex';
          })
            
   });
    </script>

    <div id="popup-overlay" class="overlay1">
        <div class="popup1">
            <div class="close-btn"> <span><i class="fa-solid fa-x"></i> </div>

            <h2>أضف بياناتك <i class="fa-solid fa-feather-pointed"></i></h2>

            <form id="popup-form" action="{{ route('submit-details') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- الحالة الاجتماعية --}}
                <div class="field">
                    <p class="field-label">الحالة الإجتماعية
                        <label style="color: red;">*</label>
                    </p>
                    <div class="custom-select">
                        <select name="status" id="status">
                            @foreach(['0'=>'متزوج','1'=>'متزوج متعدد','2'=>'مطلق / مطلقة','3'=>'أرمل / أرملة قبل حرب
                            2023','4'=>'أرمل / أرملة بعد حرب 2023', '5'=>'أعزب/عزباء تعدى ال 45 عاما ']
                            as $key => $value)
                            <option value="{{ $key }}"
                                {{ old('status', $household->status ?? '') == $key ? 'selected' : '' }}>
                                {{ $value }}
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


                {{--إرفاق الصور المطلوبة لقبول الطلب--}}
                <div id="status-documents-wrapper"
                    style="display:none; background-color: hsl(0, 0%, 93%); padding: 15px; border-radius: 10px; margin-top: 15px;">
                    {{-- هوية الأرملة --}}
                    <div class="field" id="widow-id-field" style="display:none;">
                        <p class="field-label">
                            شهادة الوفاة<span style="color:red;">*</span>
                        </p>

                        <div class="custom-input">
                            <input type="file" name="widow_identity" id="widow_identity" accept=".jpg,.jpeg,.png">
                        </div>
                    </div>


                    <script>
                        console.log('{{$household->widow_identity}}');
                        
                    </script>
                    {{-- شهادة الطلاق / الوفاة / الاستشهاد --}}

                    <div class="field" id="main-document-field">
                        <p class="field-label">
                            صورة الهوية والسليب <span style="color:red;">*</span>
                        </p>

                        <div class="custom-input">
                            <input type="file" name="status_document" id="status_document" accept=".jpg,.jpeg,.png">
                        </div>

                        <div style="display:flex; gap:15px; flex-wrap:wrap; margin-top:10px;">

                            {{-- أرملة قبل أو بعد الحرب أو مطلقة (حسب الحاجة) --}}
                            @if(in_array($household->status, ['4']))
                            @if($household->widow_identity)

                            <div style="text-align:center;">
                                <p>شهادة الوفاة</p>

                                <a href="{{ asset('uploads/'.$household->widow_identity) }}" target="_blank">
                                    <img id="preview_widow_identity"
                                        src="{{ asset('uploads/'.$household->widow_identity) }}"
                                        style="width:80px;object-fit:cover;border-radius:10px;border:1px solid #ccc;">
                                </a>
                            </div>
                            @endif
                            @endif
                            {{-- دائمًا: الهوية --}}
                            @if($household->status_document)
                            <div style="text-align:center;">
                                <p>صورة الهوية</p>

                                <a href="{{ asset('uploads/'.$household->status_document) }}" target="_blank">
                                    <img id="preview_status_document"
                                        src="{{ asset('uploads/'.$household->status_document) }}"
                                        style="width:80px;object-fit:cover;border-radius:10px;border:1px solid #ccc;">
                                </a>
                            </div>
                            @endif




                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {

    const status = document.getElementById('status');
    const popup_overlay = document.querySelector("#popup-overlay");
    const fileInput = document.getElementById('status_document');
    const preview = document.getElementById('preview_status_document');
    const widowField = document.getElementById('widow-id-field');
    const widowIdentity = document.getElementById('widow_identity');
    const preview_widow =document.getElementById('preview_widow_identity');

       fileInput.addEventListener('change' , function(){
        const file = e.target.files[0];
            if (!file) return;

        // 🔥 SweetAlert
                Swal.fire({
                title: 'تم إرفاق الصورة بنجاح',
                text: 'سيتم مراجعة طلب تغيير الحالة الإجتماعية لديكم بعد إكمال عملية التسجيل بشكل كامل !',
                icon: 'success',
                confirmButtonText: 'حسناً',
                zIndex: 999999
                });
       });
    //     function toggleWidow() {
    //     if (status.value === '3' || status.value === '4') {
    //         widowField.style.display = 'block';
    //         if (preview_widow) {
    //           widowIdentity.required = false;
    //         } else {
    //           widowIdentity.required = true;
    //         }

    //          widowIdentity.disabled = false;
            
    //     } else {
    //         widowField.style.display = 'none';
    //         widowIdentity.required = false;
    //         widowIdentity.disabled = true;
            
    //     }
    //     }

    // status.addEventListener('change', toggleWidow);
    // toggleWidow();


    // 🔥 Preview للصورة قبل الرفع
    if (fileInput && preview) {
        fileInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    preview.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
                        
   if (widowField && preview_widow) {
    widowIdentity.addEventListener('change', function (e) {
    const file = e.target.files[0];
        if (!file) return;

    
    if (file) {
    const reader = new FileReader();
    
    reader.onload = function (event) {
    preview_widow.src = event.target.result;
    };
    

    reader.readAsDataURL(file);
    }
   });

  }

});
                    </script>
                </div>

                {{-- <input type="hidden" name="status" value="{{ $household->status }}" required> --}}

                {{-- تاريخ الاستشهاد --}}
                <div class="field" id="martyr-date-field"
                    style="display:{{ old('status', $household->status ?? '') == 'أرملة بعد حرب 2023' ? 'block' : 'none' }};">
                    <p class="field-label">تاريخ الاستشهاد <label style="color: red;">*</label></p>
                    <div class="custom-input">
                        <input type="date"
                            value="{{ old('Date_partner_martyrdom', $household->Date_partner_martyrdom ?? '') }}"
                            name="Date_partner_martyrdom"
                            {{ old('status', $household->status ?? '') == 'أرملة بعد حرب 2023' ? 'required' : '' }}>
                        @error('Date_partner_martyrdom', 'popup_update_houseHold')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                {{-- تحديث رقم الهاتف --}}
                <div class="field">
                    <p class="field-label">رقم الهاتف الأساسي<label style="color: red;">*</label></p>
                    <div class="custom-input">
                        <input type="tel" id="Phone_Number" name="Phone_Number" placeholder="رقم الهاتف" maxlength="10"
                            pattern="[0-9]{10}" value="{{ old('Phone_Number', $household->Phone_Number ?? '') }}"
                            required>
                        <script>
                            const input = document.getElementById('Phone_Number');
                                        input.addEventListener('input', function() {
                                            if(this.value.length > 10) {
                                                this.value = this.value.slice(0, 10);
                                            }
                                        });
                        </script>

                        @error('Phone_Number', 'popup_update_houseHold')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- رقم جوال بديل --}}
                <div class="field">
                    <label class="field-label">رقم الهاتف بديل</label>
                    <div class="custom-input">
                        <input type="text" name="alternative_mobile_number" id="alternative_mobile_number"
                            maxlength="10"
                            value="{{$household->alternative_mobile_number ?? old('alternative_mobile_number')}}"
                            placeholder="رقم الجوال البديل">
                        @error('alternative_mobile_number', 'popup_update_houseHold')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                
                    const phone = document.getElementById('Phone_Number');
                    const altPhone = document.getElementById('alternative_mobile_number');
                
                    function validatePhones() {
                        if (
                            phone.value &&
                            altPhone.value &&
                            phone.value === altPhone.value
                        ) {
                            altPhone.setCustomValidity(
                                'رقم الجوال البديل يجب أن يكون مختلفاً عن رقم الهاتف الأساسي'
                            );
                        } else {
                            altPhone.setCustomValidity('');
                        }
                    }
                
                    phone.addEventListener('input', validatePhones);
                    altPhone.addEventListener('input', validatePhones);
                });
                </script>

                {{-- مكان الإقامة --}}
                <div class="field">
                    <label class="field-label">
                        مكان الإقامة<span class="requiredStar" style="color:red;">*</span>
                    </label>

                    <div class="custom-select">
                        <select name="residence_location" id="residence_location" required>
                            <option value="" selected disabled>اختر</option>
                            <option value="0"
                                {{old('residence_location' , $household->residence_location ) == '0' ? 'selected' : ''}}>
                                داخل قطاع غزة</option>
                            <option value="1"
                                {{old('residence_location' , $household->residence_location) == '1' ? 'selected' : ''}}>
                                خارج قطاع غزة</option>
                        </select>

                        <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none">
                            <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    @error('residence_location', 'popup_update_houseHold')
                    <small class="error-msg">{{ $message }}</small>
                    @enderror
                </div>


                <div id="outside_gaza_fields"
                    style="display:none; background-color: hsl(0, 0%, 95%); padding: 15px; border-radius: 10px; margin-top: 15px; ">
                    <div class="field">
                        <label class="field-label">
                            {{-- <span class="requiredStar">*</span> --}}
                        </label>

                        <div class="custom-select">
                            <select name="residence_status" id="residence_status">

                                <option value="" selected disabled>اختر</option>
                                <option value="0"
                                    {{old('residence_status' , $household->residence_status ) == '0' ? 'selected' : ''}}>
                                    العائلة بأكملها خارج قطاع غزة</option>
                                <option value="1"
                                    {{old('residence_status' , $household->residence_status) == '1' ? 'selected' : ''}}>
                                    رب الأسرة فقط
                                    خارج قطاع غزة </option>
                            </select>

                            <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none">
                                <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        @error('residence_status', 'popup_update_houseHold')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- العنوان الحالي  --}}
                    <div class="field">
                        <div class="custom-input">
                            <p class="field-label">الدولة المستضيفة / المدينة المستضيفة / العنوان :<label
                                    style="color: red;">*</label></p>
                            <input type="text" name="current_location" id="current_location"
                                value="{{ old('current_location', $household->current_location ?? '') }}">
                        </div>

                        @error('current_location', 'popup_update_houseHold')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>

                    {{--سبب الخروج--}}
                    <div class="field">
                        <label class="field-label">
                            سبب الخروج
                            <span class="requiredStar">*</span>
                        </label>

                        <div class="custom-select">
                            <select name="reason_leaving" id="reason_leaving">
                                <option value="" selected disabled>اختر</option>
                                <option value="1"
                                    {{old('reason_leaving' , $household->reason_leaving ) == '1' ? 'selected' : ''}}>
                                    سياحة</option>
                                <option value="2"
                                    {{old('reason_leaving' , $household->reason_leaving) == '2' ? 'selected' : ''}}>
                                    تعليم </option>
                                <option value="3"
                                    {{old('reason_leaving' , $household->reason_leaving) == '3' ? 'selected' : ''}}>
                                    علاج </option>
                                <option value="4"
                                    {{old('reason_leaving' , $household->reason_leaving) == '4' ? 'selected' : ''}}>
                                    أخرى </option>
                            </select>

                            <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none">
                                <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        @error('reason_leaving', 'popup_update_houseHold')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- رقم التواصل الدولي --}}
                    <div class="field">
                        <label class="field-label">
                            رقم التواصل الدولي <span class="requiredStar">*</span>
                        </label>

                        <div class="custom-input">
                            <input type="tel" name="international_number_mobile"
                                value="{{old('international_number_mobile' , $household->international_number_mobile)}}"
                                id="international_number_mobile" placeholder="رقم التواصل الدولي" maxlength="15"
                                pattern="[0-9]{10,15}" inputmode="numeric">
                            @error('international_number_mobile', 'popup_update_houseHold')
                            <small class="error-msg">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                    
                        const residenceLocation = document.getElementById('residence_location');
                        const residenceStatus = document.getElementById('residence_status');
                        const outsideFields = document.getElementById('outside_gaza_fields');
                        const reason_leaving = document.getElementById('reason_leaving');
                        const current_location = document.getElementById('current_location');
                        const international_number_mobile = document.getElementById('international_number_mobile');
                        if (!residenceLocation || !outsideFields) return;
                    
                        function toggleResidenceFields() {
                            if (residenceLocation.value === '1') {
                                outsideFields.style.display = 'block';
                              residenceStatus.required = true;
                                reason_leaving.required = true;
                                current_location.required = true;
                                international_number_mobile.required = true;
                            } else {
                                outsideFields.style.display = 'none';
                                residenceStatus.required = false;
                                reason_leaving.required = false;
                                current_location.required = false;
                                international_number_mobile.required = false;

                            }
                        }
                    
                        residenceLocation.addEventListener('change', toggleResidenceFields);
                    
                        toggleResidenceFields();
                    });
                    
                </script>


                <script>
                    document.addEventListener('DOMContentLoaded', function () {

    const status = document.getElementById('status');

    const wrapper = document.getElementById('status-documents-wrapper');
    const mainField = document.getElementById('main-document-field');
    const widowField = document.getElementById('widow-id-field');

    const statusDocument = document.getElementById('status_document');
    const widowIdentity = document.getElementById('widow_identity');

       function toggleDocuments() {

        wrapper.style.display = 'none';
        widowField.style.display = 'none';

        statusDocument.required = false;
        widowIdentity.required = false;

        if (status.value === '2') {
        wrapper.style.display = 'block';
        statusDocument.required = true;
        }

        if (status.value === '3') {
        wrapper.style.display = 'block';
        statusDocument.required = true;
        }

        if (status.value === '4') {
        wrapper.style.display = 'block';
        widowField.style.display = 'block';

        statusDocument.required = true;
        widowIdentity.required = true;
        }
        }
            // toggleDocuments();
            status.addEventListener('change', toggleDocuments);
        });
                </script>

                {{-- مصادر الدخل تعديل  --}}
                <div class="field">
                    <p class="field-label">مصادر الدخل <label style="color: red;">*</label></p>
                    <div class="custom-select">
                        <select name="Sources_income" required>
                            <option value="" selected disabled>اختر</option>
                            @php
                            $sources = [
                            'بلا عمل',
                            'عامل يومي',
                            'موظف حكومي',
                            'موظف خاص',
                            'موظف عقود',
                            'موظف وكالة',
                            'مساعدات مؤسسات',
                            'مؤسسات شؤون إجتماعية',
                            'مساعدات من الأهل',
                            'أخرى'
                            ];
                            @endphp
                            @foreach ($sources as $source)
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
                {{-- وصف حالة الدخل  --}}

                {{--الراتب المتوقع --}}
                <div class="field">
                    <p class="field-label">الراتب المتوقع يتراوح بين<label style="color: red;">*</label></p>
                    <div class="custom-select">
                        <select name="expected_salary" required>
                            <option value="" selected disabled>اختر</option>
                            <option value="0"> لا يوجد دخل
                            </option>
                            <option value="200"
                                {{ old('expected_salary', $household->expected_salary ?? '') == "200" ? 'selected' : '' }}>
                                100$ - 300$
                            </option>

                            <option value="500"
                                {{ old('expected_salary', $household->expected_salary ?? '') == "500" ? 'selected' : '' }}>
                                400$ - 600$
                            </option>

                            <option value="700"
                                {{ old('expected_salary', $household->expected_salary ?? '') == "700" ? 'selected' : '' }}>
                                600$ - 800$
                            </option>

                            <option value="900"
                                {{ old('expected_salary', $household->expected_salary ?? '') == "900" ? 'selected' : '' }}>
                                900$ فأكثر < .... </option>
                        </select>
                        <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        @error('expected_salary', 'popup_update_houseHold')
                        <small class="error-msg">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- مستوى التعليم--}}
                {{-- <div class="field">
                    <label class="field-label">
                        مستوى التعليم
                    </label>
                    <div class="custom-select">
                        <select name="level_of_education" id="level_of_education">
                            <option value="" selected disabled>اختر</option>
                            <option value="1"
                                {{ old('level_of_education', $household->level_of_education ?? '') == 'ابتدائي' ? 'selected' : '' }}>
                المرحلة الأساسية
                </option>
                <option value="2"
                    {{ old('level_of_education', $household->level_of_education ?? '') == 'متوسط' ? 'selected' : '' }}>
                    المرحلة الإعدادية
                </option>
                <option value="3"
                    {{ old('level_of_education', $household->level_of_education ?? '') == 'ثانوي' ? 'selected' : '' }}>
                    المرحلة الثانوية
                </option>
                <option value="4"
                    {{ old('level_of_education', $household->level_of_education ?? '') == 'جامعي' ? 'selected' : '' }}>
                    طالب جامعي
                </option>
                <option value="5"
                    {{ old('level_of_education', $household->level_of_education ?? '') == 'خريج' ? 'selected' : '' }}>
                    خريج
                </option>
                <option value="6"
                    {{ old('level_of_education', $household->level_of_education ?? '') == 'أمي' ? 'selected' : '' }}>
                    أمي (غير متعلم)
                </option>

                </select>

                <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none">
                    <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
        </div>
        @error('level_of_education', 'popup_update_houseHold')
        <small class="error-msg">{{ $message }}</small>
        @enderror
        <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none">
            <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </div> --}}

    <div style="background-color: hsl(0, 100%, 98%); padding: 15px; border-radius: 10px; margin-top: 15px;">
        {{-- الحالة الصحية تعديل  --}}
        {{-- إذا سليم يرفع قصة الحالة الصحية  --}}
        <div class="field">
            <p class="field-label">الحالة الصحية <label style="color: red;">*</label></p>
            <div class="custom-select">

                <select name="health_status" id="health_status">
                    <option value="" disabled
                        {{ (string) old('health_status', $household->health_Status ?? '') === '' ? 'selected' : '' }}>
                        اختر
                    </option>

                    @foreach([
                    '0' => 'سليم',
                    '1' => 'مريض',
                    '2' => 'مصاب',
                    '3' => 'إعاقة سمعية',
                    '4' => 'إعاقة جسدية',
                    '5' => 'إعاقة عقلية',
                    '6' => 'إعاقة بصرية',
                    '7' => 'حالات حرجة',
                    '8' => 'أمراض مزمنة',
                    '9' => 'أخرى'
                    ] as $key => $health)
                    <option value="{{ $key }}"
                        {{ (string) old('health_status', $household->health_Status ?? '') === (string) $key ? 'selected' : '' }}>
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

        {{-- وصف الحالة الصحية --}}
        <div class="field" id="health-desc-wrapper" style="display: none;">
            <div class="custom-input">
                <p class="field-label">وصف الحالة الصحية :<label style="color: red;">*</label></p>
                <input type="text" name="desc_health_status" id="desc_health_status"
                    value="{{ old('desc_health_status', $household->desc_health_status ?? '') }}">
            </div>

            @error('desc_health_status', 'popup_update_houseHold')
            <small class="error-msg">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
                
                    const healthStatus = document.getElementById('health_status');
                    const healthDescWrapper = document.getElementById('health-desc-wrapper');
                    const healthDescInput = document.getElementById('desc_health_status');
                
                    function toggleHealthDescription() {
                        if (healthStatus.value === "0"|| healthStatus.value === '') {
                            healthDescWrapper.style.display = 'none';
                            healthDescInput.value = '';
                            
                        } else {
                            healthDescWrapper.style.display = 'block';
                        }
                    }
                
                    toggleHealthDescription(); // عند تحميل الصفحة
                    healthStatus.addEventListener('change', toggleHealthDescription);
                
                });
    </script>

    {{--أسير أو مفقود --}}
    <div style="background-color: hsl(122, 75%, 92%); padding: 15px; border-radius: 10px; margin-top: 15px;">
        {{-- إذا أختار شئ يظهر مربع الوصف --}}
        <div class="field">
            <p class="field-label"> أسير / مفقود </p>
            <div class="custom-select">
                <select name="missing_persons" id="missing_persons">
                   @foreach(['0'=>'لا يوجد','1' => 'أسير', '2'=>'مفقود'] as $key => $value)
                    
                    <option value="{{ $key }}"
                        {{ old('missing_persons', $household->missing_persons ?? '') == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                    @endforeach
                </select>
                <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>

                @error('missing_persons', 'popup_update_houseHold')
                <small class="error-msg">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- وصف الحالة الصحية --}}
        <div class="field" id="missing-wrapper">
            <div class="custom-input">
                <p class="field-label">تفاصيل / تاريخ / مكان(الفقد/الأسر): <span style="color:red;">*</span>
                </p>
                <input type="text" name="missing_info" id="missing_info"
                    value="{{ old('missing_info', $household->missing_info ?? '') }}" required>
            </div>

            @error('missing_info', 'popup_update_houseHold')
            <small class="error-msg">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
                                                
                                                    const missing_persons = document.getElementById('missing_persons');
                                                    const missingWrapper = document.getElementById('missing-wrapper');
                                                    const missing_info = document.getElementById('missing_info');
                                                
                                                    function toggleMissingInfo() {
                                                        if (missing_persons.value ==='0') {
                                                            missingWrapper.style.display = 'none';
                                                            missing_info.value = '';
                                                            missing_info.required = false;
                                                        } else {
                                                            missingWrapper.style.display = 'block';
                                                            missing_info.required = true;
                                                        }
                                                    }
                                                
                                                    toggleMissingInfo(); // عند تحميل الصفحة
                                                    missing_persons.addEventListener('change', toggleMissingInfo);
                                                
                                                });
    </script>


    @livewire('location-selector', [
    'governorateMessage' => $errors->getBag('popup_update_houseHold')->first('governorate_id'),
    'citiesMessage' => $errors->getBag('popup_update_houseHold')->first('city'),
    'locationsMessage' => $errors->getBag('popup_update_houseHold')->first('locations'),

    // قيم الاختيار الحالية
    'selectedGovernorate' => $household->governorate_id ?? null,
    'selectedCity' => $household->city?->id ?? null,
    'selectedLocation' => $household->location?->id ?? null
    ])



    {{--نوع السكن الحالي--}}
    <div class="field">
        <label class="field-label">
            نوع السكن الحالي
            <span class="requiredStar">*</span>
        </label>
        <div class="custom-select">
            <select name="Type_of_housing" id="Type_of_housing" required>
                <option value="" selected disabled>اختر</option>

                <option value="1"
                    {{ old('Type_of_housing', $household->Type_of_housing ?? '') == 1 ? 'selected' : '' }}>
                    مدارس الأونروا
                </option>
                <option value="2"
                    {{ old('Type_of_housing', $household->Type_of_housing ?? '') == 2 ? 'selected' : '' }}>
                    مدارس الحكومة
                </option>
                <option value="3"
                    {{ old('Type_of_housing', $household->Type_of_housing ?? '') == 3 ? 'selected' : '' }}>
                    خيمة داخل مخيم
                </option>
                <option value="4"
                    {{ old('Type_of_housing', $household->Type_of_housing ?? '') == 4 ? 'selected' : '' }}>
                    خيمة عشوائية
                </option>
                <option value="5"
                    {{ old('Type_of_housing', $household->Type_of_housing ?? '') == 5 ? 'selected' : '' }}>
                    منزل مستضيف
                </option>
                <option value="6"
                    {{ old('Type_of_housing', $household->Type_of_housing ?? '') == 6 ? 'selected' : '' }}>
                    إيجار
                </option>

            </select>

            <svg class="select-arrow" width="14" height="9" viewBox="0 0 14 9" fill="none">
                <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>
        @error('Type_of_housing', 'popup_update_houseHold')
        <small class="error-msg">{{ $message }}</small>
        @enderror

    </div>

    {{--العنوان بالكامل --}}
    <div class="field">
        <p class="field-label">العنوان بالكامل <label style="color: red;">*</label></p>
        <div class="custom-input">
            <input type="text" id="address" name="address" placeholder="العنوان"
                value="{{ old('address', $household->address ?? '') }}" required>
            <script>
                const addressInput = document.getElementById('address');
                    
                    addressInput.addEventListener('input', function() {
                        if (this.value.length > 50) {
                            this.value = this.value.slice(0, 50);
                        }
                    });
            </script>

            @error('address', 'popup_update_houseHold')
            <small class="error-msg">{{ $message }}</small>
            @enderror
        </div>
    </div>




    <button type="submit" class="submitBtn submit-btn {{ $household->legal_confirmation ? '' : 'btn-disabled' }}"
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

</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {

    const checkbox = document.getElementById('legalConfirm');
    const buttons  = document.querySelectorAll('.submitBtn');
    const editButtons  = document.querySelectorAll('.open-btn-edit');

    const deleteButtons  = document.querySelectorAll('.delete-member');
    const saveEditBtn  = document.getElementById('SaveEditBtn');
    const messages = document.querySelectorAll('.legalMessage');

    checkbox.addEventListener('change', function () {
       
        if (this.checked) {
            buttons.forEach(btn => {
                btn.disabled = false;
                btn.classList.remove('btn-disabled');
            });

            messages.forEach(msg => msg.style.display = 'none');
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
    //popup edit 
 document.addEventListener('DOMContentLoaded', function () {
    
    // استماع لحدث Livewire
 window.addEventListener('openEditPopup', function (e) {
    const member = e.detail.member;
    const overlayUpdateMember = document.querySelector('.overlay-update-member');
    // تعبئة الحقول
    document.getElementById('member_id').value = member.id || '';
    document.querySelector('[name="FName"]').value = member.FName || '';
    document.querySelector('[name="SName"]').value = member.SName || '';
    document.querySelector('[name="TName"]').value = member.TName || '';
    document.querySelector('[name="LName"]').value = member.LName || '';
    document.querySelector('[name="PersonId"]').value = member.PersonId || '';
    document.querySelector('[name="BirthDate"]').value = member.BirthDate || member.birthdate || '';
    document.querySelector('[name="desc_health_status_member"]').value = member.desc_health_status || '';
    
    // العلاقة
    const relationType = (member.relationship || member.relation_title || '').trim();
    const relationSelect = document.getElementById('relationship');
    if (relationSelect) {
    setTimeout(() => { relationSelect.value = relationType; }, 0);
    }
    
    // نوع العضو
    const memberTypeInput = document.getElementById('member_type');
    if (relationType === 'زوجة' || relationType === 'زوج') {
    memberTypeInput.value = 'partner';
    } else {
    memberTypeInput.value = 'child';
    }
    
    // الحالة الصحية
    const healthSelect = document.getElementById('health_status2');
    if (healthSelect) {
    setTimeout(() => {
    healthSelect.value = (member.health_Status || '').trim();
    }, 0);
    }
    
    // فتح الـ popup
    overlayUpdateMember.style.display = 'flex';
    });
 });


document.addEventListener("DOMContentLoaded", function() {

    const openBtn = document.querySelector('.open-btn');
    const overlay = document.getElementById('popup-overlay');
    const closeBtn = overlay.querySelector('.close-btn');

    const overlay_application = document.querySelector('.overlay-application');
    const open_application_popup =document.querySelector('.open-application-popup');

    

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
    overlay_application.style.display = 'flex';
    });
}

// فتح popup إضافة
if (openBtnAdd) {
openBtnAdd.addEventListener('click', function(e) {
    e.preventDefault();
    overlay2.style.display = 'flex';
    overlay_application.style.display = 'none';
    

    const form = document.getElementById('popup-form2');
    // form.action = "{{ route('addRowMember') }}";
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


});

</script>
@if ($errors->popup_add_member->any())
overlay2.style.display = 'flex';
@endif
<script>
    function toggleDropdown() {
                document.getElementById('dropdownMenu').classList.toggle('show');
            }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const overlayUpdateMember = document.querySelector('.overlay-update-member');
    const closeBtnUM = overlayUpdateMember.querySelector('.close-btn');
    if(closeBtnUM) {
    closeBtnUM.addEventListener('click', () => {
    overlayUpdateMember.style.display = 'none';
    });
    }
    });
    
</script>

@livewireScripts

</html>