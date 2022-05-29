<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public  function getProduct($cat,$prod_id){
        $item = Product::where('id',$prod_id)->first();
        $relatedProducts = Product::where('category_id', $item->category_id)->inRandomOrder()->take(8)->get();
        $category= Category::where('id', $item->category_id)->first();
        return view( 'store.proddetail',[
           'item'=>$item,
            'relatedProducts'=>$relatedProducts,
            'category'=>$category

        ] );
    }

}
