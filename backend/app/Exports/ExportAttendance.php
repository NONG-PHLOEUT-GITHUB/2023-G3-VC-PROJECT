<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class ExportAttendance implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Status',
            'Reason',
        ];
    }

    public function collection()
    {
        return Attendance::whereIn('user_id', $this->userId)->get();
    }

    public function map($attendance): array
    {
        return [
            $attendance->created_at,
            $attendance->status,
            $attendance->reason,
        ];
    }
}
