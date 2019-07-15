<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
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
            $product->save();

            return response()->json([
                "message" => "Producto creado correctamente.",
                "product_id" => $product->product_id
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
                'product_description' => 'required|max:255',
            ]);

            $product=Product::find($id);
            $product->product_name=$request->product_name;
            $product->product_code=$request->product_code;
            $product->product_description=$request->product_description;
            $product->save();

            return response()->json([
                "message" => "Producto actualizado correctamente."
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
