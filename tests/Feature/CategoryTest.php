<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;


class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCategoryListedSuccessfully()
    {  
        $headers = ['Accept' => 'application/json']; 

        Category::create([
            "name" => "First Category", 
        ]);

        $response = $this->json('GET', '/api/v1/categories', [], $headers)
            ->assertStatus(200);
    }
}
