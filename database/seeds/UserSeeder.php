<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
      //   DB::table('positions')->insert([
      //       ['name' => 'admin'],
      //       ['name' => 'manager'],
      //       ['name' => 'user'],
      //       ['name' => 'staff']
      //    ]);
      //    DB::table('users')->insert([
      //       ['name' => 'Võ Văn Nhã','email' => 'nhavo14@gmail.com','phone' => '0905903902', 'password'=>'$2y$10$iNvCL3cT.jJAomB5a.8eEOFsfxU1eeKPNpH3eWdxd83C.AJRCFys.', 'positionID' => '1'],
      //       ['name' => 'Trần Văn Quý','email' => 'vanquy@gmail.com','phone' => '0905906666', 'password'=>'$2y$10$iNvCL3cT.jJAomB5a.8eEOFsfxU1eeKPNpH3eWdxd83C.AJRCFys.', 'positionID' => '1'],
      //       ['name' => 'Nguyễn Văn Tuyên','email' => 'tuyen1@gmail.com','phone' => '0905903902', 'password'=>'$2y$10$iNvCL3cT.jJAomB5a.8eEOFsfxU1eeKPNpH3eWdxd83C.AJRCFys.', 'positionID' => '2']
      //    ]);
      //    DB::table('contacts')->insert([
      //       ['userID' => '1', 'mess' => 'Oke la', 'time' => '2020-11-26 10:44:52'],
      //       ['userID' => '1', 'mess' => 'Oke ngon', 'time' => '2020-11-26 10:44:52']
      //    ]);
      //    DB::table('kindOfFoods')->insert([
      //       ['name' => 'food', 'detail' => '', 'img' => ''],
      //       ['name' => 'drink', 'detail' => '', 'img' => ''],
      //       ['name' => 'other', 'detail' => '', 'img' => '']
      //    ]);
         // DB::table('foods')->insert([
         //    ['foodName' => 'CoCa','img' => 'food1.jpg', 'price'=>'200000', 'rating'=>'4.9', 'hits'=>'5', 'ingres' =>'Cá, thịt' , 'parentID'=>'2' ],
         //    ['foodName' => 'Thuoc La','img' => 'food2.jpg', 'price'=>'300000', 'rating'=>'4.9', 'hits'=>'5', 'ingres' => 'Giá, thịt' , 'parentID'=>'3'  ]
         // ]);
         // DB::table('comments')->insert([
         //    ['userID' => '1','userName' => 'Võ Văn Nhã','mess'=>'Món này thì ngon', 'time' => '2020-11-26 10:44:52', 'foodID'=>'1' ],
         //    ['userID' => '2','userName' => 'Trần Văn Quý','mess'=>'Món này cũng được', 'time' => '2020-11-26 10:44:52', 'foodID'=>'1' ]
         // ]);
         // DB::table('orderTables')->insert([
         //    ['userID' => '8','total' => '2000000', 'orderDate'=>'2020-11-26 10:44:52', 'perNum'=>'4,5', 'dateClick'=>'2020-11-26 10:44:52' ],
         //    ['userID' => '9','total' => '6000000', 'orderDate'=>'2020-11-26 10:44:52', 'perNum'=>'4,5', 'dateClick'=>'2020-11-26 10:44:52' ],
         // ]);
         DB::table('orderDetails')->insert([
            ['orderID' => '3','foodID' => '1', 'qty'=>'1', 'price' => '200000'],
            ['orderID' => '4','foodID' => '2', 'qty'=>'2', 'price' => '300000'],
            ['orderID' => '3','foodID' => '1', 'qty'=>'1', 'price' => '200000']
         ]);
    }
}
