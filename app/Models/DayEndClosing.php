<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayEndClosing extends Model
{
    use HasFactory;    
    protected $table = 'day_end_closing';

    protected $fillable = [
        'DocEntry',
        'DocDate',
        'MachineID',
        'Branch',
        'OpeningBalance',
        'CounterBalance',
        'DenominationTotal',
        'Excess_Short',
        'CashTotal',
        'CardTotal',
        'ChequeTotal',
        'TotalBankTransfer',
        'LoyaltyTotal',
        'CouponTotal',
        'VoucherTotal',
        'TotalSales',
        'TotalSalesReturns',
        'NetSales',
        'TransferToSafe',
        'IntgrateStatus',
        'CreateDate',
        'Time',
        'PaymentTotal',
        'NetCash',
    ];

   
}
