<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\StoreProductRequest;


class ProductController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/products",
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
            'products'=> $products,
        ], 200);
    }



    /**
     * @OA\Post(
     *      path="/api/products",
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
        DB::beginTransaction();
        try{
                 
                $product = Product::create([
                    'name' => $request->name,
                    'description'  => $request->description,
                    'stock'  => $request->stock,
                    'price' => $request->price,
                    'category_id' => $request->category_id,
                    'sku' => $request->sku
                ]);


                $dir = public_path("products");
                if( ! \File::isDirectory($dir) ) {
                    \File::makeDirectory($dir, 0777, true);
                }

                if($request->file('image')){
                   $image = $request->file('image');
                        $filename  =  $product->id.'_'.time() . '.' . $image->getClientOriginalExtension();
                        $path = '/products/'.$filename;
                        $image->move(public_path('products'), $filename);
                        $product->image = $path;
                        $product->save();
                }    

                DB::commit();
                
                return response()->json([
                    'status'=>200, 
                    'product'=>$product, 
                    'message'=> "Product ".$product->name.' created',  
                ], 200);
                
             
            
        }catch (\Exception $ex){ 
            error_log($ex->getMessage());
            DB::rollBack();
            return response()->json([
                'status'=>500, 
                'message'=> $ex->getMessage(),  
            ], 500);
        }      
    }
}
