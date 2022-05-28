<?php

namespace App\Console\Commands;
use App\Models\Category;
use App\Models\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Console\Command;

class UpdateSlug extends Command
{

    protected $signature = 'update:slug';
    protected $description = 'Update Slug';

    public function handle():void
    {
        $product = Product::all();


            $product->each(function (Product $product) {
                $this->info('ID', $product->id . 'name' . $product->name . ('SLUG:' . ($product->slug)));
                $product->slug = SlugService::createSlug(Product::class, 'slug', $product->name);
                $product->save();
            });




    }
}
