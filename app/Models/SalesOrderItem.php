<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderItem extends Model
{
    use HasFactory;     
    protected $table = 'sales_order_items'; 

    public function products()
    {
        return $this->belongsTo(Product::class, 'item_id', 'productCode');
    }

    public function stock()
    {
        return $this->belongsTo(Product::class, 'whsCode', 'whsCode');
    }

    public function salesordermaster()
    {
        return $this->belongsTo(SalesOrderMaster::class);
    }
}
