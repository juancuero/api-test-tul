<?php

namespace App\Http\Controllers\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;

use DB;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/categories",
     *      tags={"Category"},
     *      summary="List categories",
     *      description="<b>Returns the list of all categories.</b> <br> 
                       Creation Date: 14/04/2021 08:20 PM <br> 
                       Create By: Juan Cuero <br>
                    Last Edit Date: 15/04/2021 03:20 PM <br> 
            ",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
    */
    public function index()
    {
        $categories = Category::listPrincipal()->with('children')->get();

        return response()->json([ 'categories' => CategoryResource::collection($categories), 'message' => 'Categories retrieved successfully'], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/categories",
     *      tags={"Category"},
    *      summary="Category new",
     *      description="<b>Create new category.</b> <br> 
                       Creation Date: 15/04/2021 03:45 PM <br> 
                       Create By: Juan Cuero <br>
                    Last Edit Date: 15/04/2021 03:45 PM <br> 
    *        ",  
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CategoryCreate")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
    */
    public function store(StoreCategoryRequest $request)
    {
        $response = DB::transaction(function () use ($request) {

            $category = Category::create($request->all());

            return response()->json([
                'status'=> 200, 
                'category'=> new CategoryResource($category), 
                'message'=> "Category ".$category->name." cretated successfully", 
            ], 200);

        });

        return $response;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/categories/{category}/changestatus",
     *      tags={"Category"},
     *      summary="Change status category",
     *      description="<b>Change status categor.</b> <br> 
                       Creation Date: 14/04/2021 06:00 PM <br> 
                       Create By: Juan Cuero <br>
                    Last Edit Date: 14/04/2021 06:00 PM <br> 
    *        ",  
     *        @OA\Parameter(
     *          name="category",
     *          description="category id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ), 
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
    */
    public function changeStatus(Request $request, Category $category)
    {
        $category->active = !$category->active;
        $category->save();

        return response()->json([
            'status'=> 200, 
            'category'=> new CategoryResource($category), 
            'message'=> "Category updated successfully", 
        ], 200);
    }
   
}
