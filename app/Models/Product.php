<?php

namespace App\Models;

use App\Models\UltraProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable=['name','price','token','genre','discount','stock','mainImg'];
    public function UltraProduct(): HasOne
    {
        return $this->hasOne(UltraProduct::class);
    }
}
