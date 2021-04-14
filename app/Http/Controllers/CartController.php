<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Item;

class CartController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/cart",
     *      tags={"Cart"},
     *      summary="Show cart",
     *      description="<b>Returns the current cart.</b> <br> 
                       Creation Date: 13/04/2021 05:30 PM <br> 
                       Create By: Juan Cuero <br>
                    Last Edit Date: 13/04/2021 05:30 PM <br> 
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
    public function show()
    {
        $cart = Cart::where('status','P')->with('items')->first(); 
        return response()->json([
            'status'=> 200, 
            'cart'=> $cart, 
        ], 200);
    }


    /**
     * @OA\Post(
     *      path="/api/cart/{product}",
     *      tags={"Cart"},
     *      summary="Add product to cart",
     *      description="<b>Agregar Producto a carrito.</b> <br> 
                       Creation Date: 13/04/2021 05:00 PM <br> 
                       Create By: Juan Cuero <br>
                    Last Edit Date: 13/04/2021 05:00 PM <br> 
    *        ",  
     *        @OA\Parameter(
     *          name="product",
     *          description="product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ), 
     *       @OA\RequestBody(
     *       @OA\JsonContent(
     *            type="object",
     *       @OA\Property(title="Quantity",property="quantity",type="integer",example=10), 
     *        )
     *        ),   
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
    public function store(Request $request, Product $product)
    {
        
        try {

            $data = $request->validate([
                'quantity' => 'required|numeric'
            ]);   


            $cart = Cart::where('status','P')->first();

            if(!$cart){
                $cart =  new Cart();
                $cart->save();
            }

            $item = Item::where('cart_id',$cart->id)->where('product_id',$product->id)->first();

            if(!$item){

                $quantity = $request->quantity;
                if($quantity > $product->stock){
                    $quantity = $product->stock;
                }

                $cart->items()->create([
                    'product_id' => $product->id,
                    'price_unit' => $product->price,
                    'quantity' => $quantity,
                ]);
            }else{

                $quantity = $item->quantity + $request->quantity;

                if($quantity > $product->stock){
                    $quantity = $product->stock;
                }

                $item->price_unit = $product->price;
                $item->quantity = $quantity;
                $item->save();
            }

            DB::commit();

            $cart = Cart::where('status','P')->with('items')->first(); 

            return response()->json([
                'status'=> 200, 
                'cart'=> $cart, 
            ], 200);

        }catch (\Exception $ex){ 
            error_log($ex->getMessage());
            DB::rollBack();

            return response()->json([
                'status'=> 500, 
                'error'=>$ex->getMessage(),
            ], 500);
        }  

       
    }
}