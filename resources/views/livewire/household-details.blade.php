    <div class="container">
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
        <div class="Container_Head">

            <div class="title_div">
                <h3 style="margin-bottom: 20px;">
                    المنظومة الإلكترونية لتحديث بيانات أسر مدينة بيت حانون (
                    <span style="color: #ff0000;">أ.محمد عدلي أبو عودة</span>
                    ) <i class="fa-solid fa-feather-pointed" style="font-size:23px;"></i>
                </h3>

            </div>
        </div>


        <div class="legal-switch">
            <input type="checkbox" id="legalConfirm" wire:model.live="legalConfirm"
                {{ $household->legal_confirmation? 'checked' : '' }} />
            <p for="legalConfirm" class="labelOFLegalConfirm" style="font-weight: 500; line-height: 1.8; font-size: 16px;
            {{ $household->legal_confirmation ? 'color:green;' : 'color:red;'}} " wire:ignore>
                أُقِرّ وأتحمّل كامل المسؤولية القانونية عن أي خطأ في البيانات التي قمت بإدخالها،
                وأعلم أنني أتحمّل كافة العقوبات القانونية المترتبة على ذلك.
            </p>
            <span style="color:red; font-weight: 900; font-size: 20px;">*</span>

        </div>
        <div class="Container_HouseHold bg-white ">
            <div class="title_div">
                <h3 class=""> معلومات رب الأسرة :</h3>
                <button class="open-btn"><i class="fa-regular fa-pen-to-square"></i> تحديث البيانات</button>
            </div>

            <div class="Grid Grid--gutters Grid--cols-3 u-textCenter">
                <div class="Grid-cell">
                    <div class="Demo" style="white-space: nowrap;">
                        <span class="font-bold">رقم الهوية : </span>
                        <span class="font-medium ">{{ $household->PersonId }}</span>
                    </div>
                </div>
                <div class="Grid-cell">
                    <div class="Demo" style="white-space: nowrap;">
                        <span class="font-bold">الإسم رباعي : </span>
                        <span class="font-medium">{{ $household->FName }} {{$household->SName}}
                            {{$household->TName}} {{ $household->LName }}</span>
                    </div>
                </div>
                <div class="Grid-cell">
                    <div class="Demo" style="white-space: nowrap;">
                        <span class="font-bold">رقم الهاتف الأساسي : </span>
                        <span class="font-medium">{{ $household->Phone_Number }}</span>
                    </div>
                </div>

                <div class="Grid-cell">
                    <div class="Demo" style="white-space: nowrap;">
                        <span class="font-bold ">تاريخ الميلاد : </span>
                        <span class="font-medium ">{{ $household->BirthDate }}</span>
                    </div>
                </div>

                <div class="Grid-cell">
                    <div class="Demo ">
                        <span class="font-bold"> عدد الأفراد : </span>
                        <span class="font-medium">{{ $household->num_Family_Members }}</span>
                    </div>
                </div>
            </div>

            <div class="Grid Grid--gutters Grid--cols-3 u-textCenter">
                <div class="Grid-cell">
                    <div class="Demo ">
                        <span class="font-bold"> الحالة الصحية : </span>
                        <span class="font-medium">
                            @if( $household->health_Status == "0" )
                            سليم
                            @elseif ($household->health_Status == "1")
                            مريض
                            @elseif($household->health_Status == "2")
                            مصاب
                            @elseif($household->health_Status == "3")
                            إعاقة سمعية
                            @elseif($household->health_Status == "4")
                            إعاقة جسدية
                            @elseif($household->health_Status == "5")
                            إعاقة عقلية
                            @elseif($household->health_Status == "6")
                            إعاقة بصرية
                            @elseif($household->health_Status == "7")
                            حالات حرجة
                            @elseif($household->health_Status == "8")
                            أمراض مزمنة
                            @elseif($household->health_Status == "9")
                            أخرى
                            @endif

                    </div>
                </div>


                <div class="Grid-cell">
                    <div class="Demo ">
                        <span class="font-bold"> مصدر الدخل الحالي : </span>
                        <span class="font-medium">{{ $household->Sources_income }}</span>
                    </div>
                </div>

                <div class="Grid-cell">
                    <div class="Demo ">
                        <span class="font-bold"> الراتب المتوقع: </span>
                        <span class="font-medium">
                            @if( $household->expected_salary )
                            {{ $household->expected_salary - 100}}$ - {{ $household->expected_salary + 100}}$
                            @endif
                        </span>
                    </div>
                </div>

                <div class="Grid-cell">
                    <div class="Demo ">
                        <span class="font-bold "> الجنس : </span>
                        <span class="font-medium ">{{ $household->Gender }}</span>
                    </div>
                </div>
                <div class="Grid-cell">
                    <div class="Demo ">
                        <span class="font-bold "> الحالة الإجتماعية : </span>
                        <span class="font-medium ">

                            @if( $household->status == "0" )
                            متزوج
                            @elseif ($household->status == "1")
                            متزوج متعدد
                            @elseif($household->status == "2")
                            مطلق / مطلقة
                            @elseif($household->status == "3")
                            أرمل / أرملة قبل حرب 2023
                            @elseif ($household->status == "4")
                            أرمل / أرملة بعد حرب 2023
                            @elseif ($household->status == "5")
                            أعزب تعدى ال 45 عاما
                            @else
                            --
                            @endif</span>
                    </div>
                </div>
                @if ($household->status ==="أرملة بعد حرب 2023")
                <div class="Grid-cell">
                    <div class="Demo">
                        <span class="" style="font-weight:500;"> تاريخ أستشهاد الزوج/ة : </span>
                        <span class=" " style="font-weight:300;">{{ $household->Date_partner_martyrdom }}</span>
                    </div>
                </div>
                @endif
            </div>



            <div class="Grid Grid--gutters Grid--cols-3 u-textCenter">

                <div class="Grid-cell">
                    <div class="Demo ">
                        <span class="font-bold"> المحافظة الحالية : </span>

                        <span class="font-medium">
                            @if( $household->governorate )
                            {{ $household->governorate->name }}
                            @else
                            --
                            @endif
                        </span>
                    </div>
                </div>

                <div class="Grid-cell">
                    <div class="Demo ">
                        <span class="font-bold"> المدينة الحالية: </span>

                        <span class="font-medium">
                            @if( $household->city )
                            {{ $household->city->name }}
                            @else
                            --
                            @endif
                        </span>
                    </div>
                </div>


                <div class="Grid-cell">
                    <div class="Demo ">
                        <span class="font-bold"> المنطقة الحالية: </span>

                        <span class="font-medium">
                            @if( $household->location )
                            {{ $household->location->name }}
                            @else
                            --
                            @endif
                        </span>
                    </div>
                </div>

                <div class="Grid-cell">
                    <div class="Demo" style="min-width: 250px; max-width: 500px;">
                        <span class="font-bold "> عنوان السكن : </span>
                        <span class="font-medium ">
                            @if( $household->address )
                            {{ $household->address }}
                            @else
                            --
                            @endif</span>
                    </div>
                </div>
            </div>
        </div>



        {{-- Dev 2 --}}
        <div class="Container_HouseHold bg-white shadow-lg rounded-xl p-6 mb-2" style="margin-top: 20px;">
            <div class="title_div">
                <h2 class="text-2xl font-bold"> معلومات أفراد الأسرة </h2>
                {{-- add member button --}}
                {{-- <button class="open-btn-add" wire:ignore><i class="fa-regular fa-pen-to-square"></i> أضف فرد </button> --}}
                <button class="open-application-popup" wire:ignore><i class="fa-regular fa-pen-to-square"></i> إضافة طلب
                </button>
            </div>
     


            <div class="card-body py-3">
                <div>
                    <!--begin::Tap pane-->
                    <div class="tab-pane fade show active" id="kt_table_widget_5_tab_1">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="border-0">
                                        <th class="w-50px" style="background-color: #1bb9b1a9 white-space: nowrap; ">صلة
                                            القرابة</th>
                                        <th class="min-w-50px" style="white-space: nowrap;">رقم الهوية</th>
                                        <th class="min-w-150px" style="white-space: nowrap;">الأسم رباعي</th>
                                        <th class="min-w-90px" style="white-space: nowrap;" st>تاريخ الميلاد</th>
                                        <th class="min-w-70px" style="white-space: nowrap;"> الحالة الصحية</th>
                                        <th class="w-50px" style="white-space: nowrap;"> الإعدادات</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    {{-- Partner --}}
                                    @if ($household->partner )

                                    @foreach ($household->partner as $member1)
                                    <tr>
                                        <td class="text-end">
                                            <span class="badge badge-light-success fw-bold d-block">
                                                {{ $member1->relationship ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted fw-bold d-block">{{$member1->PersonId}}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted fw-bold d-block">{{$member1->FName}}
                                                {{$member1->SName}}
                                                {{$member1->TName}} {{$member1->LName}}</span>
                                        </td>
                                        <td class="text-end text-muted fw-bold">
                                            {{$member1->birthdate}}
                                        </td>
                                        <td class="text-end text-muted fw-bold">

                                            {{ $healthStatusArr[$member1->health_Status] ?? 'غير محدد' }}
                                        </td>

                                        <td class="text-end" style="display:flex; gap:10px; text-align: center;">
                                            <a href="#"
                                                class="open-btn-edit btn btn-sm btn-icon btn-bg-light btn-active-color-primary {{ !$household->legal_confirmation ? 'hidden-smooth' : '' }}"
                                                wire:click="openEditMember({{ $member1->id }} , 'partner')">
                                                <span class="svg-icon svg-icon-2">
                                                    <i class="fa-solid fa-arrow-left"></i>
                                                </span>
                                            </a>
                                            <a href="#"
                                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary delete-member {{ !$household->legal_confirmation ? 'hidden-smooth' : '' }}"
                                                data-id="{{ Crypt::encrypt($member1->id) }}" data-type="partner">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                                <span class="svg-icon svg-icon-2" style="color: red">
                                                    <i class="fa-solid fa-trash"></i>
                                                </span>

                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                    {{-- siblings --}}

                                    {{-- parents --}}
                                    {{-- children --}}
                                    @if ($household->status !== "أعزب تعدى ال 45 عام")

                                    @foreach ($household->children as $member)
                                    <tr>
                                        <td class="text-end">
                                            <span
                                                class="badge badge-light-primary">{{$member->relation_title? $member->relation_title : $member->relationship }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted fw-bold d-block">{{$member->PersonId}}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted fw-bold d-block">{{$member->FName}}
                                                {{$member->SName}}
                                                {{$member->TName}} {{$member->LName}}</span>
                                        </td>

                                        <td class="text-end text-muted fw-bold">
                                            {{$member->BirthDate}}
                                        </td>
                                        <td class="text-end text-muted fw-bold">
                                            {{ $healthStatusArr[$member->health_Status] ?? 'غير محدد' }}
                                        </td>

                                        <td class="text-end" style="display:flex; gap:10px; text-align: center;">
                                            <a href="#"
                                                class="open-btn-edit btn btn-sm btn-icon btn-bg-light btn-active-color-primary {{ !$household->legal_confirmation ? 'hidden-smooth' : '' }}"
                                                wire:click="openEditMember({{ $member->id }} , 'children')">
                                                <span class="svg-icon svg-icon-2">
                                                    <i class="fa-solid fa-arrow-left"></i>
                                                </span>
                                            </a>

                                            <a href="#"
                                                class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary delete-member {{ !$household->legal_confirmation ? 'hidden-smooth' : '' }}"
                                                data-id="{{ Crypt::encrypt($member->id) }}" data-type="child">
                                                <span class="svg-icon svg-icon-2" style="color: red">
                                                    <i class="fa-solid fa-trash"></i>
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
                        <!--end::Table-->
                    </div>
                    <small>عدد أفراد الأسرة المضافين <span
                            class='numMember'>{{ $household->partner->count() +$household->children->count() + 1 }}
                            <span>/{{$household->num_Family_Members}}</small>
                </div>
            </div>

        </div>


        <div style="text-align: center;">
            <!-- hidden-smooth -->
            <button class="SaveEditBtn {{ !$household->legal_confirmation ? 'hidden-smooth' : '' }} " id="SaveEditBtn"
                style="width: 250px; font-size:20px;">
                <i class="fa-regular fa-floppy-disk"></i> حفظ كل التعديلات
            </button>
        </div>

        {{-- pop up of application Model --}}
        <div id="popup-overlay-application" class="overlay-application">
        
            <div class="popup-application">
                <button type="button" class="close-btn">
                    <i class="fa-solid fa-x"></i>
                </button>
        
                <h2>اختر نوع الطلب</h2>
        
                <div class="application-buttons" style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px;">
                    <button target="_blank" class="open-reg_married">أضف طلب زواج
                        <i class="fa-solid fa-venus-mars"></i></button>
                    <button target="_blank" class="open-btn-app open-btn-add">إضافة فرد للعائلة <i
                            class="fa-regular fa-pen-to-square"></i></button>
                </div>
        
            </div>
        </div>
        {{-- Popup for add new member to the family --}}
        <div id="popup-overlay2" class="overlay2">
            <div class="popup2">

                <div class="close-btn"> <span><i class="fa-solid fa-x"></i> </div>
                <h2>أضف بيانات الفرد<i class="fa-solid fa-feather-pointed"></i>
                </h2>
                <form id="popup-form2" action="{{ route('member-requests.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf


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
                            {{--زوجة ابن ابنة--}}
                            <select name="relation" id="relationship" class="household-relationship" required>
                                <option value="">اختر العلاقة </option>
                                @foreach (['زوجة','ابن','ابنة'] as $relation)
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

                    {{--الأسم  كامل  --}}
                    <div class="field">
                        <label class="field-label">الإسم بالكامل <span class="requiredStar">*</span></label>

                        <div class="custom-input">
                            <div style="display: flex;">
                                <input class="NameBox FNameM" type="text" name="FName" id="FName"
                                    value="{{ old('FName', $household->FName ?? '') }}">
                                <input class="NameBox SNameM" value="{{ old('SName', $household->SName ?? '') }}"
                                    type="text" id="SName" name="SName">
                                <input class="NameBox TNameM" value="{{ old('TName', $household->TName ?? '') }}"
                                    type="text" id="TName" name="TName">
                                <input class="NameBox LNameM" value="{{ old('LName', $household->LName ?? '') }}"
                                    type="text" id="LName" name="LName">
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
                            <input type="text" name="PersonId" value="{{ old('PersonId', $member->PersonId ?? '') }}"
                                maxlength="9" pattern="[0-9]{9}" inputmode="numeric" required id="Id">
                            @error('PersonId')
                            <small class="error-msg">{{ $message }}</small>
                            @enderror
                            <script>
                                // منع إدخال أكثر من 9 أرقام (لا تكرر متغيرات عامة مثل input)
                                const idInput = document.getElementById('Id');
                                if (idInput) {
                                    idInput.addEventListener('input', function () {
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
                        <div class="custom-input">
                            <input type="date" name="BirthDate" value="{{ old('BirthDate', $member->BirthDate ?? '') }}"
                                required>
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
                                <option value="9" {{ old('health_status') == '9' ? 'selected' : '' }}>إعاقة بصرية</option>
                                <option value="10" {{ old('health_status') == '10' ? 'selected' : '' }}>أخرى</option>
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

                    <div id="child-files" style="display:none;">
                        <div class="field">
                            <div class="custom-input">
                                <label>شهادة ميلاد الفرد أو الهوية الشخصية للفرد</label>
                                <input type="file" name="birth_certificate">
                            </div>
                        </div>

                        <div class="field">
                            <div class="custom-input">
                                <label>هوية رب الأسرة</label>
                                <input type="file" name="household_id_image" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div id="wife-files" style="display:none;">
                        <div class="field">
                            <div class="custom-input">
                                <label>الهوية الشخصية مع السليب :</label>
                                <input type="file" name="identity_image" accept="image/*">
                            </div>
                        </div>
                    </div>
                    {{-- <script>
                    attachment.addEventListener('change', function () {
                        preview.innerHTML = '';
                    
                        const file = this.files[0];
                    
                        if (file) {
                            const reader = new FileReader();
                    
                            reader.onload = function (e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.style.width = '120px';
                                img.style.marginTop = '10px';
                                img.style.borderRadius = '10px';
                    
                                preview.appendChild(img);
                            };
                    
                            reader.readAsDataURL(file);
                        }
                    });
                </script> --}}

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
    </div>


    <script>
        const relation = document.getElementById('relationship');
                    
                    // const FName = document.getElementById('FName');
                    const SName = document.getElementById('SName');
                    const TName = document.getElementById('TName');
                    const LName = document.getElementById('LName');

                    
                    const childFiles = document.getElementById('child-files');
                    const wifeFiles = document.getElementById('wife-files');

                    const identity_image_input = document.querySelector('input[name="identity_image"]');

                    const birth_certificate_input = document.querySelector('input[name="birth_certificate"]');
                    const household_id_image_input = document.querySelector('input[name="household_id_image"]');

                    const preview = document.getElementById('preview-container');
                    // const attachment = document.getElementById('attachment');
                const householdRelationship = document.querySelector('.household-relationship');
                
                const householdSName = document.querySelector('.SNameM');
                const householdTName = document.querySelector('.TNameM');
                const householdLName = document.querySelector('.LNameM');
                
                householdRelationship.addEventListener('change', function () {
                
                let value = householdRelationship.value;
                
                
                
                if (value === 'ابن' || value === 'ابنة') {
                householdSName.value = "{{ $household->SName }}";
                householdTName.value = "{{ $household->TName }}";
                householdLName.value = "{{ $household->LName }}";
                childFiles.style.display = "block";
                wifeFiles.style.display = "none";
                
                }else{
                    householdSName.value = "";
                    householdTName.value = "";
                    householdLName.value = "";
                            childFiles.style.display = "none";
                            wifeFiles.style.display = "block";
                }
                });
                    function handleRelationUI(value) {
                                    
                                    if (value === 'ابن' || value === 'ابنة') {
                                    
                                    
                                    // SName.value = "{{ $household->FName }}";
                                    // TName.value = "{{ $household->SName }}";
                                    // LName.value = "{{ $household->LName }}";
                                    
                                    // SName.disabled = true;
                                    // TName.disabled = true;
                                    // LName.disabled = true;
                                    
                                    childFiles.style.display = 'block';
                                    wifeFiles.style.display = 'none';
                                    
                                    identity_image_input.required = false;
                                    birth_certificate_input.required = true;
                                    household_id_image_input.required = true;
                                    
                                } else if (value === 'زوجة') {
                                    
                                    SName.value = "";
                                    TName.value = "";
                                    LName.value = "";
                                    
                                    // SName.disabled = false;
                                    // TName.disabled = false;
                                    // LName.disabled = false;
                                    
                                    identity_image_input.required = true;
                                    birth_certificate_input.required = false;
                                    household_id_image_input.required = false;
                                    
                                    childFiles.style.display = 'none';
                                    wifeFiles.style.display = 'block';
                                    }
                                }

                        relation.addEventListener('change', function () {
                                        handleRelationUI(this.value); 
                        });
                    
                    
    </script>
    @if ($errors->any())
    <script>
        document.getElementById('popup-overlay2').style.display = 'flex';
                                    //  إعادة تشغيل الحالة حسب القيمة القديمة
                                    handleRelationUI(document.getElementById('relationship').value);
                                    console.log(document.getElementById('relationship').value);
                                    
    </script>
    @endif


    <script>
        //legal confirmation toggle
        const legalSwitch = document.querySelector('.legal-switch input');
        const labelOFLegalConfirm = document.querySelector('.labelOFLegalConfirm');
        // legalSwitch.addEventListener('change', function() {
        // if (this.checked) {
        // // labelOFLegalConfirm
        // labelOFLegalConfirm.style.color = 'green';
        // if(document.querySelectorAll('tbody tr').length + 1 < {{ $household->num_Family_Members }}){
        // document.querySelector('.open-btn-add').classList.remove('hidden-smooth');
        // }
        // } else {
        // labelOFLegalConfirm.style.color = 'red';
        // document.querySelector('.open-btn-add').classList.add('hidden-smooth');
        // }
        // });
        
        document.addEventListener('DOMContentLoaded', function () {

            // popup for application
            const openApplicationPopupBtn = document.querySelector('.open-application-popup');
            const applicationPopup = document.getElementById('popup-overlay-application');
            const closeApplicationPopupBtn = applicationPopup.querySelector('.close-btn');
            openApplicationPopupBtn.addEventListener('click', function () {
                applicationPopup.style.display = 'flex';
            });
            closeApplicationPopupBtn.addEventListener('click', function () {
                applicationPopup.style.display = 'none';
            });



    const SaveEditBtn = document.querySelector('.SaveEditBtn');
    // const addBtn = document.querySelector('.open-btn-add');
    const maxMembers = {{ $household->num_Family_Members }};
    
    // دالة لحساب عدد أفراد الأسرة الحاليين من الجدول مباشرة
    function getCurrentMembers() {
    return document.querySelectorAll('tbody tr').length + 1;
    // +1 لرب الأسرة نفسه
    }

    // دالة لتفعيل/إخفاء زر إضافة الفرد
    function toggleAddButton() {
    const currentMembers = getCurrentMembers();

    // if (currentMembers >= maxMembers) {
    // addBtn.classList.add('hidden-smooth');
    // } else {
    // addBtn.classList.remove('hidden-smooth');
    // }
    }

    // تشغيل أول مرة عند تحميل الصفحة
    toggleAddButton();

        SaveEditBtn.addEventListener('click', function (e) {
            // مراقبة أي إضافة عضو عبر Livewire أو DOM
                const observer = new MutationObserver(toggleAddButton);
                observer.observe(document.querySelector('tbody'), { childList: true, subtree: true });
            const originalCount = {{$household->num_Family_Members ?? 0 }};
            const currentCount = {{ $household->partner->count() + $household->children->count() + 1 }};
            if (originalCount > currentCount) {
                Swal.fire(
                    'خطأ',
                    'عدد أفراد الأسرة الحالي لا يتطابق مع العدد المعلن. يرجى التأكد من صحة البيانات قبل الحفظ.',
                    'error'
                );
                return;
            }
            
            e.preventDefault(); 

            Swal.fire(
                'تم الحفظ!',
                'تم حفظ جميع التعديلات بنجاح!',
                'success'
            );
        });
        document.body.addEventListener('click', function (e) {
            const btn = e.target.closest('.delete-member');
            if (!btn) return;

            // مراقبة أي إضافة عضو عبر Livewire أو DOM
                const observer = new MutationObserver(toggleAddButton);
                observer.observe(document.querySelector('tbody'), { childList: true, subtree: true });
            e.preventDefault();

            const memberId = btn.dataset.id;
            const type = btn.dataset.type;

            Swal.fire({
                title: 'هل أنت متأكد من عملية الحذف؟',
                text: 'لا يمكن التراجع عن هذا الإجراء!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذف',
                cancelButtonText: 'إلغاء',
            }).then((result) => {

                // ✅ في حال التأكيد
                if (result.isConfirmed) {
                    fetch(`/member/${memberId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            type: type
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            btn.closest('tr').remove();
                            const span = document.querySelector('.numMember');
                            let current = parseInt(span.textContent);

                            if (!isNaN(current) && current > 0) {
                                span.textContent = current - 1;
                            }
                            Swal.fire(
                                'تم الحذف!',
                                'تم حذف السجل بنجاح',
                                'success'
                            );
                        // مراقبة أي إضافة عضو عبر Livewire أو DOM
                            const observer = new MutationObserver(toggleAddButton);
                            observer.observe(document.querySelector('tbody'), { childList: true, subtree: true });
                        } else {
                            Swal.fire(
                                'خطأ',
                                data.message || 'حدث خطأ أثناء الحذف',
                                'error'
                            );
                        }
                    })
                    .catch(() => {
                        Swal.fire(
                            'خطأ في الاتصال',
                            'تعذر الاتصال بالخادم',
                            'error'
                        );
                    });
                }

                // ❌ في حال الإلغاء
                else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'تم الإلغاء',
                        'لم يتم حذف أي بيانات',
                        'info'
                    );
                }

            });
        });

    });


    </script>