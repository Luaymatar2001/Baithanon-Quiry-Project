<?php

namespace App\Http\Controllers;

use App\Models\MarriageRequest;
use App\Models\household;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarriageRequestController extends Controller
{

    public function messageError()
    {

        $messages = [
            // ========== بيانات الزوج ==========
            // الاسم الأول للزوج
            'FName_h.required' => 'الاسم الأول للزوج مطلوب',
            'FName_h.string'   => 'الاسم الأول للزوج يجب أن يكون نصاً',
            'FName_h.max'      => 'الاسم الأول للزوج يجب ألا يتجاوز 255 حرفاً',

            // اسم الأب للزوج
            'SName_h.string' => 'اسم الأب للزوج يجب أن يكون نصاً',
            'SName_h.max'    => 'اسم الأب للزوج يجب ألا يتجاوز 255 حرفاً',

            // اسم الجد للزوج
            'TName_h.string' => 'اسم الجد للزوج يجب أن يكون نصاً',
            'TName_h.max'    => 'اسم الجد للزوج يجب ألا يتجاوز 255 حرفاً',

            // اسم العائلة للزوج
            'LName_h.string' => 'اسم العائلة للزوج يجب أن يكون نصاً',
            'LName_h.max'    => 'اسم العائلة للزوج يجب ألا يتجاوز 255 حرفاً',

            // رقم هوية رب الأسرة
            'IdNumHouseHold_h.required' => 'رقم هوية رب الأسرة مطلوب',
            'IdNumHouseHold_h.string'   => 'رقم هوية رب الأسرة يجب أن يكون نصاً',
            'IdNumHouseHold_h.max'      => 'رقم هوية رب الأسرة يجب ألا يتجاوز 255 حرفاً',

            // تاريخ ميلاد الزوج
            'BirthDate_h.required' => 'تاريخ ميلاد الزوج مطلوب',
            'BirthDate_h.date'     => 'صيغة تاريخ ميلاد الزوج غير صحيحة',
            'BirthDate_h.before'   => 'تاريخ ميلاد الزوج يجب أن يكون قبل اليوم',

            // رقم جوال الزوج
            'MobailNumber_h.required' => 'رقم جوال الزوج مطلوب',
            'MobailNumber_h.string'   => 'رقم جوال الزوج يجب أن يكون نصاً',
            'MobailNumber_h.max'      => 'رقم جوال الزوج يجب ألا يتجاوز 255 حرفاً',

            // صورة الهوية الوطنية للزوج
            'husband_national_id.required' => 'صورة الهوية الوطنية للزوج مطلوبة',
            'husband_national_id.image'    => 'يجب أن يكون ملف صورة الهوية الوطنية للزوج من نوع صورة',
            'husband_national_id.mimes'    => 'صيغ الصور المسموحة للهوية الوطنية للزوج: jpg، jpeg، png، webp',
            'husband_national_id.max'      => 'حجم صورة الهوية الوطنية للزوج يجب ألا يتجاوز 4 ميجابايت',

            // ========== بيانات الزوجة ==========
            // الاسم الأول للزوجة
            'FName_w.required' => 'الاسم الأول للزوجة مطلوب',
            'FName_w.string'   => 'الاسم الأول للزوجة يجب أن يكون نصاً',
            'FName_w.max'      => 'الاسم الأول للزوجة يجب ألا يتجاوز 255 حرفاً',

            // اسم الأب للزوجة
            'SName_w.string' => 'اسم الأب للزوجة يجب أن يكون نصاً',
            'SName_w.max'    => 'اسم الأب للزوجة يجب ألا يتجاوز 255 حرفاً',

            // اسم الجد للزوجة
            'TName_w.string' => 'اسم الجد للزوجة يجب أن يكون نصاً',
            'TName_w.max'    => 'اسم الجد للزوجة يجب ألا يتجاوز 255 حرفاً',

            // اسم العائلة للزوجة
            'LName_w.string' => 'اسم العائلة للزوجة يجب أن يكون نصاً',
            'LName_w.max'    => 'اسم العائلة للزوجة يجب ألا يتجاوز 255 حرفاً',

            // رقم هوية الزوجة
            'IdNumWifeId.required' => 'رقم هوية الزوجة مطلوب',
            'IdNumWifeId.string'   => 'رقم هوية الزوجة يجب أن يكون نصاً',
            'IdNumWifeId.max'      => 'رقم هوية الزوجة يجب ألا يتجاوز 255 حرفاً',

            // تاريخ ميلاد الزوجة
            'BirthDate_w.required' => 'تاريخ ميلاد الزوجة مطلوب',
            'BirthDate_w.date'     => 'صيغة تاريخ ميلاد الزوجة غير صحيحة',
            'BirthDate_w.before'   => 'تاريخ ميلاد الزوجة يجب أن يكون قبل اليوم',

            // صورة الهوية الوطنية للزوجة
            'wife_national_id.required' => 'صورة الهوية الوطنية للزوجة مطلوبة',
            'wife_national_id.image'    => 'يجب أن يكون ملف صورة الهوية الوطنية للزوجة من نوع صورة',
            'wife_national_id.mimes'    => 'صيغ الصور المسموحة للهوية الوطنية للزوجة: jpg، jpeg، png، webp',
            'wife_national_id.max'      => 'حجم صورة الهوية الوطنية للزوجة يجب ألا يتجاوز 4 ميجابايت',
        ];
        return $messages;
    }
    public function store(Request $request)
    {
        // حماية الجلسة
        $householdId = session('household_verified');
        if (!$householdId) {
            return response()->json([
                'message' => 'غير مصرح لك'
            ], 403);
        }

        // Validate base data
        $rules = [
            // Husband data
            'FName_h' => 'required|string|max:255',
            'SName_h' => 'nullable|string|max:255',
            'TName_h' => 'nullable|string|max:255',
            'LName_h' => 'nullable|string|max:255',
            'IdNumHouseHold_h' => 'required|string|max:255',
            'BirthDate_h' => 'required|date|before:today',
            'MobailNumber_h' => 'required|string|max:255',
            'husband_national_id' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',

            // Wife data
            'FName_w' => 'required|string|max:255',
            'SName_w' => 'nullable|string|max:255',
            'TName_w' => 'nullable|string|max:255',
            'LName_w' => 'nullable|string|max:255',
            'IdNumWifeId' => 'required|string|max:255',
            'BirthDate_w' => 'required|date|before:today',
            'wife_national_id' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ];

        $validated = $request->validate($rules, $this->messageError());

        $household = household::query()->findOrFail($householdId);

        $baseDir = public_path('uploads/marriage_requests');
        if (!is_dir($baseDir)) {
            mkdir($baseDir, 0775, true);
        }

        $husbandExt = $request->file('husband_national_id')->getClientOriginalExtension();
        $wifeExt = $request->file('wife_national_id')->getClientOriginalExtension();

        $husbandFileName = time() . '_' . Str::random(20) . '.' . $husbandExt;
        $wifeFileName = time() . '_' . Str::random(20) . '.' . $wifeExt;

        $request->file('husband_national_id')->move($baseDir, $husbandFileName);
        $request->file('wife_national_id')->move($baseDir, $wifeFileName);

        MarriageRequest::create([
            'household_id' => $household->PersonId,

            'FName_h' => $validated['FName_h'],
            'SName_h' => $validated['SName_h'] ?? null,
            'TName_h' => $validated['TName_h'] ?? null,
            'LName_h' => $validated['LName_h'] ?? null,
            'IdNumHouseHold_h' => $validated['IdNumHouseHold_h'],
            'BirthDate_h' => $validated['BirthDate_h'],
            'MobailNumber_h' => $validated['MobailNumber_h'],

            'FName_w' => $validated['FName_w'],
            'SName_w' => $validated['SName_w'] ?? null,
            'TName_w' => $validated['TName_w'] ?? null,
            'LName_w' => $validated['LName_w'] ?? null,
            'IdNumWifeId' => $validated['IdNumWifeId'],
            'BirthDate_w' => $validated['BirthDate_w'],

            'husband_national_id_image' => $husbandFileName,
            'wife_national_id_image' => $wifeFileName,
        ]);

        return redirect()->back()->with('message', 'تم إرسال طلب تسجيل زواج جديد للمراجعة');
    }
}
