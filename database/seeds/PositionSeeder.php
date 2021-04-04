<?php

use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kindOfSalarys')->insert([
            ['type' => 'thường', 'coeficient' => '1', 'salary' => '10000', 'note'=>'1'],
            ['type' => 'bán thời gian', 'coeficient' => '1', 'salary' => '10000', 'note'=>'1'],
            ['type' => 'bán thời gian', 'coeficient' => '1', 'salary' => '10000', 'note'=>'2']
         ]);
         
         DB::table('specificSalarys')->insert([
            ['userID' => '1', 'kindOfSalaryID'=>'1'],
            ['userID' => '2', 'kindOfSalaryID'=>'2'],
            ['userID' => '3', 'kindOfSalaryID'=>'3']
        ]);

         DB::table('salarys')->insert([
            ['specificSalaryID' => '1', 'totalDate' => '10', 'bonus' => '0', 'deduction'=>'0','month'=>'3','year'=>'2021', 'total' => '100000', 'note'=>''],
            ['specificSalaryID' => '2', 'totalDate' => '20', 'bonus' => '0', 'deduction'=>'0','month'=>'2','year'=>'2021', 'total' => '200000', 'note'=>''],
            ['specificSalaryID' => '3', 'totalDate' => '70', 'bonus' => '0', 'deduction'=>'0','month'=>'1','year'=>'2021', 'total' => '700000', 'note'=>'']
         ]);
    }
}