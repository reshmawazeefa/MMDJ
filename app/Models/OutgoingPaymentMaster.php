<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingPaymentMaster extends Model
{
    use HasFactory;    
    protected $fillable = [
        'Series',
        'DocNum',
        'DocType',
        'Canceled',
        'DocStatus',
        'ObjType',
        'DocDate',
        'CreateDate',
        'DocTime',
        'DocDueDate',
        'TaxDate',
        'CardCode',
        'CardName',
        'RefNo',
        'Address',
        'UserCode',
        'SalesManCode',
        'SalesManName',
        'Remarks',
        'CashAcct',
        'CashSum',
        'CheckAcct',
        'CheckSum',
        'CheckDate',
        'CheckNo',
        'CheckBank',
        'CheckBranch',
        'CardAcct',
        'CardSum',
        'CardType',
        'CardNo',
        'CardValid',
        'VoucherNo',
        'TransAcct',
        'TransSum',
        'TransDate',
        'TransRef',
        'DocTotal',
        'MachineID',
        'Branch',
        'TotalPaySum',
        'IntgrStatus',
        'IntgrateStatus',
        'GUIDNo'
    ];

    public function Items()
    {
        return $this->hasMany(OutgoingPaymentItem::class,'LineNum', 'DocEntry')->orderBy('DocEntry');
    }

    public function Item_details()
    {
        return $this->hasMany(OutgoingPaymentItem::class,'LineNum', 'DocEntry')->orderBy('DocEntry');
    }

    public function Item_details2()
    {
        return $this->hasMany(OutgoingPaymentItem2::class,'LineNum', 'DocEntry')->orderBy('DocEntry');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'CardCode', 'customer_code');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'SalesManCode', 'id');
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
        return $this->belongsTo(Partner::class, 'SalesManCode', 'partner_code');
    }
}
