<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public  function getProduct($cat,$prod_id){
        $item = Product::where('id',$prod_id)->first();
        return view( 'store.proddetail',[
           'item'=>$item
        ] );
    }
}
