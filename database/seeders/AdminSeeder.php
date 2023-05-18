<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert(
        [
            'name' => 'CapinAds Admin',
            'username' => 'capinadmin',
            'email' => 'admin@capinads.com',
            'password' => \Hash::make('cap@1122'),
            'user_type' => 'admin'
        ]
     );
    }
}
