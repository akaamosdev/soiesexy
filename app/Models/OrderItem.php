<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'taille_id',
        'color_id',
        'product_id',
        'quantity',
        'price',
        'montant',

    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function taille(){
        return $this->belongsTo(Taille::class);
    }
    public function color(){
        return $this->belongsTo(Color::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }

}
