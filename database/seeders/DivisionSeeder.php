<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $divisions = [
            ['name' => 'Divisi Acara', 'slug' => 'acara'],
            ['name' => 'Divisi Logistik', 'slug' => 'logistik'],
            ['name' => 'Divisi Operasional & DPI', 'slug' => 'operasional'],
            ['name' => 'Divisi Humas & Publikasi', 'slug' => 'humas'],
        ];

        foreach ($divisions as $division) {
            DB::table('divisions')->updateOrInsert(
                ['slug' => $division['slug']],
                [
                    'name' => $division['name'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}

