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

        // Ambil Roles
        $roles = DB::table('roles')->pluck('id', 'slug');
        // Ambil Divisions
        $divisions = DB::table('divisions')->pluck('id', 'slug');

        // 1. Super Admin
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Admin GPL',
            'email' => 'admin@gplyuk.com',
            'password' => $password,
            'phone_number' => '081234567890',
            'role_id' => $roles['admin'],
            'division_id' => null,
            'position' => 'Super Administrator',
            'is_active' => true,
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Ketua Umum
        $ketuaId = DB::table('users')->insertGetId([
            'name' => 'Ketua Umum GPL',
            'email' => 'ketua@gplyuk.com',
            'password' => $password,
            'phone_number' => '081234567891',
            'role_id' => $roles['ketua'],
            'division_id' => null,
            'position' => 'Ketua Umum',
            'is_active' => true,
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3. Sekretaris
        $sekretarisId = DB::table('users')->insertGetId([
            'name' => 'Sekretaris GPL',
            'email' => 'sekretaris@gplyuk.com',
            'password' => $password,
            'phone_number' => '081234567892',
            'role_id' => $roles['sekretaris'],
            'division_id' => null,
            'position' => 'Sekretaris',
            'is_active' => true,
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 4. Bendahara
        $bendaharaId = DB::table('users')->insertGetId([
            'name' => 'Bendahara GPL',
            'email' => 'bendahara@gplyuk.com',
            'password' => $password,
            'phone_number' => '081234567893',
            'role_id' => $roles['bendahara'],
            'division_id' => null,
            'position' => 'Bendahara',
            'is_active' => true,
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 5. Hubungkan Manager ke Divisi yang dibawahi
        // Sekretaris membawahi Divisi Acara dan Divisi Humas
        DB::table('divisions')->whereIn('slug', ['acara', 'humas'])->update([
            'manager_id' => $sekretarisId,
            'updated_at' => $now,
        ]);

        // Bendahara membawahi Divisi Logistik
        DB::table('divisions')->where('slug', 'logistik')->update([
            'manager_id' => $bendaharaId,
            'updated_at' => $now,
        ]);

        // Ketua membawahi Divisi Operasional
        DB::table('divisions')->where('slug', 'operasional')->update([
            'manager_id' => $ketuaId,
            'updated_at' => $now,
        ]);

        // 6. Sample Volunteer (tergabung di Divisi Acara)
        DB::table('users')->insertGetId([
            'name' => 'Volunteer Fulan',
            'email' => 'volunteer@gplyuk.com',
            'password' => $password,
            'phone_number' => '089876543210',
            'role_id' => $roles['volunteer'],
            'division_id' => $divisions['acara'] ?? null,
            'position' => 'Anggota Divisi Acara',
            'is_active' => true,
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 7. Sample Pending User (Pendaftar baru belum di-approve)
        DB::table('users')->insertGetId([
            'name' => 'Calon Relawan',
            'email' => 'pending@gplyuk.com',
            'password' => $password,
            'phone_number' => '089912345678',
            'role_id' => $roles['pending'],
            'division_id' => null,
            'position' => null,
            'is_active' => true,
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
