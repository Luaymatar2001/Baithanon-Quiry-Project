<?php

namespace App\Http\Controllers;

use App\Models\MarriageRequest;
use App\Models\household;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MarriageRequestController extends Controller
{
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

        $validated = $request->validate($rules);

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

        return redirect()->back()->with('message', 'تم إرسال طلب الزواج للمراجعة بنجاح');
    }
}
