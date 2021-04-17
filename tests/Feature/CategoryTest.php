<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;
use App\Models\Category;


class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCategoryCreatedSuccessfully()
    {
        
        $headers = ['Accept' => 'application/json']; 

        $data = [
            "name" => "Materiales de Construcción", 
        ];

        $this->json('POST', '/api/v1/categories', $data ,$headers)
            ->assertStatus(201)
            ->assertJson([
                "status" => 201,
                "category" => [
                    "id" => 1,
                    "name" => "Materiales de Construcción",
                    "active" => true,
                ],
                "message" => "Category Materiales de Construcción cretated successfully"
            ]);
    }

    public function testCategoryListedSuccessfully()
    {  
        $headers = ['Accept' => 'application/json']; 

        $first = Category::create([
            "name" => "First Category", 
        ]);

        $second = Category::create([
            "name" => "Second Category", 
        ]);

        $response = $this->json('GET', '/api/v1/categories', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                "categories" => [
                    [
                        "id" => 1,
                        "name" => "First Category",
                        "children" => [],
                        "active" => true,
                    ],
                    [
                        "id" => 2,
                        "name" => "Second Category",
                        "children" => [],
                        "active" => true,
                    ]
                ],
                "message" => "Categories retrieved successfully"
            ]);
    }

    public function testCategoryChangeStatusSuccessfully()
    {
        
        $headers = ['Accept' => 'application/json']; 

        $first = Category::create([
            "name" => "First Category", 
        ]);

        $this->json('POST', '/api/v1/categories/'.$first->id.'/changestatus', [] ,$headers)
            ->assertStatus(200)
            ->assertJson([
                "status" => 200,
                "category" => [
                    "id" => 1,
                    "name" => "First Category",
                    "active" => false,
                ],
                "message" => "Category updated successfully"
            ]);
    }
}
