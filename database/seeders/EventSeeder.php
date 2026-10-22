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
        // Ambil ID admin yang dibuat di UserSeeder
        $admin = DB::table('users')->where('role', 'admin')->first();
        $adminId = $admin ? $admin->id : 1;
        $now = Carbon::now();

        DB::table('events')->insert([
            'title' => 'Aksi Bersih Pantai & Taman Kota',
            'slug' => Str::slug('Aksi Bersih Pantai & Taman Kota'),
            'description' => 'Kegiatan gotong royong memilah sampah dan penghijauan ruang terbuka publik.',
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
    }
}