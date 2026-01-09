<?php

namespace App\Imports;

use App\Models\household;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class HouseholdsImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return household::updateOrCreate(
            [
                'PersonId' => isset($row['aamod1']) ? (string) trim($row['aamod1']) : null,
                'FName' => $row['alasm_alaol'] ?? null,
                'SName' => $row['asm_alab'] ?? null,
                'TName' => $row['asm_algd'] ?? null,
                'LName' => $row['allkb'] ?? null,
                'BirthDate' => $this->parseDate($row['tarykh_almylad'] ?? null),
                'Gender' => $row['algns'] ?? null,
                'Phone_Number' => $row['alhatf'] ?? null,
                'legal_confirmation' => isset($row['takyd_kanony']) ? (int)$row['takyd_kanony'] : 0,
                'num_Family_Members' => $row['aadd_afrad_alasr'] ?? null,
                'status' => $row['alhal'] ?? null,
                'health_Status' => $row['alhal_alshy'] ?? null,
                'Sources_income' => $row['msadr_aldkhl'] ?? null,
                'address' => $row['alaanoan'] ?? null,
                'Notes' => $row['mlahthat'] ?? null,
                'cityId' => $row['almdyn'] ?? null,
                'location_id' => $row['almokaa'] ?? null,
                'governorate_id' => $row['almhafth'] ?? null,
                'Date_partner_martyrdom' => $this->parseDate($row['tarykh_astshhad_alzogalshryk'] ?? null),
            ]
        );
    }

    /**
     * تحويل التاريخ من Excel إلى Date
     */
    private function parseDate($value)
    {
        if (!$value) {
            return null;
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Validation على مستوى الصف
     */
    public function rules(): array
    {
        return [
            '*.هوية الشخص' => ['required', 'numeric'],
            '*.الاسم الأول' => ['required', 'regex:/^[\p{L}\s]+$/u'],
            '*.اسم الأب' => ['nullable', 'regex:/^[\p{L}\s]+$/u'],
            '*.اسم الجد' => ['nullable', 'regex:/^[\p{L}\s]+$/u'],
            '*.اللقب' => ['nullable', 'regex:/^[\p{L}\s]+$/u'],
            '*.تاريخ الميلاد' => ['nullable', 'date'],
            '*.الجنس' => ['nullable', 'string'],
            '*.الهاتف' => ['nullable', 'string'],
            '*.تأكيد قانوني' => ['nullable', 'string'],
            '*.عدد أفراد الأسرة' => ['nullable', 'numeric'],
            '*.الحالة' => ['nullable', 'string'],
            '*.الحالة الصحية' => ['nullable', 'string'],
            '*.مصادر الدخل' => ['nullable', 'string'],
            '*.العنوان' => ['nullable', 'string'],
            '*.ملاحظات' => ['nullable', 'string'],
            '*.تاريخ استشهاد الزوج/الشريك' => ['nullable', 'date'],
            '*.المدينة' => ['nullable', 'string'],
            '*.الموقع' => ['nullable', 'string'],
            '*.المحافظة' => ['nullable', 'string'],
        ];
    }
}
