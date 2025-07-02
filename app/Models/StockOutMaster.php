<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOutMaster extends Model
{
    use HasFactory;    

    public function Items()
    {
        return $this->hasMany(StockOutItem::class,'sm_id', 'sm_id')->orderBy('id');
    }

    public function Item_details()
    {
        return $this->hasMany(StockOutItem::class,'sm_id', 'id')->orderBy('id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cid', 'customer_code');
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
        return $this->belongsTo(Partner::class, 'emp_id', 'partner_code');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'to_branch', 'BranchCode');
    }

}
