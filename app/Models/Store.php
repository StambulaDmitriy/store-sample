<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table = 'stores';

    protected $guarded = [];

    public function products() {
        return $this->belongsToMany(Product::class,'store_products')->withPivot('stock_quantity')->withTimestamps();
    }
}
