<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (config('app.env') === 'local') {
            User::create([
                'name' => 'Admin Wolu',
                'username' => 'pamungkas',
                'role_id' => User::ADMIN,
                'password' => bcrypt('admin'),
            ]);
        }
    }
}
