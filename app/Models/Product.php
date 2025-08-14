<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'products';

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'sku',
        'stock',
        'cost_price',
        'sell_price',
        'special_price',
        'status',
        'image',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return '_id';
    }

    /**
     * Get the route key value for the model.
     */
    public function getRouteKey()
    {
        return (string) $this->_id;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
