<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentProd extends Model
{
    use HasFactory;

    public function comments(){
        return $this->belongsTo('App\CommentProd', 'products_id');
    }
}
