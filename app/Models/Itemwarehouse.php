<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemwarehouse extends Model
{
    use HasFactory;

    public function category()
    {        
        return $this->belongsTo(Category::class, 'categoryCode', 'categoryCode');
    }

    public function stock()
    {
        return $this->belongsTo(ProductStock::class, 'ItemCode', 'productCode');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'ItemCode', 'productCode');
    }
}
