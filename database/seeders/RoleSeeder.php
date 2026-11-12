<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $roles = [
            ['name' => 'Administrator', 'slug' => 'admin'],
            ['name' => 'Ketua Umum', 'slug' => 'ketua'],
            ['name' => 'Sekretaris', 'slug' => 'sekretaris'],
            ['name' => 'Bendahara', 'slug' => 'bendahara'],
            ['name' => 'Volunteer', 'slug' => 'volunteer'],
            ['name' => 'Pending Approval', 'slug' => 'pending'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['slug' => $role['slug']],
                [
                    'name' => $role['name'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
