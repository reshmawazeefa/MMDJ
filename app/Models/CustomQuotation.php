<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomQuotation extends Model
{
    use HasFactory;    

    public function Items()
    {
        return $this->hasMany(CustomQuotationItem::class)->orderBy('LineNo');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CustomerCode', 'customer_code');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referral1()
    {
        return $this->belongsTo(Partner::class, 'Ref1', 'partner_code');
    }

    public function referral2()
    {
        return $this->belongsTo(Partner::class, 'Ref2', 'partner_code');
    }

    public function referral3()
    {
        return $this->belongsTo(Partner::class, 'Ref3', 'partner_code');
    }
}
