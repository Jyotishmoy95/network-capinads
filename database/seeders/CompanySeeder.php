<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Hirarchy;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert into members table
        $member = new Member;
        $member->member_id = 'CSS1001';
        $member->fname = 'John';
        $member->lname = 'Doe';
        $member->full_name = 'John Doe';
        $member->email = 'xxxx@xxx.com';
        $member->mobile = 'xxxxxxxxxx';
        $member->password = \Hash::make('css@1122');
        $member->save();

        // Insert into hirarchies table
        $hirarchy = new Hirarchy;
        $hirarchy->member_id = $member->member_id;
        $hirarchy->sponsor_id = 0;
        $hirarchy->position = 0;
        $hirarchy->activation_amount = 500;
        $hirarchy->activation_time = now();
        $hirarchy->income = 1;
        $hirarchy->save();

    }
}
