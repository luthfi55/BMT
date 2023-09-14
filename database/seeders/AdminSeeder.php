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
                'name' => 'Admin',
                'username' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123')
            ],
            [
                'name' => 'Admin2',
                'username' => 'Admin2',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('admin123')
            ],
        ];
        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
