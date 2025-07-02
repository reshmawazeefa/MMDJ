<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Http\Controllers\Controller;
//use App\Models\Customer;
//use App\Models\Partner;
use App\Models\User;
use App\Models\Product;
//use App\Models\ProductPrice;
//use App\Models\CustomQuotation;
//use App\Models\Quotation;
//use App\Models\CustomQuotationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\IncomingPaymentMaster;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
class ReportsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->hasRole('Admin'))
            {
                // $data = DB::table('sales_invoice_masters')
                // ->join('sales_invoice_items', 'sales_invoice_masters.id', '=', 'sales_invoice_items.sm_id')
                // ->join('customers', 'sales_invoice_masters.cid', '=', 'customers.customer_code')
                // ->join('users', 'sales_invoice_masters.sales_emp_id', '=', 'users.id') 
                // ->select('sales_invoice_masters.*',  'sales_invoice_items.*','customers.name as customer_name', 'users.name as emp_name') 
                // ->orderBy('sales_invoice_masters.id', 'desc'); 
                //->get();
                $columns = Schema::getColumnListing('sales_invoice_masters');

                $selects = collect($columns)->map(function ($col) {
                    return "ANY_VALUE(sim.$col) as $col";
                })->implode(', ');

                $data = DB::table('sales_invoice_masters as sim')
                    ->join('sales_invoice_items as sii', 'sim.id', '=', 'sii.sm_id')
                    ->join('customers as c', 'sim.cid', '=', 'c.customer_code')
                    ->join('users as u', 'sim.sales_emp_id', '=', 'u.id')
                    ->selectRaw($selects.',
                        ANY_VALUE(sii.item_id) as item_id,
                        SUM(sii.qty) as qty,
                        ANY_VALUE(c.name) as customer_name,
                        ANY_VALUE(u.name) as emp_name
                    ')
                    ->groupBy('sim.doc_num')
                    ->orderByDesc(DB::raw('ANY_VALUE(sim.id)'));
                    // ->limit(25)
                    // ->get();



                //dd($data);
            }
            else{
            //    $data = DB::table('sales_invoice_masters')
            //     ->join('sales_invoice_items', 'sales_invoice_masters.id', '=', 'sales_invoice_items.sm_id')
            //     ->join('customers', 'sales_invoice_masters.cid', '=', 'customers.customer_code')
            //     ->join('users', 'sales_invoice_masters.sales_emp_id', '=', 'users.id')
            //     // ->where('sales_invoice_items.item_id', 'IN05120')
            //     ->select(
            //         'sales_invoice_masters.*',
            //         'sales_invoice_items.*',
            //         'customers.name as customer_name',
            //         'users.name as emp_name'
            //     )
            //     ->orderBy('sales_invoice_masters.id', 'desc');
                //->get();




                 $columns = Schema::getColumnListing('sales_invoice_masters');

                $selects = collect($columns)->map(function ($col) {
                    return "ANY_VALUE(sim.$col) as $col";
                })->implode(', ');

                $data = DB::table('sales_invoice_masters as sim')
                    ->join('sales_invoice_items as sii', 'sim.id', '=', 'sii.sm_id')
                    ->join('customers as c', 'sim.cid', '=', 'c.customer_code')
                    ->join('users as u', 'sim.sales_emp_id', '=', 'u.id')
                    ->where('sales_invoice_masters.sales_emp_id', auth()->user()->id)
                    ->selectRaw($selects.',
                        ANY_VALUE(sii.item_id) as item_id,
                        SUM(sii.qty) as qty,
                        ANY_VALUE(c.name) as customer_name,
                        ANY_VALUE(u.name) as emp_name
                    ')
                    ->groupBy('sim.doc_num')
                    ->orderByDesc(DB::raw('ANY_VALUE(sim.id)'));


            }
            //dd($data);
            if(!empty($request->from_date))
            {
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('Y-m-d');
                $data->where('doc_date', '>=', $fromDate);
            }
            if(!empty($request->to_date))
            {
                $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('Y-m-d');
                $data->where('doc_date', '<=', $toDate);
            }
            if(!empty($request->branch))
            {
                $data->where('branch', $request->branch);
            }
            if(!empty($request->customer))
            {
                $data->where('cid', $request->customer);
            }
            if(!empty($request->user))
            {
                $data->where('sales_emp_id', $request->user);
            }
            if(!empty($request->item))
            {
                $data->where('item_id', $request->item);
            }
            if (!empty($request->invdoc_num)) {
                //echo "here";
                $data->where('sim.id', '=', $request->invdoc_num);
            }
            $data = $data->get();
            return Datatables::of($data)
            ->addIndexColumn() // Add SlNo as an index column
            // ->addColumn('Type', function ($row) {
            //     return 'Invoice'; 
            // })
            ->addColumn('taxableamount', function ($row) {
                return number_format($row->total_bf_discount - $row->discount_amount, 2, '.', '');
            })
            
            ->addColumn('customer_name', function ($row) {
                return $row->customer_name; 
            })
            ->addColumn('partner_name', function ($row) {
                return $row->emp_name; 
            })
            ->addColumn('doc_date', function ($row) {
                return \Carbon\Carbon::parse($row->doc_date)->format('d-m-Y');
            })
            ->rawColumns(['taxableamount']) 
            ->make(true);
        }
        
        return view('admin.sales_register');
    }

    public function saleorderreport(Request $request)
    {
       
         if ($request->ajax()) {
            // dd($request->customer);
            if(Auth::user()->hasRole('Admin'))
            {
                $data = DB::table('sales_order_items')
                ->join('sales_order_masters', 'sales_order_items.sm_id', '=', 'sales_order_masters.id') 
                ->join('customers', 'sales_order_masters.cid', '=', 'customers.customer_code') 
                ->join('products', 'sales_order_items.item_id', '=', 'products.productCode')
                ->join('warehouses', 'sales_order_items.whs_code', '=', 'warehouses.whsCode')
                ->where('sales_order_masters.status', 'Open')
                ->select(
                    'sales_order_items.item_id',
                    'products.productName as itemname',
                    DB::raw('SUM(sales_order_items.qty) as total_qty'),
                    'warehouses.whsName as whsName'
                )
                ->groupBy('sales_order_items.item_id', 'products.productName', 'warehouses.whsName')
                ->orderBy('sales_order_items.item_id', 'asc');
            //->get();
                //dd($data);
            }
            else{
                $data = DB::table('sales_order_items')
                ->join('sales_order_masters', 'sales_order_items.sm_id', '=', 'sales_order_masters.id') 
                ->join('customers', 'sales_order_masters.cid', '=', 'customers.customer_code') 
                ->join('products', 'sales_order_items.item_id', '=', 'products.productCode')
                ->join('warehouses', 'sales_order_items.whs_code', '=', 'warehouses.whsCode')
                ->where('sales_order_masters.status', 'Open')
                ->where('sales_order_masters.sales_emp_id', auth()->user()->id)
                ->select(
                    'sales_order_items.item_id',
                    'products.productName as itemname',
                    DB::raw('SUM(sales_order_items.qty) as total_qty'),
                    'warehouses.whsName as whsName'
                )
                ->groupBy('sales_order_items.item_id', 'products.productName', 'warehouses.whsName')
                ->orderBy('sales_order_items.item_id', 'asc'); 
            //->get();
            }
           
            // if(!empty($request->from_date))
            // {
            //     $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('d-m-Y');
            //     $data->where('created_at', '>=', $fromDate);
            // }
            // if(!empty($request->to_date))
            // {
            //     $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('d-m-Y');
            //     $data->where('created_at', '<=', $toDate);
            // }
            if(!empty($request->item))
            {
                $data->where('sales_order_items.item_id', $request->item);
            }
            if(!empty($request->customer))
            {
                $data->whereIn('customers.customer_code', $request->customer);
            }
            if(!empty($request->whscode))
            {
                $data->where('whs_code', $request->whscode);
            }
            $data = $data->get();
            // dd($data);

//             dd([
//                 'SQL' => $data->toSql(),
//     'Bindings' => $data->getBindings()
// ]);
            return Datatables::of($data)
            ->addIndexColumn() // Add SlNo as an index column
            ->addColumn('itemname', function ($row) {
                return $row->itemname; 
            })
            ->addColumn('total_qty', function ($row) {
                return $row->total_qty; 
            })
            ->addColumn('whsName', function ($row) {
                return $row->whsName; 
            })
            ->addColumn('action', function ($row) {
                $url = route('sales_detail_report.view', $row->item_id);
                return '<a href="'.$url.'" class="btn btn-sm btn-primary">View</a>';
            })
            ->rawColumns(['action']) 
            ->make(true);
         }
        
        return view('admin.sales_report');
    }

    public function saleorderdetailreport(Request $request,$item)
    {
       
         if ($request->ajax()) {
            if(Auth::user()->hasRole('Admin'))
            {
                $data = DB::table('sales_order_masters')
            ->join('sales_order_items', 'sales_order_masters.id', '=', 'sales_order_items.sm_id') 
            ->join('customers', 'sales_order_masters.cid', '=', 'customers.customer_code') 
            ->join('products', 'sales_order_items.item_id', '=', 'products.productCode') 
            ->join('warehouses', 'sales_order_items.whs_code', '=', 'warehouses.whsCode') 
            ->join('users', 'sales_order_masters.sales_emp_id', '=', 'users.id') 
            ->where('sales_order_items.item_id', $item)
            ->where('sales_order_masters.status', 'Open')
            ->select('sales_order_masters.*',
            'sales_order_items.*', 
            'customers.name as customer_name',
             'users.name as emp_name',
             'warehouses.whsName as whsName',
             'products.productName as itemname'
             ) 
            ->orderBy('sales_order_masters.id', 'desc');
            //->get();
               // dd($data);
            }
            else{
                $data = DB::table('sales_order_masters')
            ->join('sales_order_items', 'sales_order_masters.id', '=', 'sales_order_items.sm_id') 
            ->join('customers', 'sales_order_masters.cid', '=', 'customers.customer_code') 
            ->join('products', 'sales_order_items.item_id', '=', 'products.productCode') 
            ->join('warehouses', 'sales_order_items.whs_code', '=', 'warehouses.whsCode') 
            ->join('users', 'sales_order_masters.sales_emp_id', '=', 'users.id') 
            ->where('sales_order_items.item_id', $item)
            ->where('sales_order_masters.status', 'Open')
            ->where('sales_order_masters.sales_emp_id', auth()->user()->id)
            ->select('sales_order_masters.*',
            'sales_order_items.*', 
            'customers.name as customer_name',
             'users.name as emp_name',
             'warehouses.whsName as whsName',
             'products.productName as itemname'
             ) 
            ->orderBy('sales_order_masters.id', 'desc'); 
            //->get();
            }
           
            if(!empty($request->from_date))
            {
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('d-m-Y');
                $data->where('doc_date', '>=', $fromDate);
            }
            if(!empty($request->to_date))
            {
                $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('d-m-Y');
                $data->where('doc_date', '<=', $toDate);
            }
            if(!empty($request->item))
            {
                $data->where('item_id', $request->item);
            }
            if(!empty($request->customer))
            {
                $data->whereIn('customers.customer_code', $request->customer);
            }
            if(!empty($request->whscode))
            {
                $data->where('whs_code', $request->whscode);
            }
            $data = $data->get();
            // dd($data);
            return Datatables::of($data)
            ->addIndexColumn() // Add SlNo as an index column
            ->addColumn('doc_num', function ($row) {
                return $row->doc_num; 
            })
            ->addColumn('customer_name', function ($row) {
                return $row->customer_name; 
            })
            ->addColumn('doc_date', function ($row) {
                return \Carbon\Carbon::parse($row->doc_date)->format('d-m-Y');
                })
            ->addColumn('emp_name', function ($row) {
                return $row->emp_name; 
            })
            ->addColumn('itemname', function ($row) {
                return $row->itemname; 
            })
            ->addColumn('whsName', function ($row) {
                return $row->whsName; 
            })
            ->rawColumns(['customer_name']) 
            ->make(true);
         }
        
        return view('admin.sales_detail_report');
    }

    public function balancereport(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->hasRole('Admin')) {
                $data = DB::table('incoming_payment_masters')
                        ->join('incomingpayments_lines', 'incoming_payment_masters.DocEntry', '=', 'incomingpayments_lines.LineNum')
                        ->join('sales_invoice_masters', 'incomingpayments_lines.InvDocNum', '=', 'sales_invoice_masters.doc_num')
                        ->join('customers', 'incoming_payment_masters.CardCode', '=', 'customers.customer_code')
                        ->join('users', 'incoming_payment_masters.SalesManCode', '=', 'users.id')
                        ->select(
                            'sales_invoice_masters.doc_num',
                            DB::raw('MAX(incoming_payment_masters.DocDate) AS DocDate'),
                            DB::raw('MAX(customers.name) AS customer_name'),
                            DB::raw('MAX(users.name) AS partner_name'),
                            DB::raw('MAX(incomingpayments_lines.InvDocTotal) AS InvDocTotal'), // Unique value
                            DB::raw('SUM(incomingpayments_lines.SumApplied) AS SumApplied'),
                            DB::raw('ROUND(MAX(sales_invoice_masters.total) - MAX(sales_invoice_masters.applied_amount), 2) AS balance')

                        )
                        ->groupBy('sales_invoice_masters.doc_num')
                        ->orderByDesc(DB::raw('MAX(incoming_payment_masters.DocEntry)'));
                        // ->get();

            } else {
                $data = DB::table('incoming_payment_masters')
                        ->join('incomingpayments_lines', 'incoming_payment_masters.DocEntry', '=', 'incomingpayments_lines.LineNum')
                        ->join('sales_invoice_masters', 'incomingpayments_lines.InvDocNum', '=', 'sales_invoice_masters.doc_num')
                        ->join('customers', 'incoming_payment_masters.CardCode', '=', 'customers.customer_code')
                        ->join('users', 'incoming_payment_masters.SalesManCode', '=', 'users.id')
                        ->where('incoming_payment_masters.SalesManCode', auth()->user()->id)
                        ->select(
                            'sales_invoice_masters.doc_num',
                            DB::raw('MAX(incoming_payment_masters.DocDate) AS DocDate'),
                            DB::raw('MAX(customers.name) AS customer_name'),
                            DB::raw('MAX(users.name) AS partner_name'),
                            DB::raw('MAX(incomingpayments_lines.InvDocTotal) AS InvDocTotal'), // Unique value
                            DB::raw('SUM(incomingpayments_lines.SumApplied) AS SumApplied'),
                            DB::raw('ROUND(MAX(sales_invoice_masters.total) - MAX(sales_invoice_masters.applied_amount), 2) AS balance')
                        )
                        ->groupBy('sales_invoice_masters.doc_num')
                        ->orderByDesc(DB::raw('MAX(incoming_payment_masters.DocEntry)'));
                        // ->get();
            }
    
            // Apply filters
            if (!empty($request->from_date)) {
                $data->whereDate('incoming_payment_masters.DocDate', '>=', $request->from_date);
            }
            if (!empty($request->to_date)) {
                $data->whereDate('incoming_payment_masters.DocDate', '<=', $request->to_date);
            }
            if (!empty($request->customer)) {
                $data->where('customers.customer_code', $request->customer);
            }
            if (!empty($request->user)) {
                $data->where('users.id', $request->user);
            }
            if (!empty($request->invdoc_num)) {
                //echo "here";
                $data->where('sales_invoice_masters.id', '=', $request->invdoc_num);
            }

    
            $data = $data->get();
    
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('customer_name', function ($row) {
                return $row->customer_name ?? 'N/A';
            })
            ->addColumn('DocDate', function ($row) {
                return \Carbon\Carbon::parse($row->DocDate)->format('d-m-Y');
            })
            ->addColumn('partner_name', function ($row) {
                return $row->partner_name ?? 'N/A';
            })
            ->addColumn('action', function ($row) {
                $url = route('balance_report.view', $row->doc_num);
                return '<a href="'.$url.'" class="btn btn-sm btn-primary">View</a>';
            })
            ->rawColumns(['action']) // Allow HTML in the action column
            ->make(true);


        }
    
        return view('admin.balance_report');
    }
    
    public function invoicereport($doc_num)
    {
        // Fetch data from the database
        $data = DB::table('incomingpayments_lines')
            ->select('DocEntry', 'LineNum', 'InvDocNum', 'sales_emp_name as Salesman', 'InvDocDate', 'InvDocTotal', 'SumApplied')
            ->where('InvDocNum', $doc_num)
            ->orderBy('InvDocDate')
            ->orderBy('LineNum')
            ->get()
            ->map(function ($row) {
                $row->InvDocDate = \Carbon\Carbon::parse($row->InvDocDate)->format('d-m-Y');
                return $row;
            });    

            // dd($data);
        // Initialize previous values
        $prevBalance = 0;
        $prevInvDoc = '';
        $pending = 0;
    
        // Process data to apply balance calculations
        $data = $data->map(function ($row, $index) use (&$prevBalance, &$prevInvDoc, &$pending) {
            // Show InvDocTotal only for the first occurrence of InvDocNum
            $row->InvDocTotal = ($prevInvDoc == $row->InvDocNum) ? 0 : $row->InvDocTotal;
    
            // Set Pending to Previous Row's Balance for 2nd row onwards
            $row->Pending = ($prevInvDoc == $row->InvDocNum) ? $prevBalance : 0;
    
            // Calculate Balance
            if ($prevInvDoc == $row->InvDocNum) {
                $row->Balance = number_format($row->Pending - $row->SumApplied, 2, '.', '');
            } else {
                $row->Balance = number_format($row->InvDocTotal - $row->SumApplied, 2, '.', '');
            }
            
            // Ensure previous balance also has two decimal places
            $prevBalance = number_format($row->Balance, 2, '.', '');
            
            
            $prevInvDoc = $row->InvDocNum;
    
            return $row;
        });
    
        // Handle AJAX request for DataTables
        if (request()->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    
        return view('admin.balance_report_detail');
    }
    


    

    public function salesreturnregister(Request $request)
    {

        //dd($request);
        if ($request->ajax()) {
            if(Auth::user()->hasRole('Admin'))
            {
                $data = DB::table('sales_return_masters')
            ->join('customers', 'sales_return_masters.cid', '=', 'customers.customer_code') // Join with customers table
            ->join('partners', 'sales_return_masters.sales_emp_id', '=', 'partners.partner_code') // Join with partners table
            ->select('sales_return_masters.*', 'customers.name as customer_name', 'partners.name as partner_name') // Select customer and partner names
            ->orderBy('sales_return_masters.id', 'desc'); // Apply orderBy here
            //->get();
                //dd($data);
            }
            else{
                $data = DB::table('sales_return_masters')
            ->join('customers', 'sales_return_masters.cid', '=', 'customers.customer_code') // Join with customers table
            ->join('partners', 'sales_return_masters.sales_emp_id', '=', 'partners.partner_code') // Join with partners table
            ->select('sales_return_masters.*', 'customers.name as customer_name', 'partners.name as partner_name') // Select customer and partner names
            ->orderBy('sales_return_masters.id', 'desc'); // Apply orderBy here
                //->get();
            }
       // dd($data->get());
            if(!empty($request->from_date))
            {
                // //dd($request->from_date);
                // //echo "here";
                // $data->where('doc_date','>=', $request->from_date);
                // Convert 'from_date' to dd-mm-yyyy format
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('d-m-Y');
                $data->where('doc_date', '>=', $fromDate);
            }
            if(!empty($request->to_date))
            {
                //echo "here";
                //$data->where('doc_date','<=', $request->to_date);
                // Convert 'to_date' to dd-mm-yyyy format
                $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('d-m-Y');
                $data->where('doc_date', '<=', $toDate);
            }
            if(!empty($request->branch))
            {
                $data->where('branch', $request->branch);
            }
            if(!empty($request->rtn_status))
            {
                //$data->where('status', $request->rtn_status);
                if ($request->rtn_status == "All") {
                    $data->where('sales_return_masters.status', '!=', 'Cancel');
                } else {
                    $data->where('sales_return_masters.status', $request->rtn_status);
                }
            }
            if(!empty($request->customer))
            {
                $data->where('cid', $request->customer);
            }
            if(!empty($request->user))
            {
                //dd($request->user);
                $data->where('sales_emp_id', $request->user);
            }
            // dd($data->toSql());
            //$data->orderBy('id','desc');
            $data = $data->get();
            return Datatables::of($data)
            ->addIndexColumn() // Add SlNo as an index column
            ->addColumn('series', function ($row) {
                return 'TRKABH'; // Return the static value for this column
            })
            
            ->addColumn('taxableamount', function ($row) {
                // Calculate the total as total_bf_discount - discount_amount
                return round($row->total_bf_discount - $row->discount_amount, 2);
            })
            ->addColumn('customer_name', function ($row) {
                return $row->customer_name; // Display the customer name
            })
            ->addColumn('partner_name', function ($row) {
                return $row->partner_name; // Display the partner name
            })
            // ->addColumn('remarks', function ($row) {
            //     return $row->remarks ?? 'N/A'; // Add the remarks field or a fallback value
            // })
            ->rawColumns(['series']) // If the value contains HTML, use rawColumns
            ->make(true);
        }
        return view('admin.sales_return_register');
    }


    public function stockregister(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->hasRole('Admin')) {
                $data = DB::table('product_stocks')
                    ->join('products', 'product_stocks.productCode', '=', 'products.productCode')
                    ->select('product_stocks.*', 'products.productName as productName')
                    ->orderBy('product_stocks.id', 'desc');
            } else {
                $data = DB::table('product_stocks')
                    ->join('products', 'product_stocks.productCode', '=', 'products.productCode')
                    ->select('product_stocks.*', 'products.productName as productName')
                    ->orderBy('product_stocks.id', 'desc');
            }
    
            // Apply filters
            if (!empty($request->from_date)) {
                $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('Y-m-d');
                $data->where('product_stocks.updated_date', '>=', $fromDate);
            }
            if (!empty($request->to_date)) {
                $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('Y-m-d');
                $data->where('product_stocks.updated_date', '<=', $toDate);
            }
            if (!empty($request->products)) {
                $data->where('product_stocks.productCode', $request->products);
            }
    
            // Clone the query to calculate total onHand
            $totalQuantity = $data->sum('product_stocks.onHand');
    
            $data = $data->get();
    
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('updated_date', function ($row) {
                    return Carbon::parse($row->updated_date)->format('d-m-Y');
                })
                // ->addColumn('item_name', function ($row) {
                //     return $row->productName;
                // })
                ->with('totalQuantity', $totalQuantity) // Include total quantity in the response
                ->make(true);
        }
    
        return view('admin.stock_register');
    }
    


    public function get_all_products(Request $request)//get Products
    {
        // dd("hu");
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the products by name**/
        if ($request->has('q') && $request->q!= '') {
            // dd("hi");

            $search = $request->q;
            $data = Product::select("productCode","productName","barcode")
            ->where('is_active','Y')
            ->where(function ($query) use ($search) {
                $query->where('productName','LIKE',"%$search%")
                      ->orWhere('productCode','LIKE',"%$search%");
            })->skip($offset)->with('category','stock.warehouse')->take($resultCount)->get();

            $count = Product::select("id","phone","name")
            ->where('is_active','Y')
            ->where(function ($query) use ($search) {
                $query->where('productName','LIKE',"%$search%")
                      ->orWhere('productCode','LIKE',"%$search%");
            })->count();

        }
        else{

        $data = Product::select("productCode", "productName", "barcode")
                    ->where('is_active', 'Y')
                    ->with('category', 'stock.warehouse')
                    ->skip($offset)
                    ->take($resultCount)->get();

        $count =Product::select("productCode","productName","barcode")->where('is_active','Y')->with('category', 'stock.warehouse')->count();
        }
        /**set pagination**/
        $endCount = $offset + $resultCount;
        if($endCount >= $count)
            $morePages = false;
        else
            $morePages = true;
            
        $result = array(
        "data" => $data,
        "pagination" => array(
        "more" => $morePages
        )
        );
        return response()->json($result);
       
    }
 
    public function item_history(Request $request)
    {
       // dd($request);
        if ($request->ajax()) {
            if(Auth::user()->hasRole('Admin'))
            {
                $data = DB::table('purchase_order_masters as A')
                ->join('purchase_order_items as B', 'A.id', '=', 'B.sm_id')
                ->join('products as C', 'B.item_id', '=', 'C.productCode')
                ->join('partners as D', 'A.sales_emp_id', '=', 'D.partner_code')
            
                ->select([
                    'A.id as TransNo',
                    'A.obj_type as TransType',
                    'A.sales_emp_id as CardCode',
                    'D.name as CardName',
                    'A.doc_num as LineID',
                    'A.doc_date as DocDate',
                    'B.item_id as ItemCode',
                    'C.productName as ItemName',
                    'B.open_qty as InQty',
                    DB::raw('0 as OutQty'),
                    'B.disc_price as Price',
                    'A.branch as BranchCode',
                    'B.whs_code as WhsCode',
                ])
                ->unionAll(
                    DB::table('goods_return_masters as A')
                        ->join('goods_return_items as B', 'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->join('partners as D', 'A.sales_emp_id', '=', 'D.partner_code')
                    
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.sales_emp_id as CardCode',
                            'D.name as CardName',
                            'A.doc_num as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            DB::raw('0 as InQty'),
                            'B.open_qty as OutQty',
                            'B.disc_price as Price',
                            'A.branch as BranchCode',
                            'B.whs_code as WhsCode',
                        ])
                )
                ->unionAll(
                    DB::table('purchase_invoice_masters as A')
                        ->join('purchase_invoice_items as B', 'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->join('partners as D', 'A.sales_emp_id', '=', 'D.partner_code')
            
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.sales_emp_id as CardCode',
                            'D.name as CardName',
                            'A.doc_num as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            DB::raw('CASE WHEN B.base_type != 20 THEN B.open_qty ELSE 0 END as InQty'),
                            DB::raw('0 as OutQty'),
                            'B.disc_price as Price',
                            'A.branch as BranchCode',
                            'B.whs_code as WhsCode',
                        ])
                )
                ->unionAll(
                    DB::table('purchase_return_masters as A')
                        ->join('purchase_return_items as B', 'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->join('partners as D', 'A.sales_emp_id', '=', 'D.partner_code')
            
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.sales_emp_id as CardCode',
                            'D.name as CardName',
                            'A.doc_num as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            DB::raw('0 as InQty'),
                            'B.open_qty as OutQty',
                            'B.disc_price as Price',
                            'A.branch as BranchCode',
                            'B.whs_code as WhsCode',
                        ])
                )
                   ->unionAll(
                    DB::table('sales_invoice_masters as A')
                        ->join('sales_invoice_items as B', 'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->join('partners as D', 'A.sales_emp_id', '=', 'D.partner_code')
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.sales_emp_id as CardCode',
                            'D.name as CardName',
                            'A.doc_num as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            DB::raw('0 as InQty'),
                            DB::raw('CASE WHEN B.base_type != 15 THEN B.open_qty ELSE 0 END as OutQty'),
                            'B.disc_price as Price',
                            'A.branch as BranchCode',
                            'B.whs_code as WhsCode',
                        ])
                )
                ->unionAll(
                    DB::table('sales_return_masters as A')
                        ->join('sales_return_items as B', 'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->join('partners as D', 'A.sales_emp_id', '=', 'D.partner_code')
            
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.sales_emp_id as CardCode',
                            'D.name as CardName',
                            'A.doc_num as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            'B.open_qty as InQty',
                            DB::raw('0 as OutQty'),
                            'B.disc_price as Price',
                            'A.branch as BranchCode',
                            'B.whs_code as WhsCode',
                        ])
                )
                ->unionAll(
                    DB::table('stock_in_masters as A')
                        ->join('stock_in_items as B', 'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.from_branch as CardCode',
                            'A.from_branch_name as CardName',
                            'A.doc_number as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            'B.open_qty as InQty',
                            DB::raw('0 as OutQty'),
                            'B.unit_price as Price',
                            'A.to_branch as BranchCode',
                            'B.whscode as WhsCode',
                        ])
                )
                ->unionAll(
                    DB::table('stock_out_masters as A')
                        ->join('stock_out_items as B',  'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.to_branch as CardCode',
                            'A.to_branch_name as CardName',
                            'A.doc_number as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            DB::raw('0 as InQty'),
                            'B.open_qty as OutQty',
                            'B.unit_price as Price',
                            'A.from_branch as BranchCode',
                            'B.whscode as WhsCode',
                        ])
                ); 
            }
            else{
                $data = DB::table('purchase_order_masters as A')
                ->join('purchase_order_items as B', 'A.id', '=', 'B.sm_id')
                ->join('products as C', 'B.item_id', '=', 'C.productCode')
                ->join('partners as D', 'A.sales_emp_id', '=', 'D.partner_code')
    
                ->select([
                    'A.id as TransNo',
                    'A.obj_type as TransType',
                    'A.sales_emp_id as CardCode',
                    'D.name as CardName',
                    'A.doc_num as LineID',
                    'A.doc_date as DocDate',
                    'B.item_id as ItemCode',
                    'C.productName as ItemName',
                    'B.open_qty as InQty',
                    DB::raw('0 as OutQty'),
                    'B.disc_price as Price',
                    'A.branch as BranchCode',
                    'B.whs_code as WhsCode',
                ])
                ->unionAll(
                    DB::table('goods_return_masters as A')
                        ->join('goods_return_items as B', 'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->join('partners as D', 'A.sales_emp_id', '=', 'D.partner_code')
                    
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.sales_emp_id as CardCode',
                            'D.name as CardName',
                            'A.doc_num as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            DB::raw('0 as InQty'),
                            'B.open_qty as OutQty',
                            'B.disc_price as Price',
                            'A.branch as BranchCode',
                            'B.whs_code as WhsCode',
                        ])
                )
                ->unionAll(
                    DB::table('purchase_invoice_masters as A')
                        ->join('purchase_invoice_items as B', 'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->join('partners as D', 'A.sales_emp_id', '=', 'D.partner_code')
    
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.sales_emp_id as CardCode',
                            'D.name as CardName',
                            'A.doc_num as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            DB::raw('CASE WHEN B.base_type != 20 THEN B.open_qty ELSE 0 END as InQty'),
                            DB::raw('0 as OutQty'),
                            'B.disc_price as Price',
                            'A.branch as BranchCode',
                            'B.whs_code as WhsCode',
                        ])
                )
                ->unionAll(
                    DB::table('purchase_return_masters as A')
                        ->join('purchase_return_items as B', 'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->join('partners as D', 'A.sales_emp_id', '=', 'D.partner_code')
    
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.sales_emp_id as CardCode',
                            'D.name as CardName',
                            'A.doc_num as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            DB::raw('0 as InQty'),
                            'B.open_qty as OutQty',
                            'B.disc_price as Price',
                            'A.branch as BranchCode',
                            'B.whs_code as WhsCode',
                        ])
                )
                ->unionAll(
                    DB::table('sales_invoice_masters as A')
                        ->join('sales_invoice_items as B', 'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->join('partners as D', 'A.sales_emp_id', '=', 'D.partner_code')
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.sales_emp_id as CardCode',
                            'D.name as CardName',
                            'A.doc_num as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            DB::raw('0 as InQty'),
                            DB::raw('CASE WHEN B.base_type != 15 THEN B.open_qty ELSE 0 END as OutQty'),
                            'B.disc_price as Price',
                            'A.branch as BranchCode',
                            'B.whs_code as WhsCode',
                        ])
                )
                ->unionAll(
                    DB::table('sales_return_masters as A')
                        ->join('sales_return_items as B', 'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->join('partners as D', 'A.sales_emp_id', '=', 'D.partner_code')
    
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.sales_emp_id as CardCode',
                            'D.name as CardName',
                            'A.doc_num as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            'B.open_qty as InQty',
                            DB::raw('0 as OutQty'),
                            'B.disc_price as Price',
                            'A.branch as BranchCode',
                            'B.whs_code as WhsCode',
                        ])
                )
                ->unionAll(
                    DB::table('stock_in_masters as A')
                        ->join('stock_in_items as B', 'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.from_branch as CardCode',
                            'A.from_branch_name as CardName',
                            'A.doc_number as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            'B.open_qty as InQty',
                            DB::raw('0 as OutQty'),
                            'B.unit_price as Price',
                            'A.to_branch as BranchCode',
                            'B.whscode as WhsCode',
                        ])
                )
                ->unionAll(
                    DB::table('stock_out_masters as A')
                        ->join('stock_out_items as B',  'A.id', '=', 'B.sm_id')
                        ->join('products as C', 'B.item_id', '=', 'C.productCode')
                        ->select([
                            'A.id as TransNo',
                            'A.obj_type as TransType',
                            'A.to_branch as CardCode',
                            'A.to_branch_name as CardName',
                            'A.doc_number as LineID',
                            'A.doc_date as DocDate',
                            'B.item_id as ItemCode',
                            'C.productName as ItemName',
                            DB::raw('0 as InQty'),
                            'B.open_qty as OutQty',
                            'B.unit_price as Price',
                            'A.from_branch as BranchCode',
                            'B.whscode as WhsCode',
                        ])
                ); 
            }

             $data = DB::table(DB::raw("({$data->toSql()}) as sub"))
            ->mergeBindings($data);

        // Apply filters
        if(!empty($request->from_date))
        {
            $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->format('d-m-Y');
            $data->where('DocDate', '>=', $fromDate);
        }
        if(!empty($request->to_date))
        {
            $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->format('d-m-Y');
            $data->where('DocDate', '<=', $toDate);
        }

        if (!empty($request->item)) {
            $data->where('ItemCode', $request->item);
        }

        $data = $data->get(); // Fetch results as a collection
        Log::info($data); 
        // Ensure the collection is not empty before summing
        $totalInQty = $data->isNotEmpty() ? $data->sum('InQty') : 0;
        $totalOutQty = $data->isNotEmpty() ? $data->sum('OutQty') : 0;    
        
        
        return Datatables::of($data)
            ->addIndexColumn() // Add SlNo as an index column
            ->with('totalInQty', $totalInQty) // Pass total InQty
            ->with('totalOutQty', $totalOutQty) // Pass total OutQty
            ->make(true);
        
        }
        return view('admin.item_history');
    }


    public function cashbook(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->hasRole('Admin')) {
                $query = DB::table('incoming_payment_masters as Inc')
                    ->selectRaw("DocDate, DocNum, CardCode, 
                        CASE WHEN IFNULL(CardName, '') = '' THEN Inc2.AcctName ELSE IFNULL(CardName, '') END AS CardName,
                        CASE 
                            WHEN DocType = 'A' THEN Inc2.SumApplied 
                            ELSE CASE 
                                WHEN CashSum != 0 THEN CashSum 
                                WHEN CheckSum != 0 THEN CheckSum 
                                WHEN TransSum != 0 THEN TransSum 
                                ELSE CardSum END 
                        END AS Debit,
                        0 AS Credit, CashAcct,
                        IFNULL((SELECT InvDocNum FROM incomingpayments_lines Inc1 WHERE Inc1.DocEntry = Inc.DocEntry LIMIT 1), 0) AS InvNo")
                    ->leftJoin('incomingpayments_lines2 as Inc2', 'Inc.DocEntry', '=', 'Inc2.DocEntry')
                    ->where('Inc.Branch', session('branch_code'));
    
                $unionQuery = DB::table('outgoing_payment_masters as Inc')
                    ->selectRaw("DocDate, DocNum, Inc2.AcctName AS CardCode, 
                        Inc2.AcctName AS CardName,
                        0 AS Debit, Inc2.SumApplied AS Credit, CashAcct, 
                        0 AS InvNo")
                    ->join('outgoingpayments_lines2 as Inc2', 'Inc.DocEntry', '=', 'Inc2.DocEntry')
                    ->where('Inc.Branch', session('branch_code'));
            } else {
                $query = DB::table('incoming_payment_masters as Inc')
                    ->selectRaw("DocDate, DocNum, CardCode, 
                        CASE WHEN IFNULL(CardName, '') = '' THEN Inc2.AcctName ELSE IFNULL(CardName, '') END AS CardName,
                        CASE 
                            WHEN DocType = 'A' THEN Inc2.SumApplied 
                            ELSE CASE 
                                WHEN CashSum != 0 THEN CashSum 
                                WHEN CheckSum != 0 THEN CheckSum 
                                WHEN TransSum != 0 THEN TransSum 
                                ELSE CardSum END 
                        END AS Debit,
                        0 AS Credit, CashAcct,
                        IFNULL((SELECT InvDocNum FROM incomingpayments_lines inc1 WHERE Inc1.DocEntry = Inc.DocEntry LIMIT 1), 0) AS InvNo")
                    ->leftJoin('incomingpayments_lines2 as Inc2', 'Inc.DocEntry', '=', 'Inc2.DocEntry')
                    ->where('Inc.Branch', session('branch_code'));
    
                $unionQuery = DB::table('outgoing_payment_masters as Inc')
                    ->selectRaw("DocDate, DocNum, Inc2.AcctName AS CardCode, 
                        Inc2.AcctName AS CardName,
                        0 AS Debit, Inc2.SumApplied AS Credit, CashAcct, 
                        0 AS InvNo")
                    ->join('outgoingpayments_lines2 as Inc2', 'Inc.DocEntry', '=', 'Inc2.DocEntry')
                    ->where('Inc.Branch', session('branch_code'));
            }
    
            if (!empty($request->from_date)) {
                $query->whereRaw("DATE_FORMAT(Inc.DocDate, '%Y-%m-%d') >= ?", [$request->from_date]);
                $unionQuery->whereRaw("DATE_FORMAT(Inc.DocDate, '%Y-%m-%d') >= ?", [$request->from_date]);
            }
    
            if (!empty($request->to_date)) {
                $query->whereRaw("DATE_FORMAT(Inc.DocDate, '%Y-%m-%d') <= ?", [$request->to_date]);
                $unionQuery->whereRaw("DATE_FORMAT(Inc.DocDate, '%Y-%m-%d') <= ?", [$request->to_date]);
            }
    
            if (!empty($request->account)) {
                $query->whereRaw("$request->account = CASE 
                    WHEN CashSum != 0 THEN CashAcct 
                    WHEN CheckSum != 0 THEN CheckAcct 
                    WHEN TransSum != 0 THEN TransAcct 
                    ELSE CardAcct END");
                $unionQuery->where('Inc2.AcctCode', $request->account);
            }
    
            $query->unionAll($unionQuery);
    
            $data = $query->orderBy('DocDate')->orderBy('DocNum')->get();
    

            $opening = DB::table('branches as b')
                    ->selectRaw("OpeningBalance")
                    ->where('b.BranchCode', session('branch_code'))->first();
            // Calculate totals for debit and credit
            $totalDebit = $data->sum('Debit');
            $totalCredit = $data->sum('Credit');
    
            return Datatables::of($data)
                ->addIndexColumn() // Add SlNo as an index column
                ->with('total_debit', $totalDebit) // Adding a new column for total debit
                ->with('total_credit', $totalCredit) // Adding a new column for total credit
                ->with('opening_value', $opening->OpeningBalance) // Adding a new column for total credit
                ->rawColumns([]) // If the value contains HTML, use rawColumns
                ->make(true);
        }
    
        return view('admin.cashbook');
    }
    





}
?>