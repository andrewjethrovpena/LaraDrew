<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
   	 	User::truncate();
 
    	$usersQuantity = 1;
     
     	factory(User::class, $usersQuantity)->create();
    }
}
