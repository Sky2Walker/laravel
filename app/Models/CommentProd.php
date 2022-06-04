<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentProd extends Model
{
    use HasFactory;
    protected $table = 'com_prod';
    protected $fillable = [
        'name',
        'e_mail',
        'text',
        'products_id',
        'created_at',
        'updated_at',
        'point',
    ];

    public function comments(){
        return $this->belongsTo('App\CommentProd', 'products_id');
    }
}
