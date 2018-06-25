<?php

use Illuminate\Database\Seeder;
use App\ClubUser;

class ClubUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClubUser::truncate();     
    }
}
