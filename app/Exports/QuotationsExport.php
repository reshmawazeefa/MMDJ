<?php

namespace App\Exports;

use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class QuotationsExport implements FromCollection
{
    use Exportable;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $data = QuotationItem::join('quotations', 'quotation_items.quotation_id', '=', 'quotations.id')->join('products', 'quotation_items.itemCode', '=', 'products.productCode')->join('customers', 'quotations.CustomerCode', '=', 'customers.customer_code')->join('partners', 'quotations.Ref3', '=', 'partners.partner_code')->select('DocNo','status','DocDate','quotation_items.ItemCode','products.productName','products.brand','quotation_items.Qty','quotation_items.LineTotal','partners.name as partner_name','customers.customer_code','customers.name as customer_name');
        if (Auth::user()->hasRole('Admin')) {
        } else {
            $data->where(function ($query) {
                    $query->where('manager1', Auth::user()->id)
                        ->orWhere('manager2', Auth::user()->id)
                        ->orWhere('createdBy', Auth::user()->id);
                });
        }
        if (!empty($request->from_date)) {
            //echo "here1";
            $data->where('quotations.DocDate', '>=', $request->from_date);
        }
        if (!empty($request->to_date)) {
            //echo "here2";
            $data->where('quotations.DocDate', '<=', $request->to_date);
        }
        if (!empty($request->customer)) {
            //echo "here";
            $data->where('quotations.CustomerCode', $request->customer);
        }
        if (!empty($request->user)) {
            //echo "here";
            $data->where('quotations.createdBy', $request->user);
        }
        if (!empty($request->status)) {
            if ($request->status == "All") {
                // $request->status= 'Cancel';
                // $data->where('quotations.status', '!=', $request->status);
                $data->whereIn('quotations.status',$request->stsval);
            } else {
                $data->where('quotations.status', $request->status);
            }
        } else {
            $data->where('quotations.status', '!=', 'Cancel');
        }
        $data->orderBy('DocDate','desc');

        return $data->chunk(1000, function (Collection $items) {
            foreach ($items as $val) {
                yield [
                    'DOC NO' => $val->DocNo,
                    'STATUS' => $val->status,
                    'DATE' => date('d-m-Y', strtotime($val->DocDate)),
                    'ITEM CODE' => $val->ItemCode,
                    'ITEM NAME' => $val->productName ? $val->productName:"",
                    'ITEM QUANTITY' => $val->Qty,
                    'BRAND' => $val->brand ? $val->brand:"",
                    'AMOUNT' => $val->LineTotal,
                    'SALES EXECUTIVE' => $val->partner_name ? $val->partner_name:"",
                    'CUSTOMER CODE' => $val->customer_code ? $val->customer_code:"",
                    'CUSTOMER NAME' => $val->customer_name ? $val->customer_name:"",
                ];
            }
        });
    }
}
