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
        DB::table('positions')->insert([
            ['name' => 'admin'],
            ['name' => 'manager'],
            ['name' => 'user'],
            ['name' => 'staff']
         ]);
         DB::table('users')->insert([
            ['name' => 'Võ Văn Nhã','email' => 'nhavo14@gmail.com','phone' => '0905903902', 'password'=>'123', 'positionID' => '1'],
            ['name' => 'Trần Văn Quý','email' => 'quytran@gmail.com','phone' => '0905903902', 'password'=>'123', 'positionID' => '1'],
            ['name' => 'Nguyễn Văn Tuyên','email' => 'tuyen1@gmail.com','phone' => '0905903902', 'password'=>'123', 'positionID' => '2']
         ]);
         DB::table('contacts')->insert([
            ['userID' => '1', 'mess' => 'Oke la', 'time' => '2020-11-26 10:44:52'],
            ['userID' => '1', 'mess' => 'Oke ngon', 'time' => '2020-11-26 10:44:52']
         ]);
         DB::table('kindOfFoods')->insert([
            ['name' => 'food', 'detail' => '', 'img' => ''],
            ['name' => 'drink', 'detail' => '', 'img' => ''],
            ['name' => 'other', 'detail' => '', 'img' => '']
         ]);
         DB::table('foods')->insert([
            ['foodName' => 'Bánh xèo','img' => 'food1.jpg', 'price'=>'200000', 'rating'=>'4.9', 'hits'=>'5', 'ingres' =>'Cá, thịt' , 'parentID'=>'1' ],
            ['foodName' => 'Bánh Canh','img' => 'food2.jpg', 'price'=>'300000', 'rating'=>'4.9', 'hits'=>'5', 'ingres' => 'Giá, thịt' , 'parentID'=>'1'  ]
         ]);
         DB::table('comments')->insert([
            ['userID' => '1','userName' => 'Võ Văn Nhã','mess'=>'Món này thì ngon', 'time' => '2020-11-26 10:44:52', 'foodID'=>'1' ],
            ['userID' => '2','userName' => 'Trần Văn Quý','mess'=>'Món này cũng được', 'time' => '2020-11-26 10:44:52', 'foodID'=>'1' ]
         ]);
         DB::table('orderTables')->insert([
            ['userID' => '1','total' => '2000000', 'orderDate'=>'2020-11-26 10:44:52', 'perNum'=>'4,5', 'dateClick'=>'2020-11-26 10:44:52' ],
            ['userID' => '2','total' => '6000000', 'orderDate'=>'2020-11-26 10:44:52', 'perNum'=>'4,5', 'dateClick'=>'2020-11-26 10:44:52' ],
         ]);
         DB::table('orderDetails')->insert([
            ['orderID' => '1','foodID' => '1', 'qty'=>'1', 'price' => '200000'],
            ['orderID' => '2','foodID' => '2', 'qty'=>'2', 'price' => '300000'],
            ['orderID' => '1','foodID' => '1', 'qty'=>'1', 'price' => '200000']
         ]);
    }
}
