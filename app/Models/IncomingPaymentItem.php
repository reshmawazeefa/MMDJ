<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingPaymentItem extends Model
{
    use HasFactory;     
    protected $table = 'incomingpayments_lines';
    public function products()
    {
        return $this->belongsTo(Product::class, 'item_id', 'productCode');
    }

    public function stock()
    {
        return $this->belongsTo(Product::class, 'whsCode', 'whsCode');
    }

    public function IncomingPaymentMaster()
    {
        return $this->belongsTo(IncomingPaymentMaster::class);
    }

    public function salesInvoicemaster()
    {
        return $this->belongsTo(SalesInvoiceMaster::class, 'InvDocNum', 'doc_num');
    }
    
}
