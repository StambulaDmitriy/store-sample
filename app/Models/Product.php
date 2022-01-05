<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $guarded = [];

    public function stores() {
        return $this->belongsToMany(Store::class,'store_products')->withPivot('stock_quantity')->withTimestamps();
    }

    public function getPriceAttribute() {
        if ($this->price_in_pennies == null) {
            return null;
        }
        return $this->price_in_pennies / 100;
    }

    public function getFormattedPriceAttribute() {
        if ($this->price_in_pennies == null) {
            return null;
        }
        return number_format($this->price,2,',',' ');
    }

    public function setPriceAttribute($value) {
        if (is_numeric($value)) {
            $this->price_in_pennies = round($value * 100);
        }
    }
}
