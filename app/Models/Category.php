<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'categories';

    protected $fillable = [
        'name', 'slug'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
