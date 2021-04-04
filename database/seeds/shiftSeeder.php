<?php

use Illuminate\Database\Seeder;

class shiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shifts')->insert([
            ['type' => 'full-time 1', 'position'=>'4' ,'checkIn' => '06:00:00', 'checkOut' => '14:00:00', 'note'=>''],
            ['type' => 'full-time 2', 'position'=>'4' , 'checkIn' => '14:00:00', 'checkOut' => '22:00:00', 'note'=>''],
            ['type' => 'part-time 1', 'position'=>'6' , 'checkIn' => '06:00:00', 'checkOut' => '10:00:00', 'note'=>''],
            ['type' => 'part-time 2', 'position'=>'6' , 'checkIn' => '10:00:00', 'checkOut' => '14:00:00', 'note'=>''],
            ['type' => 'part-time 3', 'position'=>'6' , 'checkIn' => '14:00:00', 'checkOut' => '18:00:00', 'note'=>''],
            ['type' => 'part-time 4', 'position'=>'6' , 'checkIn' => '18:00:00', 'checkOut' => '22:00:00', 'note'=>'']
        ]);
         
    }
}