<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use View;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products=DB::table('products')->orderBy('product_name','asc')->get();

        if($request->ajax()){
            return response()->json([
                "products" => $products
            ], 200);
        }

        return View::make('products.index',['products'=>$products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()){
            $validatedData = $request->validate([
                'product_name' => 'required|max:255'
            ]);

            $product=new Product;
            $product->product_name=$request->product_name;
            $product->product_code=$request->product_code;
            $product->product_description=$request->product_description;
            $product->product_cost=0;
            $product->product_base_price_percentage=0;
            $product->product_retail_price_percentage=0;
            $product->product_wholesale_price_percentage=0;
            $product->product_stock=0;
            
            $product->save();

            return response()->json([
                "message" => "Producto creado correctamente.",
                "product" => $product
            ],200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->ajax()){
            $validatedData = $request->validate([
                'product_name' => 'required|max:255',
            ]);

            $product=Product::find($id);
            $product->product_name=$request->product_name;
            $product->product_code=$request->product_code;
            $product->product_description=$request->product_description;
            
            if(isset($request->product_cost)){
                $product->product_cost=$request->product_cost;
            }
            else if($request->product_cost == ''){
                $product->product_cost=0;
            }
            else{
                $product->product_cost=$product->product_cost;
            }
            
            if(isset($request->product_base_price_percentage)){
                $product->product_base_price_percentage=$request->product_base_price_percentage;
            }
            else{
                $product->product_base_price_percentage=0;
            }

            if(isset($request->product_retail_price_percentage)){
                $product->product_retail_price_percentage=$request->product_retail_price_percentage;
            }
            else{
                $product->product_retail_price_percentage=0;
            }

            if(isset($request->product_wholesale_price_percentage)){
                $product->product_wholesale_price_percentage=$request->product_wholesale_price_percentage;
            }
            else{
                $product->product_wholesale_price_percentage=0;
            }
            $product->save();

            return response()->json([
                "message" => "Producto actualizado correctamente.",
                "product" => $product
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::find($id);
        $product->delete();

        return response()->json([
            "message" => "Producto eliminado correctamente."
        ],200);
    }
}
