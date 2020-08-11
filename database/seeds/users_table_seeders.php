<?php

use Illuminate\Database\Seeder;
use App\User;

class users_table_seeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        user::create([
        	'name'=>'Vendeth1',
        	'username'=>'vendeth1',
            'role_id'=>1,
            'active'=>1,
        	'email'=>'vendeth1@gmail.com',
        	'password'=>bcrypt('123@abc'),
        	'remember_token'=>str_random(10),
        ]);
        user::create([
            'name'=>'vendeth2',
            'username'=>'vendeth2',
            'role_id'=>2,
            'active'=>1,
            'email'=>'vendeth2@gmail.com',
            'password'=>bcrypt('123@abc'),
            'remember_token'=>str_random(10),
        ]);
         user::create([
            'name'=>'Vendeth3',
            'username'=>'vendeth3',
            'role_id'=>3,
            'active'=>1,
            'email'=>'vendeth3@gmail.com',
            'password'=>bcrypt('123@abc'),
            'remember_token'=>str_random(10),
        ]);
        user::create([
            'name'=>'vendeth4',
            'username'=>'vendeth4',
            'role_id'=>4,
            'active'=>1,
            'email'=>'vendeth4@gmail.com',
            'password'=>bcrypt('123@abc'),
            'remember_token'=>str_random(10),
        ]);
        
    }
}
