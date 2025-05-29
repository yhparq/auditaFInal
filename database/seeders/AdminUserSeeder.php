<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $admins = [
            [
                'name' => 'Dante Quispe',
                'email' => 'danteauditor@gmail.com',
                'password' => '951889712'
            ],
            [
                'name' => 'Benjamín Avendaño',
                'email' => 'benjaminfag6@gmail.com',
                'password' => '951608286'
            ],
            [
                'name' => 'Fany Mamani',
                'email' => 'fanyivon22@gmail.com',
                'password' => '957715605'
            ]
        ];

        foreach ($admins as $admin) {
            User::create($admin);
        }
    }
}