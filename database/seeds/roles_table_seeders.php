<?php

use Illuminate\Database\Seeder;
use App\Roles;

class roles_table_seeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Roles::insert([
        		['name'=>'Admin'],
        		['name'=>'Receiptionist'],
        		['name'=>'Manager'],
        		['name'=>'CEO']

        ]);
    }
}
