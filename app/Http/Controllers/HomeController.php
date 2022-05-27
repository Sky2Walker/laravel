<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
        $products = Product::all();

        if(isset($request->productId)){
            $product = Product::find($request->productId);
            if($request->ajax()){
                return view('home.modal', [
                    'product' => $product
                ])->render();
            }
        }


        return view('home.index',[
            'products'=>$products
        ]);
    }
}
