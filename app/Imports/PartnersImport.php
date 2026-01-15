<?php

namespace App\Imports;

use App\Models\partner;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PartnersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // \dd($row);
        return partner::updateOrCreate(
            [
                'PersonId' => isset($row['hoy_alshkhs']) ? (string) trim($row['hoy_alshkhs']) : null,
                'FName' => $row['alasm_alaol'] ?? null,
                'SName' => $row['asm_alab'] ?? null,
                'TName' => $row['asm_algd'] ?? null,
                'LName' => $row['allkb'] ?? null,
                'birthdate' => $this->parseDate($row['tarykh_almylad'] ?? null),
                'health_Status' => $row['alhal_alshy'] ?? null,
                'relationship' => $row['alaalak'] ?? null
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
            '*.تاريخ الميلاد' => ['nullable', 'date'],
            '*.العلاقة' => ['nullable', 'string'],
            '*.الحالة الصحية' => ['nullable', 'string'],
        ];
    }
}
