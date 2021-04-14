<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */ 
    public function run()
    {
        DB::table('products')->insert([
            ['name' => 'Tubo Sanitario 4 x 6 Mts.', 'sku' => "REF001", 'description' => "Tubo Sanitario 4 Pulgadas", 'image' => "/products/tubo_pvc.jpg", 'stock' => 50, 'price' => 20000, 'category_id' => 3, "created_at" => now(), "updated_at" => now()], 
            ['name' => 'Grifería Lavamanos Monocontrol', 'sku' => "REF002", 'description' => "Grifería de lavamanos monocontrol que permite la mezcla de agua fría y caliente, ideal para la renovación de tu espacio. Manilla de rango de giro 90° para mezcla de temperaturas de agua.", 'image' => "/products/griferia.jpg", 'stock' => 15, 'price' => 50000, 'category_id' => 4, "created_at" => now(), "updated_at" => now()], 
            ['name' => 'Adaptador de 3 a 2 patas redondas', 'sku' => "REF003", 'description' => "Permite conectar diferentes dispositivos a una toma especial de dos patas redondas", 'image' => "/products/adaptador.jpg", 'stock' => 35, 'price' => 12000, 'category_id' => 5, "created_at" => now(), "updated_at" => now()], 
        ]);
    }
}
