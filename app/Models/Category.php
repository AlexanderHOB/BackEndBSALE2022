<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    //table's name
    protected $table='category';

    //table field about Category
    protected $fillable =[
        'id',
        'name'
    ];
}
