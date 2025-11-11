<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'taille_id',
        'color_id',
        'quantity',
        'sku_variant',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function taille()
    {
        return $this->belongsTo(Taille::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}