<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'reference',
        'category_id',
        'statut',
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function colors(){
        return $this->belongsToMany(Color::class, 'product_colors', 'product_id', 'color_id');
    }
    public function tailles(){
        return $this->belongsToMany(Taille::class,"product_tailles",'product_id','taille_id');
    }
}
