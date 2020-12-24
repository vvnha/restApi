<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('positions')->insert([
            ['name' => 'block']
        ]);
    }
}
