<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => "Plomería", 'parent_id' => null, "created_at" => now(), "updated_at" => now()], 
            ['name' => "Electricidad", 'parent_id' => null, "created_at" => now(), "updated_at" => now()],
            
            
            ['name' => "Tubos PVC", 'parent_id' => 1, "created_at" => now(), "updated_at" => now()], 
            ['name' => "Grifería para Lavamanos", 'parent_id' => 1, "created_at" => now(), "updated_at" => now()],


            ['name' => "Multitomas y Extensiones Electricas", 'parent_id' => 2, "created_at" => now(), "updated_at" => now()], 
        ]);
    }
}
