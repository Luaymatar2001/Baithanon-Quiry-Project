<div class="container">
    <div class="Container_Head">

        <div class="title_div">
            <h3 style="margin-bottom: 20px;">
                تحديث بيانات أسر وأهالي بيت حانون وأضافة بيانات الأبناء والأزواج
                <i class="fa-solid fa-feather-pointed" style="font-size:23px;"></i>
            </h3>

        </div>
    </div>

    <div class="legal-switch">
        <input type="checkbox" id="legalConfirm" wire:model.live="legalConfirm"
            {{ $household->legal_confirmation? 'checked' : '' }} />
        <p for="legalConfirm" class="labelOFLegalConfirm" style="font-weight: 500; font-size: 16px;
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
                <div class="Demo">
                    <span class="font-bold ">رقم الهوية : </span>
                    <span class="font-medium ">{{ $household->PersonId }}</span>
                </div>
            </div>
            <div class="Grid-cell">
                <div class="Demo">
                    <span class="font-bold">الإسم رباعي : </span>
                    <span class="font-medium">{{ $household->FName }} {{$household->SName}}
                        {{$household->TName}} {{ $household->LName }}</span>
                </div>
            </div>
            <div class="Grid-cell">
                <div class="Demo">
                    <span class="font-bold">رقم الهاتف : </span>
                    <span class="font-medium">{{ $household->Phone_Number }}</span>
                </div>
            </div>

            <div class="Grid-cell">
                <div class="Demo">
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
                    <span class="font-medium">{{ $household->health_Status }}</span>
                </div>
            </div>


            <div class="Grid-cell">
                <div class="Demo ">
                    <span class="font-bold"> العمل الحالي : </span>
                    <span class="font-medium">{{ $household->Sources_income }}</span>
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
                        @if( $household->status )
                        {{ $household->status }}
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
                    <span class="font-bold"> المحافظة : </span>

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
                    <span class="font-bold"> المدينة: </span>

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
                    <span class="font-bold"> المنطقة: </span>

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
            <button class="open-btn-add"><i class="fa-regular fa-pen-to-square"></i> أضف فرد </button>
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
                                    <th class="w-50px" style="background-color: #1bb9b1a9">صلة الفرابة</th>
                                    <th class="min-w-150px">رقم الهوية</th>
                                    <th class="min-w-140px">الأسم رباعي</th>
                                    <th class="min-w-110px">تاريخ الميلاد</th>
                                    <th class="min-w-110px"> الحالة الصحية</th>
                                    <th class=" min-w-50px"> الإعدادات</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                {{-- Partner --}}
                                @if ($household->partner)
                                @foreach ($household->partner as $member1)
                                <tr>
                                    <td class="text-end">
                                        <span
                                            class="text-muted fw-bold d-block badge-light-success">{{$member1->relationship}}</span>
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
                                        {{$member1->health_Status}}
                                    </td>
                                    <td class="text-end" style="display:flex; gap:10px; text-align: center;">
                                    <td class="text-end" style="display:flex; gap:10px; text-align: center;">
                                        <a href="#"
                                            class="open-btn-edit btn btn-sm btn-icon btn-bg-light btn-active-color-primary {{ !$household->legal_confirmation ? 'hidden-smooth' : '' }}"
                                            data-member='@json($member1)' onclick="event.preventDefault()">
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
                                @foreach ($household->children as $member)

                                <tr>
                                    <td class="text-end">
                                        <span class="badge badge-light-primary">{{$member->relation_title}}</span>
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
                                        {{$member->health_Status}}

                                    </td>
                                    <td class="text-end" style="display:flex; gap:10px; text-align: center;">
                                        <a href="#"
                                            class="open-btn-edit btn btn-sm btn-icon btn-bg-light btn-active-color-primary {{ !$household->legal_confirmation ? 'hidden-smooth' : '' }}"
                                            data-member='@json($member)' onclick="event.preventDefault()">
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

                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </div>
                    <!--end::Table-->
                </div>
                <small>عدد أفراد الأسرة المضافين <span
                        class='numMember'>{{ $household->partner->count() +$household->children->count() + 1 }}
                        <span>/{{$household->num_Family_Members}}</small>
                <!--end::Tap pane-->
            </div>
        </div>
        <!--end::Body-->

    </div>

    <div style="text-align: center;">
        <!-- hidden-smooth -->
        <button class="SaveEditBtn {{ !$household->legal_confirmation ? 'hidden-smooth' : '' }} " id="SaveEditBtn"
            style="width: 250px; font-size:20px;">
            <i class="fa-regular fa-floppy-disk"></i> حفظ كل التعديلات
        </button>
    </div>


</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
 const SaveEditBtn = document.querySelector('.SaveEditBtn');
const addBtn = document.querySelector('.open-btn-add');
const maxMembers = {{ $household->num_Family_Members }};

// دالة لحساب عدد أفراد الأسرة الحاليين من الجدول مباشرة
function getCurrentMembers() {
return document.querySelectorAll('tbody tr').length + 1;
// +1 لرب الأسرة نفسه
}

// دالة لتفعيل/إخفاء زر إضافة الفرد
function toggleAddButton() {
const currentMembers = getCurrentMembers();

if (currentMembers >= maxMembers) {
addBtn.classList.add('hidden-smooth');
} else {
addBtn.classList.remove('hidden-smooth');
}
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

//legal confirmation toggle
const legalSwitch = document.querySelector('.legal-switch input');
const labelOFLegalConfirm = document.querySelector('.labelOFLegalConfirm'); 
legalSwitch.addEventListener('change', function() {
    if (this.checked) {
        // labelOFLegalConfirm
        labelOFLegalConfirm.style.color = 'green';
     
    } else {
        labelOFLegalConfirm.style.color = 'red';

    }
});
</script>