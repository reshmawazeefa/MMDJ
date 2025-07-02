<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'productCode',
        'productName',
        'barcode',
        'invUOM',
        'saleUOM',
        'hsnCode',
        'taxRate',
        'categoryCode',
        'subCateg',
        'type',
        'brand',
        'size',
        'color',
        'finish',
        'thickness',
        'conv_Factor',
        'sqft_Conv',
        'boxQty',
        'weight',
        'image',
        'is_active',
        'updated_date',
    ];

    public function category()
    {        
        return $this->belongsTo(Category::class, 'categoryCode', 'categoryCode');
    }

    public function stock()
    {
        return $this->belongsTo(ProductStock::class, 'productCode', 'productCode');
    }
    public function price()
    {
        return $this->belongsTo(ProductPrice::class, 'productCode', 'productCode');
    }
    public function Itemwarehouse()
    {
        return $this->belongsTo(Itemwarehouse::class, 'productCode', 'ItemCode')->where('WhsCode', session('branch_code'));
                  
    }
}
