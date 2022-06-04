<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class BlogDetailController extends Controller
{
    public  function getBlog($blog_id){
        $item = Blog::where('id',$blog_id)->first();







        return view( 'blog.bdetail',[
            'item'=>$item,


        ] );




    }
}
