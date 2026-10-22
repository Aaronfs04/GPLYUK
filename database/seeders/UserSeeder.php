<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password123');
        $now = Carbon::now();

        // 1 Admin
        DB::table('users')->insert([
            'name' => 'Admin GPL',
            'email' => 'admin@gplyuk.com',
            'password' => $password,
            'phone_number' => '081234567890',
            'role' => 'admin',
            'position' => null,
            'is_active' => true,
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3 Manager (dengan jabatan DPI)
        $managers = [
            ['name' => 'Manager Operasional', 'email' => 'manager1@gplyuk.com', 'position' => 'Ketua DPI'],
            ['name' => 'Manager Acara', 'email' => 'manager2@gplyuk.com', 'position' => 'Koordinator Acara'],
            ['name' => 'Manager Logistik', 'email' => 'manager3@gplyuk.com', 'position' => 'Koordinator Logistik'],
        ];

        foreach ($managers as $i => $mgr) {
            DB::table('users')->insert([
                'name' => $mgr['name'],
                'email' => $mgr['email'],
                'password' => $password,
                'phone_number' => '08123456789' . ($i + 1),
                'role' => 'manager',
                'position' => $mgr['position'],
                'is_active' => true,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Sampel Volunteer
        DB::table('users')->insert([
            'name' => 'Volunteer Fulan',
            'email' => 'volunteer@gplyuk.com',
            'password' => $password,
            'phone_number' => '089876543210',
            'role' => 'volunteer',
            'position' => null,
            'is_active' => true,
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}