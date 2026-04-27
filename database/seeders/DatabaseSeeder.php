<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        $users = [
            [
                'name'      => 'diknas',
                'email'     => 'diknas@dataprint.com',
                'password'  => 'diknas123',
                'role'      => 'user',
            ],
            [
                'name'      => 'admin',
                'email'     => 'admin@dataprint.com',
                'password'  => 'admin123',
                'role'      => 'admin',
            ],
            [
                'name'      => 'finance',
                'email'     => 'finance@dataprint.com',
                'password'  => 'finance123',
                'role'      => 'finance',
            ],
            [
                'name'      => 'teknisi',
                'email'     => 'teknisi@dataprint.com',
                'password'  => 'teknisi123',
                'role'      => 'teknisi',
            ],
        ];

        foreach($users as $data) {
            $user = \App\Models\User::updateOrCreate(
                ['email'        => $data['email']],
                [
                    'name'      => $data['name'],
                    'password'  => Hash::make($data['password']),
                ]
            );
            $user->assignRole([$data['role']]);
        }
    }
}
