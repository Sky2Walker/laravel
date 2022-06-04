<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function blog(){
        $blogs = Blog::all();
        return view('blog.blog',[
            'blogs'=>$blogs,
            ]
        );
    }
}
