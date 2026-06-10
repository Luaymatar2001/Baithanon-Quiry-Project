<?php

namespace App\Http\Controllers;

use App\Models\head_children;
use App\Models\household;
use App\Models\partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class HouseholdController extends Controller
{

    // for details page
    public function updateDetails(Request $request)
    {
        $householdId = session('household_verified');
        if (!$householdId) {
            abort(403, 'Unauthorized');
        }
        $household = household::where('id', session('household_verified'))
            ->firstOrFail();


        $validator = Validator::make(
            $request->all(),
            [

                'address' => 'nullable|string|max:255',
                'city_id' => 'nullable|integer|exists:city,id',
                'status' => 'nullable|string|max:255|in:0,1,2,3,4,5',
                'health_status' => 'nullable|string|max:255|in:0,1,2,3,4,5,6,7,8,9,10',
                'Sources_income' => [
                    'nullable',
                    'string',
                    Rule::in([
                        'بلا عمل',
                        'عامل يومي',
                        'موظف حكومي',
                        'موظف خاص',
                        'موظف عقود',
                        'موظف وكالة',
                        'أخرى',
                    ]),
                ],
                'location_id' => 'nullable|integer|exists:locations,id',
                'Phone_Number' => [
                    'nullable',
                    'digits:10',
                    'regex:/^(059|056)\d{7}$/'
                ],
                'governorate_id' => 'nullable|integer|exists:governorates,id',
                'Date_partner_martyrdom' => 'nullable|Date',
                'expected_salary' => 'nullable',
                'desc_health_status' => 'nullable|string|max:255',
                'alternative_mobile_number' => [
                    'nullable',
                    'digits:10',
                    'regex:/^(059|056)\d{7}$/'
                ],
                'residence_location' => 'required|string|in:0,1|max:255',
                'residence_address' => 'nullable|string|max:255|in:0,1',
                'residence_status' => 'nullable|string|in:0,1,2|max:255',
                'international_number_mobile' => [
                    'nullable',
                    'digits_between:10 ,13',
                ],
                'missing_persons' => 'nullable|integer|in:0,1,2',
                'missing_info' => 'nullable|string|max:255',
                'level_of_education' => 'nullable|string|max:255|in:0,1,2,3,4,5,6',
                'Type_of_housing' => 'nullable|string|max:255|in:0,1,2,3,4,5,6',
                'current_location' => 'nullable|string|max:255',
                'reason_leaving' => 'nullable|string|max:255',
                'status_document' => [
                    Rule::requiredIf(
                        in_array($request->status, ['2', '3', '4'])
                            && !$household->status_document
                    ),
                    'nullable',
                    'file',
                    'mimes:jpg,jpeg,png',
                    'max:5120',
                ],


                'widow_identity' => [
                    Rule::requiredIf(
                        $request->status == '4'
                            && !$household->widow_identity
                    ),
                    'nullable',
                    'file',
                    'mimes:jpg,jpeg,png',
                    'max:5120',
                ],
            ],
            [

                // العنوان
                'address.string' => 'العنوان يجب أن يكون نصًا',
                'address.max'    => 'العنوان يجب ألا يزيد عن 255 حرفًا',

                // المدينة
                'city.integer' => 'المدينة المختارة غير صحيحة',
                'city.exists'  => 'المدينة المختارة غير موجودة',

                // الحالة الاجتماعية
                'status.string' => 'الحالة الاجتماعية يجب أن تكون نصًا',
                'status.in'     => 'قيمة الحالة الاجتماعية غير صحيحة',

                // الحالة الصحية
                'health_status.string' => 'الحالة الصحية يجب أن تكون نصًا',
                'health_status.in'     => 'قيمة الحالة الصحية غير صحيحة',

                // مصدر الدخل
                'Sources_income.string' => 'مصدر الدخل يجب أن يكون نصًا',
                'Sources_income.in'     => 'قيمة مصدر الدخل غير صحيحة',

                // رقم الهاتف   
                'Phone_Number.numeric' => 'رقم الهاتف يجب أن يكون أرقامًا فقط',
                'Phone_Number.max'     => 'رقم الهاتف يجب ألا يتجاوز 10 أرقام',
                'Phone_Number.regex'   => 'رقم الهاتف يجب أن يبدأ ب059 أو 056 ويتبعه 7 أرقام',


                // تاريخ استشهاد الشريك
                'Date_partner_martyrdom.date' => 'صيغة تاريخ استشهاد الشريك غير صحيحة',
                'locations.exists' => 'موقعك غير موجود لدينا',
                'locations.integer' => 'أرجوا الأختيار بالطريقة الصحيحة',

                'governorate_id.exists' => 'محافظتك غير موجود لدينا',
                'governorate_id.integer' => 'أرجوا الأختيار بالطريقة الصحيحة',
                'expected_salary.integer' => 'الراتب المتوقع يجب أن يكون رقمًا',

                'desc_health_status.string' => 'وصف الحالة الصحية يجب أن يكون نصًا',
                'desc_health_status.max' => 'النص يجب ألا يزيد عن 255 حرفًا',

                'alternative_mobile_number.numeric' => 'رقم الهاتف البديل يجب أن يكون أرقامًا فقط',
                'alternative_mobile_number.max' => 'رقم الهاتف البديل يجب ألا يتجاوز
                    10 أرقام',

                'alternative_mobile_number.regex' => 'رقم الهاتف البديل يجب أن يبدأ ب059 أو 056 ويتبعه 7 أرقام',
                'residence_location.string' => 'موقع السكن يجب أن يكون نصًا',
                'residence_location.in' => 'قيمة موقع السكن غير صحيحة',
                // 'residence_status.string' => 'حالة السكن يجب أن يكون نصًا',
                'residence_status.in' => 'قيمة حالة السكن غير صحيحة',

                'international_number_mobile.numeric' => 'رقم الهاتف الدولي يجب أن يكون أرقامًا فقط',
                'international_number_mobile.digits_between' => 'رقم الهاتف الدولي يجب أن يكون بين 10 و 13 رقمًا',

                'missing_persons.integer' => 'عدد الأشخاص المفقودين يجب أن يكون رقمًا',
                'missing_info.string' => 'معلومات الأشخاص المفقودين يجب أن يكون نص
                ',
                'missing_info.max' => 'معلومات الأشخاص المفقودين يجب أن لا يزيد عن 255 حرفًا',
                'level_of_education.string' => 'مستوى التعليم يجب أن يكون نصًا',
                'level_of_education.max' => 'مستوى التعليم يجب أن لا يزيد عن 255 حرفًا',
                'level_of_education.in' => 'قيمة مستوى التعليم غير صحيحة',

                'Type_of_housing.string' => 'نوع السكن يجب أن يكون نصًا',
                'Type_of_housing.max' => 'نوع السكن يجب أن لا يزيد عن 255 حرفًا',
                'Type_of_housing.in' => 'قيمة نوع السكن غير صحيحة',
                // 'nullable',
                // 'file',
                // 'mimes:jpg,jpeg,png',
                // 'max:5120',
                'status_document.file' => 'يجب أن يكون العنصر من نوع صورة !',
                'status_document.mimes' => 'الملفات المسموح بإرفاقها jpg,jpeg,png',
                'status_document.max' => 'حجم الصورة كبير ',

                'widow_identity.file' => 'يجب أن يكون العنصر من نوع صورة !',
                'widow_identity.mimes' => 'الملفات المسموح بإرفاقها jpg,jpeg,png',
                'widow_identity.max' => 'حجم الصورة كبير ',
                
            ]

        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'popup_update_houseHold')
                ->withInput();
        }

        $validatedData = $validator->validated();

        // dd(function_exists('symlink'));
        if ($request->hasFile('status_document')) {

            // احذف القديم إذا موجود
            if ($household->status_document) {
                $oldPath = public_path('uploads/' . $household->status_document);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }


            // خزّن الجديد
            $file = $request->file('status_document');

            $fileName = time() . '_status_' . $file->getClientOriginalName();

            $uploadPath = public_path('uploads/hosuseholdMaritalStatus/status_documents');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $fileName);

            $household->status_document = 'hosuseholdMaritalStatus/status_documents/' . $fileName;
        }


        if ($request->hasFile('widow_identity')) {

            // احذف القديم إذا موجود

            if ($household->widow_identity) {
                $oldPath = public_path('uploads/' . $household->widow_identity);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // خزّن الجديد

            $file = $request->file('widow_identity');

            $fileName = time() . '_status_' . $file->getClientOriginalName();

            $uploadPath = public_path('uploads/hosuseholdMaritalStatus/widow_identity');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $fileName);

            $household->widow_identity = 'hosuseholdMaritalStatus/widow_identity/' . $fileName;
        }


        // dd($validatedData);
        $household->update([
            'status' => $validatedData['status'] ?? null,
            'health_Status' => $validatedData['health_status'] ?? null,
            'Sources_income' => $validatedData['Sources_income'] ?? null,
            'address' => $validatedData['address'] ?? null,
            'Phone_Number' => $validatedData['Phone_Number'] ?? null,
            'cityId' => $validatedData['city_id'] ?? null,
            'location_id' => $validatedData['location_id'] ?? null,
            'governorate_id' => $validatedData['governorate_id'] ?? null,
            'Date_partner_martyrdom' => $validatedData['Date_partner_martyrdom'] ?? null,
            'expected_salary' => $validatedData['expected_salary'] ?? null,
            'desc_health_status' => $validatedData['desc_health_status'] ?? null,
            'alternative_mobile_number' => $validatedData['alternative_mobile_number'] ?? null,
            'residence_location' => $validatedData['residence_location'] ?? null,
            'residence_status' => $validatedData['residence_status'] ?? null,
            'international_number_mobile' => $validatedData['international_number_mobile'] ?? null,
            'missing_persons' => $validatedData['missing_persons'] ?? null,
            'missing_info' => $validatedData['missing_info'] ?? null,
            'level_of_education' => $validatedData['level_of_education'] ?? null,
            'Type_of_housing' => $validatedData['Type_of_housing'] ?? null,
            'current_location' => $validatedData['current_location'] ?? null,
            'reason_leaving' => $validatedData['reason_leaving'] ?? null,
        ]);

        return redirect()->back()->with('message', 'تم تحديث بيانات الأسرة بنجاح');
    }




    public function index()
    {
        //
    }
    public function create() {}
    public function store(Request $request) {}
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //

    }


    public function addRowMember(Request $request)
    {

        // حماية الجلسة
        $householdId = session('household_verified');
        if (!$householdId) {
            return response()->json([
                'message' => 'غير مصرح لك'
            ], 403);
        }

        $householdId = household::where('id', session('household_verified'))
            ->firstOrFail();

        if (!$householdId->legal_confirmation) {
            abort(403, 'Unauthorized - Legal confirmation required');
        }

        $rules = [
            'FName' => 'required|string|max:20',
            'SName' => 'sometimes|string|max:20',
            'TName' => 'sometimes|string|max:20',
            'LName' => 'sometimes|string|max:20',
            'PersonId' => ['required', 'digits:9'],
            'relation' => 'required|in:زوجة,ابن,ابنة',
            'health_status' => 'required|in:0,1,2,3,4,5,6,7,8,9,10',
            'BirthDate' => 'required|date|before:today',
            'desc_health_status_member' => 'nullable|string|max:255',




        ];
        if ($request->relation === 'ابن' || $request->relation === 'ابنة') {

            $rules['birth_certificate'] = 'required|image|max:2048';
            $rules['household_id_image'] = 'required|image|max:2048';
        } elseif ($request->relation === 'زوجة') {
            $rules['identity_image'] = 'required|image|max:2048';
        }

        // Validation
        $validator = Validator::make($request->all(), $rules, [
            'FName.required' => 'حقل الاسم الأول مطلوب',
            'FName.string'   => 'الاسم الأول يجب أن يكون نصاً',
            'FName.max'      => 'الاسم الأول يجب ألا يتجاوز 20 حرفاً',

            'SName.required' => 'اسم الأب مطلوب',
            'SName.string'   => 'اسم الأب يجب أن يكون نصاً',
            'SName.max'      => 'اسم الأب يجب ألا يتجاوز 20 حرفاً',

            'TName.required' => 'اسم الجد مطلوب',
            'TName.string'   => 'اسم الجد يجب أن يكون نصاً',
            'TName.max'      => 'اسم الجد يجب ألا يتجاوز 20 حرفاً',

            'LName.required' => 'اسم العائلة مطلوب',
            'LName.string'   => 'اسم العائلة يجب أن يكون نصاً',
            'LName.max'      => 'اسم العائلة يجب ألا يتجاوز 20 حرفاً',

            'relation.required' => 'يرجى اختيار صلة القرابة',
            'relation.string'   => 'قيمة صلة القرابة غير صحيحة',

            'PersonId.required' => 'رقم الهوية مطلوب',
            'PersonId.digits'   => 'رقم الهوية يجب أن يتكون من 9 أرقام',

            'Sources_income.required' => 'يرجى اختيار مصدر الدخل',
            'Sources_income.in'       => 'قيمة مصدر الدخل غير صحيحة',

            'health_status.required' => 'يرجى اختيار الحالة الصحية',
            'health_status.in'       => 'قيمة الحالة الصحية غير صحيحة',

            'BirthDate.required' => 'تاريخ الميلاد مطلوب',
            'BirthDate.date'     => 'صيغة تاريخ الميلاد غير صحيحة',
            'BirthDate.before'  => 'تاريخ الميلاد يجب أن يكون قبل اليوم',


            'desc_health_status.string' => 'وصف الحالة الصحية يجب أن يكون نصًا',
            'desc_health_status.max' => 'النص يجب ألا يزيد عن 255 حرفًا',

            'desc_health_status_member.string' => 'وصف الحالة الصحية يجب أن يكون نصًا',
            'desc_health_status_member.max' => 'النص يجب ألا يزيد عن 255 حرفًا',

            'birth_certificate.required' => 'صورة شهادة الميلاد مطلوبة للأبناء',
            'birth_certificate.image' => 'صورة شهادة الميلاد يجب أن تكون ملف صورة',

            'household_id_image.required' => '',
            'household_id_image.image' => '',



        ]);
        // dd($validator->messages()->toArray());
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }


        $validated = $validator->validated();

        $personId = $validated['PersonId'] ?? null;
        $exists =
            household::where('PersonId', $personId)->exists()
            || partner::where('PersonId', $personId)->exists()
            || head_children::where('PersonId', $personId)->exists();

        if ($exists) {
            return redirect()->back()->with('IdExistedMessage', 'رقم الهوية مسجل مسبقًا، يرجى التحقق من البيانات أو التواصل مع الدعم الفني. *0567275232*');
        }


        if (in_array($validated['relation'], ['زوج', 'ابن'])) {
            $gender = 'ذكر';
        } elseif (in_array($validated['relation'], ['زوجة', 'ابنة'])) {
            $gender = 'أنثى';
        } else {
            $gender = null;
        }


        // dd($validated);


        if (in_array($validated['relation'], ['زوجة', 'زوج'])) {
            partner::create([
                'PersonId' => $validated['PersonId'],
                'householdId' => $householdId->PersonId,
                'FName' => $validated['FName'],
                'SName' => $validated['SName'],
                'TName' => $validated['TName'],
                'LName' => $validated['LName'],
                'relationship' => $validated['relation'],
                'health_Status' => $validated['health_status'],
                'birthdate' => $validated['BirthDate'],
                'desc_health_status' => $validated['desc_health_status_member']

            ]);
        } elseif (in_array($validated['relation'], ['ابن', 'ابنة'])) {
            head_children::create([
                'PersonId' => $validated['PersonId'],
                'householdId' => $householdId->PersonId,
                'FName' => $validated['FName'],
                'SName' => $request['SName_hid'],
                'TName' => $request['TName_hid'],
                'LName' => $request['LName_hid'],
                'relationship' => $validated['relation'],
                'health_Status' => $validated['health_status'],
                'BirthDate' => $validated['BirthDate'],
                'Gender' => $gender, // صححت هنا من $validated => $validated['Gender']
                'desc_health_status' => $validated['desc_health_status_member']
            ]);
        }

        // حفظ
        return redirect()->back()->with('message', 'تم تحديث بيانات الأسرة بنجاح');
    }

    //update single 2 row 
    public function updateRowMember(Request $request)
    {

        $householdId = household::findOrFail(session('household_verified'));

        // 1️⃣ Validation
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|integer',
            'member_type' => 'required|in:partner,child',
            'health_status' => 'required',
            'desc_health_status_member' => 'nullable|string|max:255'
        ], [
            'member_id.required' => 'الفرد غير موجود',
            'member_type.required' => 'نوع العضو غير محدد',
            'health_status.required' => 'يرجى اختيار الحالة الصحية',
            'desc_health_status_member.string' => 'يجب أن يكون المدخل نصا',
            'desc_health_status_member.max' => 'يجب أن لا يزيد حجم النص عن ال 255 حرف '
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'popup_member')
                ->withInput();
        }

        $data =  $validator->validated();

        // 3️⃣ تحديد النوع القديم من قاعدة البيانات
        if ($partner = partner::find($data['member_id'])) {
            $member = $partner;
        } elseif ($child = head_children::find($data['member_id'])) {
            $member = $child;
        } else {
            abort(404);
        }

        // dd($data);
        if ($data['member_type'] === 'partner') {
            $member->update([
                'health_Status' => $data['health_status'],
                'desc_health_status' => $data['desc_health_status_member'],
            ]);
        } else {
            $member->update([
                'health_Status' => $data['health_status'],
                'desc_health_status' => $data['desc_health_status_member'],
            ]);
        }

        return redirect()->back()->with('message', 'تم تعديل البيانات بنجاح');
    }


    //update all member rows
    // public function updateRowMember(Request $request)
    // {
    //     $householdId = household::findOrFail(session('household_verified'));

    //     // 1️⃣ Validation
    //     $validator = Validator::make($request->all(), [
    //         'member_id' => 'required|integer',
    //         'member_type' => 'required|in:partner,child',
    //         'FName' => 'sometimes|string|max:20',
    //         'SName' => 'sometimes|string|max:20',
    //         'TName' => 'sometimes|string|max:20',
    //         'LName' => 'sometimes|string|max:20',
    //         'PersonId' => ['required', 'digits:9'],
    //         'relation' => 'required|in:زوجة,ابن,ابنة',
    //         'health_status' => 'required',
    //         'BirthDate' => 'required|date|before:today',
    //         'desc_health_status' => 'nullable|string|max:255'
    //     ], [
    //         'member_id.required' => 'الفرد غير موجود',
    //         'member_type.required' => 'نوع العضو غير محدد',
    //         'FName.required' => 'حقل الاسم الأول مطلوب',
    //         'FName.string' => 'الاسم الأول يجب أن يكون نصاً',
    //         'FName.max' => 'الاسم الأول يجب ألا يتجاوز 20 حرفاً',
    //         'PersonId.digits' => 'رقم الهوية يجب أن يتكون من 9 أرقام',
    //         'relation.required' => 'يرجى اختيار صلة القرابة',
    //         'health_status.required' => 'يرجى اختيار الحالة الصحية',
    //         'BirthDate.before' => 'تاريخ الميلاد يجب أن يكون قبل اليوم',
    //         'desc_health_status.string' => 'يجب أن يكون المدخل نصا',
    //         'desc_health_status.max' => 'يجب أن لا يزيد حجم النص عن ال 255 حرف '
    //     ]);

    //     if ($validator->fails()) {
    //         return back()
    //             ->withErrors($validator, 'popup_member')
    //             ->withInput();
    //     }

    //     $data =  $validator->validated();

    //     // 2️⃣ تحديد النوع الجديد
    //     $newType = in_array($data['relation'], ['زوج', 'زوجة']) ? 'partner' : 'child';

    //     // 3️⃣ تحديد النوع القديم من قاعدة البيانات
    //     if ($partner = partner::find($data['member_id'])) {
    //         $oldType = 'partner';
    //         $member = $partner;
    //     } elseif ($child = head_children::find($data['member_id'])) {
    //         $oldType = 'child';
    //         $member = $child;
    //     } else {
    //         abort(404);
    //     }

    //     // 4️⃣ حساب الجنس
    //     $gender = in_array($data['relation'], ['زوج', 'ابن']) ? 'ذكر' : 'أنثى';

    //     // 5️⃣ 🔥 هنا تحط الكود اللي سألت عنه

    //     DB::transaction(function () use ($oldType, $newType, $member, $data, $householdId, $gender) {

    //         // 🟢 نفس الجدول → تحديث
    //         if ($oldType === $newType) {

    //             if ($newType === 'partner') {
    //                 $member->update([
    //                     'PersonId' => $data['PersonId'],
    //                     'FName' => $data['FName'],
    //                     'SName' => $data['SName'],
    //                     'TName' => $data['TName'],
    //                     'LName' => $data['LName'],
    //                     'relationship' => $data['relation'],
    //                     'health_Status' => $data['health_status'],
    //                     'birthdate' => $data['BirthDate'],
    //                     'desc_health_status' => $data['desc_health_status'],
    //                 ]);
    //             } else {
    //                 $member->update([
    //                     'PersonId' => $data['PersonId'],
    //                     'FName' => $data['FName'],
    //                     'SName' => $data['SName'],
    //                     'TName' => $data['TName'],
    //                     'LName' => $data['LName'],
    //                     'Kinship' => $data['relation'],
    //                     'health_Status' => $data['health_status'],
    //                     'BirthDate' => $data['BirthDate'],
    //                     'Gender' => $gender,
    //                     'desc_health_status' => $data['desc_health_status'],

    //                 ]);
    //             }
    //         }
    //         // 🔁 تغيير الجدول
    //         else {

    //             $member->delete();

    //             if ($newType === 'partner') {
    //                 partner::create([
    //                     'PersonId' => $data['PersonId'],
    //                     'householdId' => $householdId->PersonId,
    //                     'FName' => $data['FName'],
    //                     'SName' => $data['SName'],
    //                     'TName' => $data['TName'],
    //                     'LName' => $data['LName'],
    //                     'relationship' => $data['relation'],
    //                     'health_Status' => $data['health_status'],
    //                     'birthdate' => $data['BirthDate'],
    //                     'desc_health_status' => $data['desc_health_status'],

    //                 ]);
    //             } else {
    //                 head_children::create([
    //                     'PersonId' => $data['PersonId'],
    //                     'householdId' => $householdId->PersonId,
    //                     'FName' => $data['FName'],
    //                     'SName' => $data['SName'],
    //                     'TName' => $data['TName'],
    //                     'LName' => $data['LName'],
    //                     'Kinship' => $data['relation'],
    //                     'health_Status' => $data['health_status'],
    //                     'BirthDate' => $data['BirthDate'],
    //                     'Gender' => $gender,
    //                     'desc_health_status' => $data['desc_health_status'],

    //                 ]);
    //             }
    //         }
    //     });

    //     return redirect()->back()->with('message', 'تم تعديل البيانات بنجاح');
    // }




    public function destroy(Request $request, $id)
    {
        $id = Crypt::decrypt($id);

        if ($request->type === 'partner') {
            partner::findOrFail($id)->delete();
        } elseif ($request->type === 'child') {
            head_children::findOrFail($id)->delete();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'نوع غير معروف'
            ], 400);
        }

        return response()->json(['success' => true]);
    }
}
