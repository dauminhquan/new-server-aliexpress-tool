<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(strlen($row[2]) < 4)
        {
            dd('Mat khau phai it nhat co 4 ky tu');
        }
        return new User([
            'name' => $row[0],
            'email' => $row[1],
            'password' => Hash::make($row[2]),
            'type' => $row[3]
        ]);
    }
}
