<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UltraProduct extends Model
{
    use HasFactory;
    public function Product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
