<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductTest extends TestCase
{
    public function testProductCreatedSuccessfully()
    {
         

        $headers = ['Accept' => 'application/json']; 

        $first = Category::create([
            "name" => "First Category", 
        ]);

        $second = Category::create([
            "name" => "Second Category", 
            "parent_id" => 1, 
        ]);


        $data = [
            "name" => "Mi producto", 
            "description" => "Descripción de producto", 
            "stock" => 5, 
            "price" => 10000, 
            "category_id" => $second->id, 
            "image" => UploadedFile::fake()->image('product.jpg'), 
        ];

        
        $this->json('POST', '/api/v1/products', $data ,$headers)
            ->assertStatus(201)->assertJson([
                "status" => 201,
                "product" => [
                    "id" => 1,
                    "name" => "Mi producto",
                    "description" => "Descripción de producto", 
                    "sku" => "REF001", 
                    "stock" => 5, 
                    "price" => 10000, 
                    "image" => "/products/1.jpg",
                ],
                "message" => "Product Mi producto created successfully"
            ]);

        $uploaded = public_path('products'.DIRECTORY_SEPARATOR.'1.jpg');
        $this->assertFileExists($uploaded);

        if(\File::exists($uploaded)) {
            \File::delete($uploaded);
        }  
        
    }


}
