<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = DB::table('roles')->where('slug', 'admin')->first();
        $admin = DB::table('users')->where('role_id', $adminRole?->id)->first();
        $adminId = $admin ? $admin->id : 1;
        $now = Carbon::now();

        // 1. Event Dummy
        $eventId = DB::table('events')->insertGetId([
            'title' => 'Aksi Bersih Pantai & Taman Kota',
            'slug' => Str::slug('Aksi Bersih Pantai & Taman Kota'),
            'description' => 'Kegiatan gotong royong memilah sampah dan penghijauan ruang terbuka publik bersama komunitas GPL.',
            'location' => 'Taman Balekambang, Solo',
            'location_type' => 'physical',
            'start_at' => $now->copy()->addDays(5)->setTime(8, 0, 0),
            'end_at' => $now->copy()->addDays(5)->setTime(12, 0, 0),
            'quota' => 50,
            'banner_url' => 'banners/event-pantai.jpg',
            'is_featured' => true,
            'status' => 'upcoming',
            'created_by_id' => $adminId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Sample Registrasi & Kehadiran Volunteer
        $volunteerRole = DB::table('roles')->where('slug', 'volunteer')->first();
        $volunteer = DB::table('users')->where('role_id', $volunteerRole?->id)->first();

        if ($volunteer && $eventId) {
            $registrationId = DB::table('event_registrations')->insertGetId([
                'user_id' => $volunteer->id,
                'event_id' => $eventId,
                'status' => 'registered',
                'commitment_agreed' => true,
                'notes' => 'Siap berkontribusi dan membawa kantong sampah sendiri.',
                'created_at' => $now,
            ]);

            DB::table('attendances')->insert([
                'registration_id' => $registrationId,
                'recorded_by_id' => $adminId,
                'check_in_time' => $now->copy()->addDays(5)->setTime(8, 15, 0),
                'created_at' => $now,
            ]);
        }
    }
}
