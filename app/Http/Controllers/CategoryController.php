<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/category",
     *      tags={"Category"},
     *      summary="List categories",
     *      description="<b>Returns the list of all categories.</b> <br> 
                       Creation Date: 14/04/2021 08:20 PM <br> 
                       Create By: Juan Cuero <br>
                    Last Edit Date: 14/04/2021 08:20 PM <br> 
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
        $categories = Category::all();

        return response()->json([
            'status'=> 200, 
            'categories'=> $categories,
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/category/{category}/changestatus",
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
            'message'=> "Category updated successfully", 
        ], 200);
    }

   
}
