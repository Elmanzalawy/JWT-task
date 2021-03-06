<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Validator;

class ProductController extends Controller
{


            public function index(){

                $products = Product::get();
                return response()->json($products, 200);
            }

            public function show($id){
                $product = Product::find($id);
                return response()->json($product, 200);
            }

            public function store(Request $request){
                $rules = [
                    'name'=>'required|min:3',
                    'quantity'=>'required|min:1',
                    'price'=>'required|min:1',
                ];
                //validate data before inserting in database
                $validator = Validator::make($request->all(), $rules);
                
                if($validator->fails()){
                    return response()->json($validator->errors(), 400);
                }else{
        
                    $product = Product::create($request->all());
                    return response()->json($product, 201);
                }
            }

            public function update(Request  $request, $id){
                //add rules for updating product
                $rules = [
                    'name'=>'required|min:3',
                    'quantity'=>'required|min:1',
                    'price'=>'required|min:1',
                ];
                //validate data before inserting in database
                $validator = Validator::make($request->all(), $rules);
                
                //log validator errors if exist
                if($validator->fails()){
                    return response()->json($validator->errors(), 400);
                }else{
        
                    $product = Product::find($id);
                    $product->update($request->all());
                    return response()->json(['message'=>'Successfully updated product', 'product'=>$product], 201);
                }
            }

            public function destroy($id){
                $product = Product::find($id);
                if(is_null($product)){
                    return response()->json(['message'=>'Record not found'], 404);
                }
                $product->delete();
                return response()->json(['message'=>'Successfully deleted product', 'product'=> $product], 200);

            }
}
