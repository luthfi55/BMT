<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'name' => 'Luthfi',
                'username' => 'luthfi',
                'email' => 'tes@gmail.com',
                'password' => Hash::make('11111111')
            ],
            [
                'name' => 'Tes',
                'username' => 'tess',
                'email' => 'tes1@gmail.com',
                'password' => Hash::make('11111111')
            ],
        ];
        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
