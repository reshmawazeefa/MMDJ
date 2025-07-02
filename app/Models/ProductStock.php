<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'whsCode',  // ✅ Add this line
        'productCode',
        'onHand',
        'blockQty',
        'updated_date'
    ];

    public function Warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'whsCode', 'whsCode');
    }

    public function Product()
    {
        return $this->belongsTo(Product::class, 'productCode', 'productCode');
    }

    public function Itemwarehouse()
    {
        return $this->belongsTo(Itemwarehouse::class, 'productCode', 'ItemCode')->where('itemwarehouses.WhsCode', session('branch_code'));
                  
    }

}
