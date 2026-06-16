<?php

namespace App\Imports;

use App\Models\city;
use App\Models\governorates;
use App\Models\head_children;
use App\Models\household;
use App\Models\location;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\WithValidation;

class ChildrensImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return head_children::updateOrCreate(
            [
                'PersonId' => isset($row['hoy_alshkhs'])
                    ? (string) trim($row['hoy_alshkhs'])
                    : null,
            ],
            [
                'FName'         => $row['alasm_alaol'] ?? null,
                'SName'         => $row['asm_alab'] ?? null,
                'TName'         => $row['asm_algd'] ?? null,
                'LName'         => $row['allkb'] ?? null,
                'BirthDate'     => $this->parseDate($row['tarykh_almylad'] ?? null),
                'Gender'        => $row['algns'] ?? null,
                'health_Status' => $row['alhal_alshy'] ?? null,
                'householdId'   => $row['hoy_rb_alasr'] ?? null,
                'relationship'  => $row['alaalak'] ?? null,
            ]
        );
    }

    /**
     * تحويل التاريخ من Excel إلى Date
     */
   
private function parseDate($value)
{
    if (empty($value)) {
        return null;
    }

    try {
        // 1) Excel numeric date (مثل 44225)
        if (is_numeric($value)) {
            return ExcelDate::excelToDateTimeObject($value)
                ->format('Y-m-d');
        }

        $value = trim($value);

        // 2) dd/mm/yyyy مثل 11/03/2022
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
            return Carbon::createFromFormat('d/m/Y', $value)
                ->format('Y-m-d');
        }

        // 3) fallback
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
            '*.تاريخ الميلاد' => ['nullable', 'date'],
            '*.الجنس' => ['nullable', 'string'],
            '*.هوية رب الأسرة' => ['required', 'numeric', 'exists:heads_households,PersonId'],
            '*.العلاقة' => ['nullable', 'string'],
            '*.الحالة الصحية' => ['nullable', 'string'],

        ];
    }
}
 // \dd($row);