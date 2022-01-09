<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    //table's name
    protected $table = 'product';

    //table field about Product
    protected $fillable = [
        'id',
        'name',
        'url_image',
        'price',
        'discount',
        'category'
    ];

    public function category(){
        return $this->belongsTo(Category::class,'id','category');
    }
}
