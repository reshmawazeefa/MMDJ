<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Partner;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductPrice;
use App\Models\SalesReturnMaster;
use App\Models\PurchaseOrderMaster;
use App\Models\PurchaseReturnMaster;
use App\Models\PurchaseInvoiceMaster;
use App\Models\PurchaseInvoiceItem;
use App\Models\CustomQuotation;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseReturnItem;
use App\Models\SalesInvoiceMaster;
use App\Models\OutgoingPaymentMaster;
use App\Models\DayEndClosing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

class DayclosingController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request)
    {
        // dd($request);

        if ($request->ajax()) {
            if (Auth::user()->hasRole('Admin')) {
                $data = DayEndClosing::select('day_end_closing.*');
            } else {
                $data = DayEndClosing::select('day_end_closing.*');
                   
            }

            if (!empty($request->from_date)) {
                //echo "here";
                $data->where('DocDate', '>=', $request->from_date);
            }
            if (!empty($request->to_date)) {
                //echo "here";
                $data->where('DocDate', '<=', $request->to_date);
            }

            if (!empty($request->status)) {
                if ($request->status == "All") {
                    $data->where('day_end_closing.IntgrateStatus', '!=', 'Cancel');
                } else {
                    $data->where('day_end_closing.IntgrateStatus', $request->status);
                }
            } 
                $data->where('day_end_closing.Branch', session('branch_code'));

                $data->orderBy('DocEntry', 'desc')->get();
                

                // dd($data);
                return Datatables::of($data)
                
                ->addColumn('action', function ($row) {
                    $url = url('admin/dayend-closing/' . $row->DocEntry);
                    // $url_edit = url('admin/outgoing-payment/' . $row->id . '/edit');
                    $btn = '<a href=' . $url . ' class="btn btn-primary"><i class="mdi mdi-eye"></i>View</a>';
                   
                    return $btn;
                })

           
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.dayendclosing');
    }

    public function create(Request $request)
    {

        $selected_date = $request->date ?? date('Y-m-d');
        $selected_date_dmy = date('d-m-Y', strtotime($selected_date));

        $totalSums = DB::table('incoming_payment_masters')
            ->where('CreateDate', $selected_date)
            ->where('Branch', session('branch_code'))
            ->selectRaw('
                IFNULL(SUM(CAST(CheckSum AS DECIMAL(10,2))),0) as total_cheque,
                IFNULL(SUM(CAST(CardSum AS DECIMAL(10,2))),0) as total_card,
                IFNULL(SUM(CAST(TransSum AS DECIMAL(10,2))),0) as total_transfer
            ')
            ->first();

    
        $totalcash = DB::table('incoming_payment_masters')
            ->where('CreateDate', $selected_date)
            ->where('CashAcct', '=', '130030108')
            ->where('Branch', session('branch_code'))
            ->selectRaw('IFNULL(SUM(CAST(CashSum AS DECIMAL(10,2))), 0) as total_cash')
            ->first();
    
        $pettycash = DB::table('incoming_payment_masters')
            ->where('CreateDate', $selected_date)
            ->where('CashAcct', '=', '130030217')
            ->where('Branch', session('branch_code'))
            ->selectRaw('IFNULL(SUM(CAST(CashSum AS DECIMAL(10,2))), 0) as total_cash')
            ->first();
    
        $opening_blnc = DB::table('branches')
            ->where('BranchCode', session('branch_code'))
            ->select('OpeningBalance')
            ->first();
    

        $total_sale = DB::table('sales_invoice_masters')
            ->where('doc_date', $selected_date_dmy)
            ->where('Branch', session('branch_code'))
            ->selectRaw('IFNULL(SUM(CAST(total AS DECIMAL(10,2))), 0) as totalsale')
            ->first(); 
    
        $total_sales_return = DB::table('sales_return_masters')
            ->where('doc_date', $selected_date_dmy)
            ->where('branch', session('branch_code'))
            ->selectRaw('IFNULL(SUM(CAST(total AS DECIMAL(10,2))), 0) as totalsalereturn')
            ->first();
    
       if ($request->ajax()) {
            // Return data for AJAX requests

            $total_payment =  ($totalSums->total_transfer ?? 0) +  ($totalSums->total_cheque ?? 0) + ($totalSums->total_card ?? 0) + ($totalcash->total_cash ?? 0) + ($pettycash->total_cash ?? 0);

            // dd($total_payment);
            return response()->json([
                'total_cash' => $totalcash->total_cash ?? 0,
                'petty_cash' => $pettycash->total_cash ?? 0,
                'total_card' => $totalSums->total_card ?? 0,
                'total_cheque' => $totalSums->total_cheque ?? 0,
                'total_transfer' => $totalSums->total_transfer ?? 0,
                'total_sales' => $total_sale->totalsale ?? 0,
                'total_sales_return' => $total_sales_return->totalsalereturn ?? 0,
                'opening_balance' => $opening_blnc->OpeningBalance ?? 0,
                'total_payment' => $total_payment,
                'net_sales' => ($total_sale->totalsale ?? 0) - ($total_sales_return->totalsalereturn ?? 0),
                'net_cash' => ($totalcash->total_cash ?? 0) - $total_payment,
            ]);
       }
    
        // Return the full view for page load
        return view('admin.create_dayclosingpayment', compact(
            'totalSums',
            'opening_blnc',
            'totalcash',
            'pettycash',
            'total_sale',
            'total_sales_return'
        ));
    }
    
    
    




    public function show($id)
    {
  
        $details = DayEndClosing::where('DocEntry',$id)->where('Branch',session('branch_code'))->first(); 
        //dd($details);
        return view('admin.dayclosing_details', compact('details'));
    }

    public function edit($id)
    {
        $details = OutgoingPaymentMaster::select('outgoing_payment_masters.*')->with(array('Item_details.products.stock','customer','referral1','referral2','referral3'))->find($id); 
        // dd(json_encode($details));
        return view('admin.edit_purchasereturn', compact('details'));
    }

    



    public function update(Request $request, $id)
    {
        //dd($request);
        $validator = $request->validate([
            'customer' => 'required',
            'product' => 'required|array|min:1',
            'quantity' => 'required|array|min:1'
        ]);
    
        // Find existing PurchaseReturnMaster by id
        $goodsreturn = OutgoingPaymentMaster::find($id);
        if (!$goodsreturn) {
            return redirect()->back()->with('error', 'Sales Order not found');
        }
    
        // $docnum = $request->doc_list . "-" . $request->docNumber;
    
        // Update the OutgoingPaymentMaster fields
        $goodsreturn->cid = $request->customer;
        $goodsreturn->ref_no = $request->refno;
        // $goodsreturn->add_type_bill_to = $request->bill_to;
        // $goodsreturn->add_type_ship_to = $request->ship_to;
        $goodsreturn->address_bill = $request->bill_to_address;
        $goodsreturn->address_ship = $request->ship_to_address;
        $goodsreturn->pl_supply = $request->place_of_sply;
        // $goodsreturn->tax_type = $request->tax_type;
        // $goodsreturn->doc_num = $docnum;
        $goodsreturn->status = $request->status;
        $goodsreturn->posting_date = $request->posting_date;
        $goodsreturn->docdue_date = $request->docdue_date;
        $goodsreturn->doc_date = $request->DocuDate;
        // $goodsreturn->payment_term = $request->payment_term;
        $goodsreturn->tax_regno = $request->tax_reg_no;
        $goodsreturn->open_quotation = $request->open_qutn ? $request->open_qutn : 0;
        $goodsreturn->sales_emp_id = $request->partner3;
        $goodsreturn->remarks = $request->remarks;
        $goodsreturn->total_bf_discount = $request->total_bef_discount;
        $goodsreturn->discount_percent = $request->discount;
        $goodsreturn->discount_amount = $request->discount_amount_value;
        $goodsreturn->total_exp = $request->expense;
        $goodsreturn->tax_amount = $request->tax_amount;
        $goodsreturn->rounding = $request->roundtext;
        $goodsreturn->total = $request->grand_total;
        $goodsreturn->updatedBy = Auth::user()->id;  // You may want to track who updated it
        $goodsreturn->save();
    
        // Update the PurchaseReturnItem details
        $products = $request->product;
        $warehouses = $request->whscode;
        $LineTotal = $request->linetotal;
        $quantity = $request->quantity;
        $pquantity = $request->pquantity;
        $unitprice = $request->unitprice;
        $discprice = $request->discprice;
        $taxcode = $request->taxcode;
        $serialno = $request->serialno;
        
        // Remove existing items first (optional, based on your needs)
        PurchaseReturnItem::where('sm_id', $id)->delete();
        
        // Re-insert the items with updated values
        $count = count($products);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($products[$i]) && !empty($quantity[$i]) && !empty($warehouses[$i])) {
                $bstock = DB::table('itemwarehouses as i')
                ->where('i.ItemCode', $products[$i])
                ->where('i.WhsCode', session('branch_code'))
                ->first();
    
                $pstock = DB::table('product_stocks as s')
                            ->where('productCode', $products[$i])
                            ->first();
            if($bstock && $pstock)   
            {            
            if($pquantity[$i])
            {
                if($pquantity[$i] < $quantity)
                {
                    $qtybalance[$i] = $pquantity[$i] - $quantity[$i];
                    DB::table('itemwarehouses as i')
                    ->where('i.ItemCode', $products[$i])
                    ->where('i.WhsCode', session('branch_code'))
                    ->update([
                        'OnHand' => $bstock->OnHand - $qtybalance[$i]
                    ]);
    
                    DB::table('product_stocks')
                        ->where('productCode', $products[$i])
                        ->update([
                            'onHand' => $pstock->onHand - $qtybalance[$i]
                        ]);
                }
                else
                {   
                    // $qtybalance[$i] = $quantity[$i] - $pquantity[$i];
                    // DB::table('itemwarehouses as i')
                    // ->where('i.ItemCode', $products[$i])
                    // ->where('i.WhsCode', session('branch_code'))
                    // ->update([
                    //     'OnHand' => $bstock->OnHand + $qtybalance[$i]
                    // ]);
    
                    // DB::table('product_stocks')
                    //     ->where('productCode', $products[$i])
                    //     ->update([
                    //         'onHand' => $pstock->onHand + $qtybalance[$i]
                    //     ]);
    
                }
    
            }
            
            else
            {
    
                // DB::table('itemwarehouses as i')
                // ->where('i.ItemCode', $products[$i])
                // ->where('i.WhsCode', session('branch_code'))
                // ->update([
                //     'OnHand' => $bstock->OnHand + $quantity[$i]
                // ]);
    
                // DB::table('product_stocks')
                //     ->where('productCode', $products[$i])
                //     ->update([
                //         'onHand' => $pstock->onHand + $quantity[$i]
                //     ]);
    
            }   
            } 
                $goodsreturnItem = new PurchaseReturnItem;
                $goodsreturnItem->sm_id = $goodsreturn->id;
                $goodsreturnItem->item_id = $products[$i];
                $goodsreturnItem->whs_code = $warehouses[$i];
                $goodsreturnItem->qty = $quantity[$i];
                $goodsreturnItem->unit_price = $unitprice[$i];
                $goodsreturnItem->disc_price = $discprice[$i];
                $goodsreturnItem->tax_code = $taxcode[$i];
                $goodsreturnItem->line_total = $LineTotal[$i];
                $goodsreturnItem->serial_no = $serialno[$i];
                $goodsreturnItem->status = "Open";
                $goodsreturnItem->save();
            }
        }
    
        return redirect('admin/goods-return/' . $id)->with('success', 'Goods return updated successfully');
    }    



 
    public function insert(Request $request)
        {
           //dd($request);
           $formattedDate = Carbon::createFromFormat('Y-m-d', $request->closing_date)->format('Y-m-d');
        //    dd($formattedDate);
                $validator = $request->validate([
                    'counter_balance' => 'required', 
                    'transfer_to_safe' => 'required', 
                ]);
               $dayclosing = DayEndClosing::create([
                    'DocDate' => $formattedDate,
                    'MachineID' => 'Test-Machine',
                    'Branch' => session('branch_code'),
                    'OpeningBalance' => $request->opening_balance,
                    'CounterBalance' => $request->counter_balance ?? 0,
                    'DenominationTotal' => 0,
                    'Excess_Short' => 0,
                    'CashTotal' => $request->cash_total,
                    'PettyCash' => $request->petty_cash ?? 0,
                    'CardTotal' => $request->card_total,
                    'ChequeTotal' => $request->cheque_total,
                    'TotalBankTransfer' => $request->bank_transfer,
                    'LoyaltyTotal' => 0,
                    'CouponTotal' => 0,
                    'VoucherTotal' => 0,
                    'TotalSales' => $request->total_sales,
                    'TotalSalesReturns' => $request->total_returns,
                    'NetSales' => $request->net_sales,
                    'TransferToSafe' => $request->transfer_to_safe ?? 0,
                    'IntgrateStatus' => "Confirm",
                    'CreateDate' => now(),
                    'Time' => "null",
                    'PaymentTotal' => $request->total_payment ?? 0,
                    'NetCash' => $request->net_cash,
                    'updated_at' =>now(),
                    'created_at' =>now(),
                ]);

                $master_id = $dayclosing->id;
                

                $affectedRows = DB::table('branches')
                ->where('BranchCode', session('branch_code')) // Match the branch by BranchCode
                ->update([
                    'OpeningBalance' => $request->transfer_to_safe ?? 0
                ]);

                    session()->flash('success', 'Day end closing added successfully');
                    return response()->json([
                        'success' => true,
                        'dayclosing' => $master_id, 
                        'message' => 'Day end closing added successfully'
                    ]);


        }

        public function download_excel(Request $request)
        {
            try 
            {
                $data = DB::table('day_end_closing')->select('DocDate', 'Branch', 'OpeningBalance', 'CounterBalance', 'CashTotal', 'PettyCash', 'CardTotal', 'ChequeTotal', 'TotalBankTransfer', 'TotalSales', 'TotalSalesReturns', 'NetSales', 'TransferToSafe', 'IntgrateStatus', 'PaymentTotal', 'NetCash');
        
                if (!Auth::user()->hasRole('Admin')) {
                    $data->where(function ($query) {
                        $query->where('manager1', Auth::user()->id)
                            ->orWhere('manager2', Auth::user()->id)
                            ->orWhere('createdBy', Auth::user()->id);
                    });
                }
        
                if (!empty($request->from_date)) {
                    $data->where('day_end_closing.DocDate', '>=', $request->from_date);
                }
                if (!empty($request->to_date)) {
                    $data->where('day_end_closing.DocDate', '<=', $request->to_date);
                }
  
                if (!empty($request->status)) {
                    if ($request->status == "All") {
                        $data->whereIn('day_end_closing.IntgrateStatus', $request->stsval);
                    } else {
                        $data->where('day_end_closing.IntgrateStatus', $request->status);
                    }
                } else {
                    $data->where('day_end_closing.IntgrateStatus', '!=', 'Cancel');
                }
        
                $data->where('day_end_closing.Branch', session('branch_code'));
                $data->orderBy('DocDate', "desc");
        
                $file_name = 'day_end_closing-' . time() . '.xlsx';
        
                $allData = [];
                $data->chunk(3000, function ($query) use (&$allData) { 
                    $allData = array_merge($allData, json_decode(json_encode($query), true)); // Convert chunk results to array
                });
        
                if (empty($allData)) {
                    logger("No data found to export.");
                    return response()->json(["error" => "No data available for the selected filters."], 400);
                }
        
                // Export data using FastExcel
                (new FastExcel(collect($allData)))->export(public_path('exports') . '/' . $file_name);
        
                $host = request()->getSchemeAndHttpHost() . str_replace('/index.php', '', request()->getBaseUrl());
                
                return response()->json(["url" => $host . '/exports/' . $file_name]);
            }
            catch (\Exception $e) {
                return response()->json(["error" => $e->getMessage()], 500);
            }
        }
        

    public function close(Request $request, $id)
        {
            $goodsreturn = OutgoingPaymentMaster::find($id);
            $data = '';
            if ($goodsreturn->status == 'Confirm') {
                $data = "Goods return is already confirmed!";
            } else {
                $goodsreturn->status = 'Cancel';
                $goodsreturn->cancelReason = $request->cancel_reason;
                $goodsreturn->save();
                $data = "Goods return is cancelled!";
            }
            echo json_encode($data);
        }










}
