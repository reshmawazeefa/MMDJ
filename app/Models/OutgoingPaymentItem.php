<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingPaymentItem extends Model
{
    use HasFactory;     
    protected $table = 'outgoingpayments_lines';
    public function products()
    {
        return $this->belongsTo(Product::class, 'item_id', 'productCode');
    }

    public function stock()
    {
        return $this->belongsTo(Product::class, 'whsCode', 'whsCode');
    }

    public function OutgoingPaymentMaster()
    {
        return $this->belongsTo(OutgoingPaymentMaster::class);
    }
}
