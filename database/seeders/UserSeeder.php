<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //masuk data ke tabel users
        $userData=[
            ['nama'=>'Admin',
            'alamat'=>'Jl. Admin No. 1',
            'telepon'=>'08123456789',
            'email'=>'admin@example.com',
            'nim_nip'=>'123456789',
            'password'=>Hash::make('admin123'),
            'jenis'=>'admin'
        ],
            ['nama'=>'Member',
            'alamat'=>'Jl. Member No. 1',
            'telepon'=>'08123456789',
            'email'=>'member@example.com',
            'nim_nip'=>'987654321',
            'password'=>Hash::make('member123'),
            'jenis'=>'member'
            ]
        ];

        foreach ($userData as $key=>$val) {
            User::create($val);
        }
    }
}
