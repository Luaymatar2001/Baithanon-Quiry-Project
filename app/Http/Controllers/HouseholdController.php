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

class HouseholdController extends Controller
{

    public function updateDetails(Request $request)
    {
        // dd("sdfsdf");
        $householdId = session('household_verified');
        if (!$householdId) {
            abort(403, 'Unauthorized');
        }
        $household = household::findOrFail($householdId);
        if (!$householdId) {
            return response()->json([
                'message' => 'غير مصرح لك'
            ], 403);
        }
        $validator = Validator::make(
            $request->all(),
            [
                'address' => 'nullable|string|max:255',
                'city_id' => 'nullable|integer|exists:city,id',
                'status' => 'nullable|string|max:255|in:متزوج,مطلق,مطلقة,أرمل,أرملة,أرملة بعد حرب 2023,أعزب تعدى ال 40 عام',
                'health_status' => 'nullable|string|max:255|in:سليم,مريض,مصاب,متوفي,إعاقة سمعية,إعاقة جسدية,إعاقة عقلية,إعاقة بصرية,حالات حرجة',
                'Sources_income' => 'nullable|string|max:255|in:عاطل,موظف حكومي,موظف خاص,موظف عقود,موظف وكالة',
                'location_id' => 'nullable|integer|exists:locations,id',
                'Phone_Number' => [
                    'nullable',
                    'digits:10',
                    'regex:/^(059|056)\d{7}$/'
                ],
                'governorate_id' => 'nullable|integer|exists:governorates,id',
                'Date_partner_martyrdom' => 'nullable|Date'
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
            ]

        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'popup_update_houseHold')
                ->withInput();
        }

        $validatedData = $validator->validated();

        //    dd($validatedData);
        $household->update([
            'status' => $validatedData['status'] ?? null,
            'health_Status' => $validatedData['health_status'] ?? null,
            'Sources_income' => $validatedData['Sources_income'] ?? null,
            'address' => $validatedData['address'] ?? null,
            'Phone_Number' => $validatedData['Phone_Number'] ?? null,
            'cityId' => $validatedData['city_id'] ?? null,
            'location_id' => $validatedData['location_id'] ?? null,
            'governorate_id' => $validatedData['governorate_id'] ?? null,
            'Date_partner_martyrdom' => $validatedData['Date_partner_martyrdom'] ?? null
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

        $householdId = household::findOrFail($householdId);
        if (!$householdId->legal_confirmation) {
            abort(403, 'Unauthorized - Legal confirmation required');
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'FName' => 'required|string|max:20',
            'SName' => 'required|string|max:20',
            'TName' => 'required|string|max:20',
            'LName' => 'required|string|max:20',
            'PersonId' => ['required', 'digits:9'],
            'relation' => 'required|in:زوجة,ابن,ابنة',
            'health_status' => 'required|in:سليم,مريض,مصاب,إعاقة سمعية,إعاقة جسدية,إعاقة عقلية,إعاقة بصرية,حالات حرجة',
            'BirthDate' => 'required|date|before:today',
        ], [
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
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'popup_member')
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
            ]);
        } elseif (in_array($validated['relation'], ['ابن', 'ابنة'])) {
            head_children::create([
                'PersonId' => $validated['PersonId'],
                'householdId' => $householdId->PersonId,
                'FName' => $validated['FName'],
                'SName' => $validated['SName'],
                'TName' => $validated['TName'],
                'LName' => $validated['LName'],
                'relationship' => $validated['relation'],
                'health_Status' => $validated['health_status'],
                'BirthDate' => $validated['BirthDate'],
                'Gender' => $gender // صححت هنا من $validated => $validated['Gender']
            ]);
        }

        // حفظ
        return redirect()->back()->with('message', 'تم تحديث بيانات الأسرة بنجاح');
    }

    public function updateRowMember(Request $request)
    {
        $householdId = household::findOrFail(session('household_verified'));

        // 1️⃣ Validation
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|integer',
            'member_type' => 'required|in:partner,child',
            'FName' => 'sometimes|string|max:20',
            'SName' => 'sometimes|string|max:20',
            'TName' => 'sometimes|string|max:20',
            'LName' => 'sometimes|string|max:20',
            'PersonId' => ['required', 'digits:9'],
            'relation' => 'required|in:زوجة,ابن,ابنة',
            'health_status' => 'required',
            'BirthDate' => 'required|date|before:today',
        ], [
            'member_id.required' => 'الفرد غير موجود',
            'member_type.required' => 'نوع العضو غير محدد',
            'FName.required' => 'حقل الاسم الأول مطلوب',
            'FName.string' => 'الاسم الأول يجب أن يكون نصاً',
            'FName.max' => 'الاسم الأول يجب ألا يتجاوز 20 حرفاً',
            'PersonId.digits' => 'رقم الهوية يجب أن يتكون من 9 أرقام',
            'relation.required' => 'يرجى اختيار صلة القرابة',
            'health_status.required' => 'يرجى اختيار الحالة الصحية',
            'BirthDate.before' => 'تاريخ الميلاد يجب أن يكون قبل اليوم',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator, 'popup_member')
                ->withInput();
        }

        $data =  $validator->validated();

        // 2️⃣ تحديد النوع الجديد
        $newType = in_array($data['relation'], ['زوج', 'زوجة']) ? 'partner' : 'child';

        // 3️⃣ تحديد النوع القديم من قاعدة البيانات
        if ($partner = partner::find($data['member_id'])) {
            $oldType = 'partner';
            $member = $partner;
        } elseif ($child = head_children::find($data['member_id'])) {
            $oldType = 'child';
            $member = $child;
        } else {
            abort(404);
        }

        // 4️⃣ حساب الجنس
        $gender = in_array($data['relation'], ['زوج', 'ابن']) ? 'ذكر' : 'أنثى';

        // 5️⃣ 🔥 هنا تحط الكود اللي سألت عنه

        DB::transaction(function () use ($oldType, $newType, $member, $data, $householdId, $gender) {

            // 🟢 نفس الجدول → تحديث
            if ($oldType === $newType) {

                if ($newType === 'partner') {
                    $member->update([
                        'PersonId' => $data['PersonId'],
                        'FName' => $data['FName'],
                        'SName' => $data['SName'],
                        'TName' => $data['TName'],
                        'LName' => $data['LName'],
                        'relationship' => $data['relation'],
                        'health_Status' => $data['health_status'],
                        'birthdate' => $data['BirthDate'],
                    ]);
                } else {
                    $member->update([
                        'PersonId' => $data['PersonId'],
                        'FName' => $data['FName'],
                        'SName' => $data['SName'],
                        'TName' => $data['TName'],
                        'LName' => $data['LName'],
                        'Kinship' => $data['relation'],
                        'health_Status' => $data['health_status'],
                        'BirthDate' => $data['BirthDate'],
                        'Gender' => $gender,
                    ]);
                }
            }
            // 🔁 تغيير الجدول
            else {

                $member->delete();

                if ($newType === 'partner') {
                    partner::create([
                        'PersonId' => $data['PersonId'],
                        'householdId' => $householdId->PersonId,
                        'FName' => $data['FName'],
                        'SName' => $data['SName'],
                        'TName' => $data['TName'],
                        'LName' => $data['LName'],
                        'relationship' => $data['relation'],
                        'health_Status' => $data['health_status'],
                        'birthdate' => $data['BirthDate'],
                    ]);
                } else {
                    head_children::create([
                        'PersonId' => $data['PersonId'],
                        'householdId' => $householdId->PersonId,
                        'FName' => $data['FName'],
                        'SName' => $data['SName'],
                        'TName' => $data['TName'],
                        'LName' => $data['LName'],
                        'Kinship' => $data['relation'],
                        'health_Status' => $data['health_status'],
                        'BirthDate' => $data['BirthDate'],
                        'Gender' => $gender,
                    ]);
                }
            }
        });

        return redirect()->back()->with('message', 'تم تعديل البيانات بنجاح');
    }

    // public function updateRowMember(Request $request)
    // {
    //     $householdId = session('household_verified');
    //     if (!$householdId) {
    //         return back()->with('error', 'غير مصرح لك');
    //     }

    //     $validator = Validator::make($request->all(), [
    //         'member_id' => 'required|integer',
    //         'member_type' => 'required|in:partner,child',
    //         'FName' => 'sometimes|string|max:20',
    //         'SName' => 'sometimes|string|max:20',
    //         'TName' => 'sometimes|string|max:20',
    //         'LName' => 'sometimes|string|max:20',
    //         'PersonId' => ['required', 'digits:9'],
    //         'relation' => 'required|in:زوجة,زوج,ابن,ابنة',
    //         'health_status' => 'required',
    //         'BirthDate' => 'required|date|before:today',
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
    //     ]);

    //     if ($validator->fails()) {
    //         return back()->withErrors($validator, 'popup_add_member')->withInput();
    //     }


    //     $data = $validator->validated();

    //     $gender = in_array($data['relation'], ['زوج', 'ابن']) ? 'ذكر' : 'أنثى';

    //     @dd($data['member_type'] );
    //     // تحديد النموذج حسب النوع
    //     // if ($data['member_type'] === 'partner') {
    //     //     $member = partner::findOrFail($data['member_id']);
    //     //     $member->update([
    //     //         'PersonId' => $data['PersonId'],
    //     //         'FName' => $data['FName'],
    //     //         'SName' => $data['SName'],
    //     //         'TName' => $data['TName'],
    //     //         'LName' => $data['LName'],
    //     //         'relationship' => $data['relation'],
    //     //         'health_Status' => $data['health_status'],
    //     //         'birthdate' => $data['BirthDate'],
    //     //     ]);
    //     // } elseif ($data['member_type'] === 'child') {
    //     //     $member = head_children::findOrFail($data['member_id']);
    //     //     $member->update([
    //     //         'PersonId' => $data['PersonId'],
    //     //         'FName' => $data['FName'],
    //     //         'SName' => $data['SName'],
    //     //         'TName' => $data['TName'],
    //     //         'LName' => $data['LName'],
    //     //         'relationship' => $data['relation'],
    //     //         'health_Status' => $data['health_status'],
    //     //         'BirthDate' => $data['BirthDate'],
    //     //         'Gender' => $gender,
    //     //     ]);
    //     // }

    //     // if ($data['member_type'] === 'partner' && in_array($data['relation'], ['زوجة', 'زوج'])) {
    //     //     $member = partner::findOrFail($data['member_id']);
    //     //     $member->update([
    //     //         'PersonId' => $data['PersonId'],
    //     //         'FName' => $data['FName'],
    //     //         'SName' => $data['SName'],
    //     //         'TName' => $data['TName'],
    //     //         'LName' => $data['LName'],
    //     //         'relationship' => $data['relation'],
    //     //         'health_Status' => $data['health_status'],
    //     //         'birthdate' => $data['BirthDate'],
    //     //     ]);
    //     // } elseif ($data['member_type'] === 'child' && in_array($data['relation'], ['ابن', 'ابنة'])) {
    //     //     $member = head_children::findOrFail($data['member_id']);
    //     //     $member->update([
    //     //         'PersonId' => $data['PersonId'],
    //     //         'FName' => $data['FName'],
    //     //         'SName' => $data['SName'],
    //     //         'TName' => $data['TName'],
    //     //         'LName' => $data['LName'],
    //     //         'relationship' => $data['relation'],
    //     //         'health_Status' => $data['health_status'],
    //     //         'BirthDate' => $data['BirthDate'],
    //     //         'Gender' => $gender,
    //     //     ]);
    //     // } else {
    //     //     // تغير النوع بين partner و child
    //     //     // احذف السجل القديم
    //     //     if ($data['member_type'] === 'partner') {
    //     //         partner::findOrFail($data['member_id'])->delete();
    //     //         head_children::create([
    //     //             'PersonId' => $data['PersonId'],
    //     //             'FName' => $data['FName'],
    //     //             'SName' => $data['SName'],
    //     //             'TName' => $data['TName'],
    //     //             'LName' => $data['LName'],
    //     //             'Kinship' => $data['relation'],
    //     //             'health_Status' => $data['health_status'],
    //     //             'BirthDate' => $data['BirthDate'],
    //     //             'Gender' => $gender,
    //     //             'householdId' => $householdId
    //     //         ]);
    //     //     } else {
    //     //         head_children::findOrFail($data['member_id'])->delete();
    //     //         partner::create([
    //     //             'PersonId' => $data['PersonId'],
    //     //             'FName' => $data['FName'],
    //     //             'SName' => $data['SName'],
    //     //             'TName' => $data['TName'],
    //     //             'LName' => $data['LName'],
    //     //             'relationship' => $data['relation'],
    //     //             'health_Status' => $data['health_status'],
    //     //             'birthdate' => $data['BirthDate'],
    //     //             'householdId' => $householdId
    //     //         ]);
    //     //     }
    //     // }

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
