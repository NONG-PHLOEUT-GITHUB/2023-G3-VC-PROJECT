<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'first_name' => $row['First Name'],
            'last_name'=> $row['Last Name'],
            'email'=> $row['Email'],
            'gender'=> $row['gender'],
            'date_of_birth'=> date('Y-m-d H:i:s', strtotime($row['date_of_birth'])),
            'phone_number'=> $row['phone_number'],
            'address'=> $row['address'],
            'role'=>3,
        ]);
    }
}
