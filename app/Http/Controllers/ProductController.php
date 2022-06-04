<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CommentProd;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{


    public  function getProduct($cat,$prod_id){
        $item = Product::where('id',$prod_id)->first();
        $relatedProducts = Product::where('category_id', $item->category_id)->inRandomOrder()->take(8)->get();
        $category= Category::where('id', $item->category_id)->first();
        $reviews = CommentProd::where('products_id',$item->id)->get();
        if(isset($request->productId)){
            $product = Product::find($request->productId);
            if($request->ajax()){
                return view('home.modal', [
                    'product' => $product
                ])->render();
            }
        }




        return view( 'store.proddetail',[
           'item'=>$item,
            'relatedProducts'=>$relatedProducts,
            'category'=>$category,
            'reviews'=>$reviews

        ] );




    }


    public function sendReview($prod_id, Request $request){
        $product = Product::find($prod_id);

        CommentProd::create([
            'products_id' => $product->id,

            'point' => $request['rating'],
            'text' => $request['review'],
            'e_mail'=>$request['email'],
            'name'=>$request['name']
        ]);


        return redirect()->back();
    }

}
