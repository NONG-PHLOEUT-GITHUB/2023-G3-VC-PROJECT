<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportUsers implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = new User([
            'first_name'=> $row['first_name'],
            // 'last_name'=> $row['last_name'],
            // 'email'=> $row['email'],
            // 'gender'=> $row['gender'],
            // 'role'=> 3,
        ]);
        $user->save();
    }
}
