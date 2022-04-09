<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    //one product has many photos
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    //many products has one brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // one product has one category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //one product has one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //many products has many quotes
    public function quotes()
    {
        return $this->belongsToMany(Quote::class, 'quote_product');
    }
}
