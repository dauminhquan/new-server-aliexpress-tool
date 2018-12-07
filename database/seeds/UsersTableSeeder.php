<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'dauminhquantlu@gmail.com',
                'password' => Hash::make('minhquan25'),
                'type' => 0
            ],
            [
                'name' => 'Nguyen Tien Ngoc',
                'email' => 'tienngoc.09h5@gmail.com',
                'password' => Hash::make('nguyentienngoc'),
                'type' => 1
            ],
            [
                'name' => 'Vo Trong An',
                'email' => 'votrongan65@gmail.com',
                'password' => Hash::make('votrongan'),
                'type' => 1
            ],
            [
                'name' => 'Pham Trong Duy',
                'email' => 'phamtrongduy@gmail.com',
                'password' => Hash::make('phamtrongduy'),
                'type' => 1
            ]
        ]);
    }
}
