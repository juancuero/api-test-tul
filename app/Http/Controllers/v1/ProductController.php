<?php

namespace App\Http\Controllers\v1;

use App\Models\Product;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\StoreProductRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;


class ProductController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/products",
     *      tags={"Products"},
     *      summary="List Products",
     *      description="<b>Returns the list of available products.</b> <br> 
                       Creation Date: 13/04/2021 04:00 PM <br> 
                       Create By: Juan Cuero <br>
                    Last Edit Date: 13/04/2021 04:00 PM <br> 
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
        $products = Product::availables()->get();

        return response()->json([
            'status'=> 200, 
            'products'=> ProductResource::collection($products),
        ], 200);
    }



    /**
     * @OA\Post(
     *      path="/api/v1/products",
     *      tags={"Products"},
     *      summary="Crear producto",
     *      description="<b> Crea producto. </b> <br> 
      *                  Creation Date: 14/04/2021 07:00 PM<br> 
     *                   Create By: Juan Cuero <br>
     *                   Last Edit Date: 14/04/2021 07:00 PM <br> 
    *       ",
    * @OA\RequestBody( 
    *   required=true,
    *   description="Bulk products Body",
    *   @OA\MediaType(
    *     mediaType="multipart/form-data",
    *     @OA\Schema(ref="#/components/schemas/ProductCreate")
    *   )
    * ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="These credentials do not match our records.",
     *      )
     * )
     */ 
    public function store(StoreProductRequest $request)
    {
        $response = DB::transaction(function () use ($request) {
                 
                $product = Product::create($request->all());


                $dir = public_path(IMAGE_PATH_NAME);
                if( ! \File::isDirectory($dir) ) {
                    \File::makeDirectory($dir, 0777, true);
                }

                if($request->file('image')){
                   $image = $request->file('image');
                        $filename  =  $product->id.'_'.time() . '.' . $image->getClientOriginalExtension();
                        $path = '/'.IMAGE_PATH_NAME.'/'.$filename;
                        $image->move(public_path(IMAGE_PATH_NAME), $filename);
                        $product->image = $path;
                        $product->save();
                }    

                return response()->json([
                    'status'=>200,  
                    'product'=> new ProductResource($product), 
                    'message'=> "Product ".$product->name.' successfully',  
                ], 200);
                
             
            
        });

        return $response;   
    }
}
