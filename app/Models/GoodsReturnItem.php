<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsReturnItem extends Model
{
    use HasFactory;     

    public function products()
    {
        return $this->belongsTo(Product::class, 'item_id', 'productCode');
    }

    public function stock()
    {
        return $this->belongsTo(Product::class, 'whsCode', 'whsCode');
    }

    public function GoodsReturnMaster()
    {
        return $this->belongsTo(GoodsReturnMaster::class);
    }
}
