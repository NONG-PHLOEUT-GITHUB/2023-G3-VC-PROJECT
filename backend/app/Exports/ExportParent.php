<?php

namespace App\Exports;
use App\Models\Guardian;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportParent implements FromCollection , ShouldAutoSize, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Guardian::select(
            'first_name',
            'last_name',
            'gender',
            // 'age',
            'date_of_birth',
            'phone_number',
            'address',
            // 'email',
        )->get();
    }

     /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Gender',
            'Date of Birth',
            'Phone Number',
            'Address',
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:F1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray([
                    'font' => [
                        'size' => 14,
                        'color' => ['rgb' => 'FFFFFF'], // White color for text
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '007bff'], // Blue color for background
                    ],
                ]);
            },
        ];
    }
}
