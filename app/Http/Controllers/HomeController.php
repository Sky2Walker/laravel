<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
        $products = Product::paginate(12);

        if(isset($request->productId)){
            $product = Product::find($request->productId);
            if($request->ajax()){
                return view('home.modal', [
                    'product' => $product
                ])->render();
            }
        }


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

        return view('home.index',[
            'products'=>$products
        ]);
    }
}
