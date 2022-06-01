<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function store (Request $request){
        $products = Product::all();
        $categories = Category::all();


        if(isset($request->orderBy)){
            if($request->orderBy=='low-high'){
                $products = Product::orderBy('price')->paginate(12);
            }if($request->orderBy=='high-low'){
                $products = Product::orderBy('price','desc')->paginate(12);
            }


            if($request->ajax()){
                return view('store.order-by',[
                    'products'=> $products
                ])->render();
            }
        }


        if(isset($request->productId)){
            $product = Product::find($request->productId);
            if($request->ajax()){
                return view('home.modal', [
                    'product' => $product
                ])->render();
            }
        }

        return view('store.store',[
            'products'=>$products,
             'categories'=>$categories
            ]
        );
    }
}
