<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory,SearchableTrait,Searchable;

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.name' => 10,
            'products.details' => 10,
            'products.description' => 10
        ]
    ];

    protected  $guarded = [];

    public function scopeWithRandomProduct(Builder $query , $arg)
    {
        return $query
            ->inRandomOrder()
            ->take($arg);
    }

    public function parsePrice()
    {
        return number_format($this->price,2);
    }


    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }

// for add category to algolia
    public function toSearchableArray()
    {
        $array = $this->toArray();
        // Customize array...
        $extraFields = [
            'categories' => $this->category()->pluck('name')->toArray()
        ];

        return array_merge($extraFields , $array);
    }


}
