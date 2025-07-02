<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Partner;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductPrice;
use App\Models\SalesOrder;
use App\Models\PurchaseOrderMaster;
use App\Models\PurchaseReturnMaster;
use App\Models\PurchaseInvoiceMaster;
use App\Models\PurchaseInvoiceItem;
use App\Models\CustomQuotation;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseReturnItem;
use App\Models\SalesInvoiceMaster;
use App\Models\IncomingPaymentMaster;
use App\Models\IncomingPaymentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

class BankingPaymentController extends Controller
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
                $data = IncomingPaymentMaster::select('incoming_payment_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3','Item_details','Item_details2','user'));
            } else {
                $data = IncomingPaymentMaster::select('incoming_payment_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3','Item_details','Item_details2','user'))
                    ->where(function ($query) {
                        $query->Where('SalesManCode', Auth::user()->id);
                    });
            }

            if (!empty($request->from_date)) {
                //echo "here";
                $data->where('DocDate', '>=', $request->from_date);
            }
            if (!empty($request->to_date)) {
                //echo "here";
                $data->where('DocDate', '<=', $request->to_date);
            }
            if (!empty($request->customer)) {
                //echo "here";
                $data->where('incoming_payment_masters.CardCode', $request->customer);
            }
            if (!empty($request->user)) {
                //echo "here";
                $data->where('incoming_payment_masters.SalesManCode', $request->user);
            }
            if (!empty($request->status)) {
                if ($request->status == "All") {
                    $data->where('incoming_payment_masters.IntgrStatus', '!=', 'Cancel');
                } else {
                    $data->where('incoming_payment_masters.IntgrStatus', $request->status);
                }
            } else {
                $data->where('incoming_payment_masters.IntgrStatus', 'Open');
            }
                $data->where('incoming_payment_masters.Branch', session('branch_code'));

                $data->orderBy('CardCode', 'desc')->get();
                

                // dd($data);
                return Datatables::of($data)
                ->addColumn('DocNo', function ($row) {
                    if ($row->DocNum)
                        return $row->DocNum;
                    else
                        return null;

                })
                ->addColumn('actype', function ($row) {
                    if ($row->DocType)
                        return $row->DocType;
                    else
                        return null;

                })
                ->addColumn('action', function ($row) {
                    $url = url('admin/incoming-payment/' . $row->DocEntry);
                    // $url_edit = url('admin/incoming-payment/' . $row->id . '/edit');
                    $btn = '<a href=' . $url . ' class="btn btn-primary"><i class="mdi mdi-eye"></i>View</a>';
                        /*
                        <a href="javascript:void(0);" onclick="open_closemodal('.$row->id.')" class="btn btn-danger close-icon"><i class="mdi mdi-delete"></i>Close</a>
                        */
                    // if ((($row->status == 'Approve' || $row->status == 'Open') && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) || $row->status == 'Send for Approval') {
                    //     $btn .= '&nbsp;<a href=' . $url_edit . ' class="btn btn-info"><i class="mdi mdi-square-edit-outline"></i>Edit</a>&nbsp;';
                    // }

                    // if ($row->status == 'Approve' && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) {
                    //     $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_approvemodal(' . $row->id . ')" class="btn btn-primary"><i class="mdi mdi-plus-circle me-1"></i>Confirm</a>';
                    // }

                    // if (($row->status == 'Open' || $row->status == 'Send for Approval') && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) {
                    //     $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_closemodal(' . $row->id . ')" class="btn btn-danger close-icon"><i class="mdi mdi-delete"></i>Close</a>';
                    // }
                    return $btn;
                })
                ->addColumn('customer', function ($row) {
                    if ($row->customer) {
                        $n = $row->customer->name;
                        return substr($n, 0, 27);
                    } else
                        return null;
                })
                ->addColumn('doc_date', function ($row) {
                    if ($row->CardCode)
                        return $row->DocDate;
                    else
                        return null;

                })
                ->addColumn('docdue_date', function ($row) {
                    if ($row->CardCode)
                        return $row->DocDueDate;
                    else
                        return null;
                })
                ->addColumn('sales_emp_id', function ($row) {
                    if ($row->user)
                    return $row->user->name;
                    else
                    return null;

                })
                ->addColumn('PriceList', function ($row) {
                    if ($row->DocTotal)
                        return $row->DocTotal;
                    else
                        return null;

                })
               
                ->addColumn('status_show', function ($row) {
                    $row->status_show = $row->IntgrStatus;
                    if ($row->IntgrStatus == 'Cancel')
                        $row->status_show = 'Cancelled';
                    elseif ($row->IntgrStatus == 'Approve')
                        $row->status_show = 'Approved';
                    elseif ($row->IntgrStatus == 'Confirm')
                        $row->status_show = 'Confirmed';
                    return $row->status_show;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.incomingpayments');
    }

    public function create()
    {
        $accmaster = DB::table('account_masters')
        ->get();
        return view('admin.create_incomingpayment', compact('accmaster'));
    }

    public function get_accounts(Request $request)//get Products
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the products by name**/
        if ($request->has('q') && $request->q!= '') {
            // dd("hi");

            $search = $request->q;

            $data = DB::table('account_masters')
            ->select("AcctCode","AcctName")
            ->where(function ($query) use ($search) {
                $query->where('AcctName','LIKE',"%$search%")
                      ->orWhere('AcctCode','LIKE',"%$search%");
            })->skip($offset)->take($resultCount)->get();

            $count = DB::table('account_masters')
            ->select("AcctCode","AcctName")
            ->where(function ($query) use ($search) {
                $query->where('AcctName','LIKE',"%$search%")
                      ->orWhere('AcctCode','LIKE',"%$search%");
            })->count();

        }
        else{
            // dd("hio");

        /** get the users**/
        $data = DB::table('account_masters')
        ->select("AcctCode","AcctName")->skip($offset)->take($resultCount)->get();

        // $queryLog = DB::getQueryLog();
        // print_r($queryLog);

        $count =DB::table('account_masters')
        ->select("AcctCode","AcctName")->count();
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


    public function show($id)
    {
  
        $details1 = IncomingPaymentMaster::select('incoming_payment_masters.*')->with(array('Item_details', 'Item_details2','customer', 'referral3'))->where('incoming_payment_masters.DocEntry',$id)->get(); 
        // dd($details1);
        return view('admin.incomingpayment_details', compact('details1'));
    }

    public function edit($id)
    {
        $details = IncomingPaymentMaster::select('incoming_payment_masters.*')->with(array('Item_details.products.stock','customer','referral1','referral2','referral3'))->find($id); 
        // dd(json_encode($details));
        return view('admin.edit_purchasereturn', compact('details'));
    }

    public function get_users(Request $request)//get Users
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = User::select("*")
            ->orWhere('name','LIKE',"%$search%")
            ->orWhere('email','LIKE',"%$search%")->skip($offset)->take($resultCount)->get();

            $count = User::select("id","phone","name")
            ->orWhere('name','LIKE',"%$search%")
            ->orWhere('email','LIKE',"%$search%")->count();
        }
        else{
        /** get the users**/
        $data = User::select("*")->skip($offset)->take($resultCount)->get();
        $count =User::select("id","phone","name")->count();
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
    
    public function get_customers(Request $request)//get Customers
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        // Check if the request has a search query
if ($request->has('q') && $request->q != '') {
    $search = $request->q;

    // Initialize the query for data
    $data = SalesInvoiceMaster::join('customers', 'sales_invoice_masters.cid', '=', 'customers.customer_code')
        ->select('customers.id', 'customers.phone', 'customers.customer_code', 'customers.name')
        ->where('customers.is_active', 1)
        ->where('sales_invoice_masters.branch', session('branch_code'))
        ->where('sales_invoice_masters.status', "Open")
        ->whereRaw('sales_invoice_masters.total != sales_invoice_masters.applied_amount');

    // Initialize the query for count
    $count = SalesInvoiceMaster::join('customers', 'sales_invoice_masters.cid', '=', 'customers.customer_code')
        ->select('customers.id', 'customers.phone', 'customers.customer_code', 'customers.name')
        ->whereRaw('sales_invoice_masters.total != sales_invoice_masters.applied_amount');

    // Add role-based condition
    if (!Auth::user()->hasRole('Admin')) {
        $data->where('sales_invoice_masters.sales_emp_id', Auth::user()->id);
        $count->where('sales_invoice_masters.sales_emp_id', Auth::user()->id);
    }

    // Apply search filters
    $data->where(function($query) use ($search) {
        $query->where('customers.name', 'LIKE', "%$search%")
              ->orWhere('customers.phone', 'LIKE', "%$search%");
    });

    $count->where(function($query) use ($search) {
        $query->where('customers.name', 'LIKE', "%$search%")
              ->orWhere('customers.phone', 'LIKE', "%$search%");
    });

    // Execute the data query with grouping and pagination
    $data = $data->groupBy('customers.id', 'customers.phone', 'customers.customer_code', 'customers.name')
                 ->skip($offset)
                 ->take($resultCount)
                 ->get();

    // Execute the count query with grouping
    $count = $count->groupBy('customers.id', 'customers.phone', 'customers.customer_code', 'customers.name')
                   ->count();
} else {
    // No search query - get all users
    $data = SalesInvoiceMaster::join('customers', 'sales_invoice_masters.cid', '=', 'customers.customer_code')
        ->select('customers.id', 'customers.phone', 'customers.customer_code', 'customers.name')
        ->where('sales_invoice_masters.branch', session('branch_code'))
        ->where('sales_invoice_masters.status', "Open")
        ->whereRaw('sales_invoice_masters.total != sales_invoice_masters.applied_amount');

    $count = SalesInvoiceMaster::join('customers', 'sales_invoice_masters.cid', '=', 'customers.customer_code')
        ->select('customers.id', 'customers.phone', 'customers.customer_code', 'customers.name')
        ->where('sales_invoice_masters.branch', session('branch_code'))
        ->where('sales_invoice_masters.status', "Open")
        ->whereRaw('sales_invoice_masters.total != sales_invoice_masters.applied_amount');

    // Add role-based condition
    if (!Auth::user()->hasRole('Admin')) {
        $data->where('sales_invoice_masters.sales_emp_id', Auth::user()->id);
        $count->where('sales_invoice_masters.sales_emp_id', Auth::user()->id);
    }

    // Execute the data query with grouping and pagination
    $data = $data->groupBy('customers.id', 'customers.phone', 'customers.customer_code', 'customers.name')
                 ->skip($offset)
                 ->take($resultCount)
                 ->get();

    // Execute the count query with grouping
    $count = $count->groupBy('customers.id', 'customers.phone', 'customers.customer_code', 'customers.name')
                   ->count();
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

    public function list_customers(Request $request)//get Customers
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = IncomingPaymentMaster::join('customers', 'incoming_payment_masters.CardCode', '=', 'customers.customer_code')
            ->select('customers.id','customers.phone','customers.customer_code', 'customers.name')
            ->where('customers.is_active',1)->where('incoming_payment_masters.Branch', session('branch_code'))
            // ->where('incoming_payment_masters.DocStatus', "Open")
            // ->whereRaw('incoming_payment_masters.total != incoming_payment_masters.applied_amount')
            ->where(function($query) use ($search){$query->where('customers.name','LIKE',"%$search%")
            ->orWhere('customers.phone','LIKE',"%$search%");
            })
            ->groupBy('customers.id','customers.phone','customers.customer_code', 'customers.name')
            ->skip($offset)->take($resultCount)->get();

            $count = IncomingPaymentMaster::join('customers', 'incoming_payment_masters.CardCode', '=', 'customers.customer_code')
            ->select('customers.id','customers.phone','customers.customer_code', 'customers.name')
            // ->whereRaw('incoming_payment_masters.total != incoming_payment_masters.applied_amount')
            ->where(function($query) use ($search){$query->where('customers.name','LIKE',"%$search%")
            ->orWhere('customers.phone','LIKE',"%$search%");
            })->groupBy('customers.id','customers.phone','customers.customer_code', 'customers.name')
            ->count();

        }
        else{
        /** get the users**/
        $data = IncomingPaymentMaster::join('customers', 'incoming_payment_masters.CardCode', '=', 'customers.customer_code')
                ->select('customers.id','customers.phone','customers.customer_code', 'customers.name')
                ->where('incoming_payment_masters.Branch', session('branch_code'))
                // ->where('incoming_payment_masters.DocStatus', "Open")
                // ->whereRaw('incoming_payment_masters.total != incoming_payment_masters.applied_amount')
                ->groupBy('customers.id','customers.phone','customers.customer_code', 'customers.name')
                ->skip($offset)
                ->take($resultCount)
                ->get();

        // $count =SalesInvoiceMaster::with('customer')->select("customers.id","customers.phone","customers.name")->where('customer.is_active',1)->count();

        $count = IncomingPaymentMaster::join('customers', 'incoming_payment_masters.CardCode', '=', 'customers.customer_code')
                ->select('customers.id','customers.phone','customers.customer_code', 'customers.name')
                ->where('incoming_payment_masters.Branch', session('branch_code'))
                // ->where('incoming_payment_masters.DocStatus', "Open")
                // ->whereRaw('incoming_payment_masters.total != incoming_payment_masters.applied_amount')
                ->groupBy('customers.id','customers.phone','customers.customer_code', 'customers.name')
                ->count();
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
    
    public function get_partners(Request $request, $type)//get Partners
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = Partner::select("*")->where('partner_type',$type)
            ->where(function ($query) use ($search) {
                $query->where('name','LIKE',"%$search%")
                      ->orWhere('phone','LIKE',"%$search%");
            })->skip($offset)->take($resultCount)->get();

            $count = Partner::select("id","phone","name")->where('partner_type',$type)
            ->where(function ($query) use ($search) {
                $query->where('name','LIKE',"%$search%")
                      ->orWhere('phone','LIKE',"%$search%");
            })->count();

        }
        else{
        /** get the users**/
        $data = Partner::select("*")->where('partner_type',$type)->skip($offset)->take($resultCount)->get();

        $count =Partner::select("id","phone","name")->where('partner_type',$type)->count();
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
    
    public function get_products(Request $request)//get Products
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the products by name**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = Product::select("productCode","productName")
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
        /** get the users**/
        $data = Product::select("productCode","productName")->where('is_active','Y')->with('category','stock.warehouse')->skip($offset)->take($resultCount)->get();

        $count =Product::select("productCode","productName")->where('is_active','Y')->count();
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

    public function get_warehouses(Request $request)
    {
        $data = [];
        $page = $request->page;
        $productCode = $request->productCode;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the products by name**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = ProductStock::
            with('warehouse')->whereHas('warehouse', function ($query) use ($search) {
                $query->where('whsName','LIKE',"%$search%");
                $query->orWhere('whsCode','LIKE',"%$search%");
                return $query;
            })->where('productCode',$productCode)   
            ->skip($offset)->take($resultCount)->get();

            $count = ProductStock::select("*")->
            with(['warehouse' => function($query) use ($search) {
                $query->select('whsCode', 'whsName');
                $query->orWhere('whsName','LIKE',"%$search%");
                $query->orWhere('whsCode','LIKE',"%$search%");
            }])->where('productCode',$productCode)
            ->count();

        }
        else{
        /** get the users**/
        $data = ProductStock::select("*")->
        with(['warehouse','product'])->where('productCode',$productCode)->skip($offset)->take($resultCount)->get();

        $count =ProductStock::select("productCode","productName")->count();
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

    public function get_product_stock(Request $request)
    {
        $product = ProductStock::with('warehouse','product')->where('productCode',$request->productCode)->first();
        //->where('whsCode',$request->whsCode)
        $product['price_list'] = ProductPrice::where('productCode',$request->productCode)->first();
        return response()->json($product);
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
        $goodsreturn = IncomingPaymentMaster::find($id);
        if (!$goodsreturn) {
            return redirect()->back()->with('error', 'Sales Order not found');
        }
    
        // $docnum = $request->doc_list . "-" . $request->docNumber;
    
        // Update the IncomingPaymentMaster fields
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


    public function validateCode_coupon(Request $request)
    {
        $code = $request->input('code');
        // $type = $request->input('type'); // 'coupon' or 'voucher'

        $currentDate = Carbon::now();
            
        $coupon =  DB::table('coupon_master')
                        ->where('code', $code)
                        ->where(function ($query) use ($currentDate){
                            // Check if current date is within the start_date and end_date
                            $query->whereNull('validity')->orWhere('validity', '>=', $currentDate);
                        })
                        ->first();

        // If coupon exists, return the amount, else return an error
        if ($coupon) {
            return response()->json([
                'status' => 'success',
                'amount' => $coupon->amount,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or inactive code.',
        ], 404);
    }

    public function validateCode_voucher(Request $request)
    {
        $code = $request->input('code');
        // $type = $request->input('type'); // 'coupon' or 'voucher'

        $currentDate = Carbon::now();
            
        $voucher =  DB::table('loyalty_voucher_master')
                        ->where('code', $code)
                        // ->where(function ($query) use ($currentDate){
                        //     // Check if current date is within the start_date and end_date
                        //     $query->whereNull('validity')->orWhere('validity', '>=', $currentDate);
                        // })
                        ->first();

        // If coupon exists, return the amount, else return an error
        if ($voucher) {
            return response()->json([
                'status' => 'success',
                'amount' => $voucher->amount,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid or inactive code.',
        ], 404);
    }

 
    public function insert(Request $request)
        {
 

            // dd($request);
                $validator = $request->validate([
                    'customer' => 'required', 
                    //'refno' => 'required', 
                    'partner3' => 'required', 
                ]);


                $date = $request->DocuDate;
                $formattedDate = Carbon::parse($date)->format('d-m-Y');
                //dd($request);
                // DB::enableQueryLog(); // Start query log
                $docnum = $request->doc_list . "-" . $request->docNumber;
                $incoming_master = IncomingPaymentMaster::create([
                    'Series' => null,
                    'DocNum' => $docnum,
                    'DocType' => $request->account_type,
                    'Canceled' => null,
                    'DocStatus' => $request->status,
                    'ObjType' => null,
                    'DocDate' => $request->DocuDate,
                    'CreateDate' => $request->DocuDate,//$request->posting_date,
                    'DocTime' => null,
                    'DocDueDate' => $request->delivery_date,
                    'TaxDate' => $request->delivery_date,
                    'CardCode' => $request->customer,
                    'CardName' => null,
                    'RefNo' => $request->refno,
                    'Address' => $request->bill_to_address,
                    'UserCode' => null,
                    'SalesManCode' => auth()->user()->id,//$request->partner3,
                    'SalesManName' => auth()->user()->name,
                    'Remarks' => $request->remarks,
                    'CashAcct' => $request->cash_acc,
                    'CashSum' => $request->cash_sum,
                    'CheckAcct' => $request->cheque_acc,
                    'CheckSum' => $request->cheque_sum,
                    'CheckDate' => $request->cheque_date,
                    'CheckNo' => $request->cheque_no,
                    'CheckBank' => $request->cheque_bank,
                    'CheckBranch' => $request->cheque_branch,
                    'CardAcct' => $request->card_acc,
                    'CardSum' => $request->card_sum,
                    'CardType' => $request->card_type,
                    'CardNo' => $request->card_no,
                    'CardValid' => $request->card_valid,
                    'VoucherNo' => $request->voucher_no,
                    'TransAcct' => $request->bankt_acc,
                    'TransSum' => $request->transfer_sum,
                    'TransDate' => $request->transfer_date,
                    'TransRef' => $request->transfer_ref,
                    'DocTotal' => $request->doctotal,
                    'MachineID' => null,
                    'Branch' => session('branch_code'),
                    'TotalPaySum' => $request->totalpayment,
                    'IntgrStatus' => $request->status,
                    'IntgrateStatus' => 'Y',
                    'LoyaltyPoint' => $request->loyalty_point,
                    'LVoucherNo' => $request->lvoucher_no,
                    'LVoucherAmount' => $request->v_amount,
                    'LCouponNo' => $request->coupon_no,
                    'LCouponAmount' =>$request->c_amount,
                    'CardCode1' => null,
                    'GUIDNo' => null,
                ]);
                //  dd(DB::getQueryLog()); // Dump the executed queries
                $master_id = $incoming_master->DocEntry ?? DB::getPdo()->lastInsertId();

                if(isset($request->loyalty_point))
                {
                DB::table('customers')
                ->where('customer_code', $request->customer)
                ->update([
                    'loyalty_point' => DB::raw("loyalty_point - $request->loyalty_point")
                ]);
                }
                        if($request->account_type == 'customer')
                        {
                            if(isset($request->rows))
                            {
                                foreach ($request->rows as $row) {
                                    if (isset($row['checked']) && $row['checked'] == '1') {
                                    
                                        DB::table('incomingpayments_lines')->insert([
                                            'LineNum' => $master_id,
                                            'BaseType' => 13,
                                            'BaseEntry' => null,
                                            'InvDocNum' =>$row['doc_num'],
                                            'sales_emp_name' =>auth()->user()->name,
                                            'InvSeries' => null,
                                            'InvDocDate' => $formattedDate,
                                            'InvDocTotal' => $row['total'],
                                            'SumApplied' => $row['sum_applied'],
                                            'LineStatus' => null,
                                            'CostCenter1' => $row['cost_centre'] ?? NULL,
                                            'CostCenter2' => null,
                                            'CostCenter3' => null,
                                            'CostCenter4' => null,
                                            'CostCenter5' => null,
                                            'IsChecked' => 'Y',
                                            'Branch' => session('branch_code'),
                                            'InvGUID' => null,
                                        ]);
                                        $sumapp = $row['sum_applied'];

                                        $newAppliedAmount = DB::table('sales_invoice_masters')
                                            ->where('doc_num', $row['doc_num'])
                                            ->value(DB::raw("ROUND(applied_amount + $sumapp, 2)"));

                                        DB::table('sales_invoice_masters as i')
                                            ->where('i.doc_num', $row['doc_num'])
                                            ->update([
                                                'applied_amount' => $newAppliedAmount,
                                                'status' => DB::raw("
                                                    CASE 
                                                        WHEN total = $newAppliedAmount THEN 'Confirm' 
                                                        ELSE status 
                                                    END
                                                "),
                                            ]);


                                    }
                                }
                            }
                        }

                 if($request->account_type == 'account')
                {

                    $accountlist = is_array($request->accountlist) ? $request->accountlist : [];
                    $acc_code = is_array($request->acc_code) ? $request->acc_code : [];
                    $accountname = is_array($request->accountname) ? $request->accountname : [];
                    $desc = is_array($request->desc) ? $request->desc : [];
                    $sum_applied = is_array($request->sum_applied) ? $request->sum_applied : [];
                    $cost_centre = is_array($request->cost_centre1) ? $request->cost_centre1 : [];

                    $count = count($accountlist);
                    $lineNo = 1;
                    $grand_total = 0;

                        for ($i = 0; $i < $count; $i++) 
                        {
                            if (!empty($accountlist[$i]) && !empty($acc_code[$i])) 
                            {
                                $costCenter = isset($cost_centre[$i]) ? $cost_centre[$i] : null;
                                DB::table('incomingpayments_lines2')->insert([
                                    'LineNum' => $master_id,  // Line number can be index-based
                                    'AcctCode' => $acc_code[$i],
                                    'AcctName' => $accountname[$i],
                                    'Description' => $desc[$i],
                                    'SumApplied' => $sum_applied[$i],
                                    'CostCenter1' => $costCenter,
                                    'CostCenter2' => null, // Set as needed
                                    'CostCenter3' => null, // Set as needed
                                    'CostCenter4' => null, // Set as needed
                                    'CostCenter5' => null, // Set as needed
                                    'Branch' => session("branch_code"),    
                                ]);

                            }
                        }
                }   

                    session()->flash('success', 'Incoming payment added successfully');
                    return response()->json([
                        'success' => true,
                        'incomingpayment_id' => $master_id, 
                        'message' => 'Incoming payment added successfully'
                    ]);


        }

        public function download_excel(Request $request)
        {
            try 
            {
                $data = DB::table('incoming_payment_masters')
                    ->join('customers', 'incoming_payment_masters.CardCode', '=', 'customers.customer_code')
                    ->join('partners', 'incoming_payment_masters.SalesManCode', '=', 'partners.partner_code')
                    ->select(
                        'incoming_payment_masters.DocNum',
                        'incoming_payment_masters.IntgrStatus',
                        'incoming_payment_masters.DocDate',
                        'partners.name as partner_name',
                        'customers.customer_code',
                        'customers.name as customer_name'
                    );
        
                if (!Auth::user()->hasRole('Admin')) {
                    $data->where(function ($query) {
                        $query->where('manager1', Auth::user()->id)
                            ->orWhere('manager2', Auth::user()->id)
                            ->orWhere('createdBy', Auth::user()->id);
                    });
                }
        
                if (!empty($request->from_date)) {
                    $data->where('incoming_payment_masters.DocDate', '>=', $request->from_date);
                }
                if (!empty($request->to_date)) {
                    $data->where('incoming_payment_masters.DocDate', '<=', $request->to_date);
                }
                if (!empty($request->customer)) {
                    $data->where('incoming_payment_masters.CardCode', $request->customer);
                }
                if (!empty($request->user)) {
                    $data->where('incoming_payment_masters.SalesManCode', $request->user);
                }
                if (!empty($request->status)) {
                    if ($request->status == "All") {
                        $data->whereIn('incoming_payment_masters.IntgrStatus', $request->stsval);
                    } else {
                        $data->where('incoming_payment_masters.IntgrStatus', $request->status);
                    }
                } else {
                    $data->where('incoming_payment_masters.IntgrStatus', '!=', 'Cancel');
                }
        
                $data->where('incoming_payment_masters.Branch', session('branch_code'));
                $data->orderBy('DocDate', "desc");
        
                $file_name = 'incoming-payment-' . time() . '.xlsx';
        
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
            $goodsreturn = IncomingPaymentMaster::find($id);
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

            // Added for getting the customer details
    public function get_customer_details(Request $request)
    {
        // dd($request);
        if(isset($request['customer_code']))
        {
            // Fetch the customer details
            $data = Customer::where('customer_code', $request['customer_code'])
                            ->where('is_active', 1)
                            ->first();
    
            // Fetch the quotations related to the customer
            $purchaseinvoice = DB::table('sales_invoice_masters as q')
                            // ->join('sales_invoice_items as qt', 'q.id', '=', 'qt.sm_id')
                            ->where('q.status', 'Open')
                            ->where('q.cid', $request['customer_code'])
                            ->where('q.branch', session('branch_code'))
                            ->select('q.doc_num','q.doc_date','q.total','q.applied_amount')
                            // ->where(function ($query) {
                            //     $query->where('qt.status', '<>', 'Cancel')
                            //         ->where('qt.status', '<>', 'Confirm');
                            // }) // Exclude items with 'Cancel' or 'Confirm' status
                            // ->groupBy('q.id', 'q.doc_num')
                            ->get();
    
            // Return both the customer details and quotations in the JSON response
            return response()->json([
                'customer' => $data,
                'purchaseinvoice' => $purchaseinvoice
            ]);
        }
    }

    public function get_edit_customer_details(Request $request)
    {
        if(isset($request['customer_code']))
        {
            // Fetch the customer details
            $data = Customer::where('customer_code', $request['customer_code'])
                            ->where('is_active', 1)
                            ->first();
    
            // Fetch the quotations related to the customer
            $purchase_order = DB::table('purchase_invoice_masters as q')
                            ->join('purchase_invoice_items as qt', 'q.id', '=', 'qt.sm_id')
                            ->where('q.status', 'Open')
                            ->where('q.cid', $request['customer_code'])
                            ->where(function ($query) {
                                $query->where('qt.status', '<>', 'Confirm');
                            }) // Exclude items with 'Cancel' or 'Confirm' status
                            ->select('q.id', 'q.doc_num')
                            ->groupBy('q.id', 'q.doc_num')
                            ->get();
    
            // Return both the customer details and quotations in the JSON response
            return response()->json([
                'customer' => $data,
                'purchaseorder' => $purchase_order
            ]);
        }
    }


    public function get_customer_open_purchase_invoice(Request $request)
    {
        if(isset($request['customer_code']))
        {
            // $data = Customer::where('customer_code',$request['customer_code'])
            // ->where('is_active',1)->first();

            $purchase_invoice = DB::table('purchase_invoice_masters as q')
            ->join('purchase_invoice_items as qt', 'q.id', '=', 'qt.sm_id')
            ->where('q.status', 'open') // Only open quotations
            ->where('q.cid', $request['customer_code']) // Customer-specific quotations
            ->where(function ($query) {
                $query->where('qt.status', '<>', 'Cancel')
                    ->where('qt.status', '<>', 'Confirm');
            }) // Exclude items with 'Cancel' or 'Confirm' status
            ->select('q.id', 'q.doc_num')
            ->groupBy('q.id', 'q.doc_num')
            ->get();
                
                return response()->json($purchase_invoice);
        
        }
    }

    public function get_edit_customer_open_grpo(Request $request)
    {
        if(isset($request['customer_code']))
        {
            // $data = Customer::where('customer_code',$request['customer_code'])
            // ->where('is_active',1)->first();

            $purchase_order = DB::table('purchase_invoice_masters as q')
            ->join('purchase_invoice_items as qt', 'q.id', '=', 'qt.sm_id')
            ->where('q.status', 'open') // Only open quotations
            ->where('q.cid', $request['customer_code']) // Customer-specific quotations
            ->where(function ($query) {
                $query->where('qt.status', '<>', 'Confirm');
            }) // Exclude items with 'Cancel' or 'Confirm' status
            ->select('q.id', 'q.doc_num')
            ->groupBy('q.id', 'q.doc_num')
            ->get();
                
                return response()->json($purchase_order);
        
        }
    }
    public function get_purchase_invoice_details (Request $request)
    {
        if ($request->ajax()) {

            $grpoId = $request['grpo'];
   
            $salesorders = DB::table('purchase_invoice_masters')
                ->join('purchase_invoice_items', 'purchase_invoice_masters.id', '=', 'purchase_invoice_items.sm_id')
                ->join('products', 'purchase_invoice_items.item_id', '=', 'products.productCode')
                ->join('product_stocks', 'products.productCode', '=', 'product_stocks.productCode')
                ->join('warehouses', 'product_stocks.whsCode', '=', 'warehouses.whsCode')
                ->join('customers', 'purchase_invoice_masters.cid', '=', 'customers.customer_code')
                ->whereIn('purchase_invoice_masters.id', $grpoId) // equivalent to WHERE IN (4, 2)
                // ->where('purchase_invoice_items.status', '=', 'Open')
                ->where(function ($query) {
                    $query->where('purchase_invoice_items.status', '<>', 'Cancel')
                        ->where('purchase_invoice_items.status', '<>', 'Confirm')
                        ->where('purchase_invoice_items.qty', '<>', 0);
    
                })
                ->select(
                    'purchase_invoice_masters.*', 
                    'purchase_invoice_items.*', 
                    'products.productCode', 
                    'products.productName', 
                    'product_stocks.whsCode', 
                    'warehouses.whsName', 
                    'customers.*',
                    'purchase_invoice_items.line_total', 
                    'purchase_invoice_items.qty', 
                    'purchase_invoice_items.unit_price', 
                    'purchase_invoice_items.tax_code',
                    'purchase_invoice_items.id', 
                    'purchase_invoice_items.serial_no', 
                    'purchase_invoice_items.status'
                )
                ->get();
   
            $responseData = $salesorders->map(function($item) {
                $line_total = round($item->line_total, 2);
                return [
                    'productCode' => $item->productCode,
                    'productName' => $item->productName,
                    'Qty' => $item->qty,
                    'UnitPrice' => round($item->unit_price, 2),
                    'TaxCode' => $item->tax_code,
                    'whsCode' => $item->whsCode,
                    'whsName' => $item->whsName,
                    'LineTotal' => $line_total,
                    'itemid' => $item->id,
                    'serialno' => $item->serial_no, // Placeholder value, replace as needed
                    'status' => $item->status,
                    'action' => '<button class="remove-row btn btn-danger btn-sm" value="' . $item->id . '">Remove</button>'
                ];
            });
   
   
            return response()->json(['success' => true, 'data' => $responseData], 200);
        }
   
        return response()->json(['error' => 'Invalid request.'], 400);    
    }

    public function get_edit_grpo_details (Request $request)
    {
        // dd($request);
        if ($request->ajax()) {

            $grpoId = $request['grpo'];
   
            $salesorders = DB::table('purchase_invoice_masters')
                ->join('purchase_invoice_items', 'purchase_invoice_masters.id', '=', 'purchase_invoice_items.sm_id')
                ->join('products', 'purchase_invoice_items.item_id', '=', 'products.productCode')
                ->join('product_stocks', 'products.productCode', '=', 'product_stocks.productCode')
                ->join('warehouses', 'product_stocks.whsCode', '=', 'warehouses.whsCode')
                ->join('customers', 'purchase_invoice_masters.cid', '=', 'customers.customer_code')
                ->whereIn('purchase_invoice_masters.id', $grpoId) // equivalent to WHERE IN (4, 2)
                // ->where('purchase_invoice_items.status', '=', 'Open')
                // ->where(function ($query) {
                //     $query->where('purchase_invoice_items.status', '<>', 'Confirm')
                //         ->where('purchase_invoice_items.qty', '<>', 0);
    
                // })
                ->select(
                    'purchase_invoice_masters.*', 
                    'purchase_invoice_items.*', 
                    'products.productCode', 
                    'products.productName', 
                    'product_stocks.whsCode', 
                    'warehouses.whsName', 
                    'customers.*',
                    'purchase_invoice_items.line_total', 
                    'purchase_invoice_items.qty', 
                    'purchase_invoice_items.unit_price', 
                    'purchase_invoice_items.tax_code',
                    'purchase_invoice_items.id', 
                    'purchase_invoice_items.serial_no', 
                    'purchase_invoice_items.status'
                )
                ->get();
   
            $responseData = $salesorders->map(function($item) {
                $line_total = round($item->line_total, 2);
                return [
                    'productCode' => $item->productCode,
                    'productName' => $item->productName,
                    'Qty' => $item->qty,
                    'UnitPrice' => round($item->unit_price, 2),
                    'TaxCode' => $item->tax_code,
                    'whsCode' => $item->whsCode,
                    'whsName' => $item->whsName,
                    'LineTotal' => $line_total,
                    'itemid' => $item->id,
                    'serialno' => $item->serial_no, // Placeholder value, replace as needed
                    'status' => $item->status,
                    'action' => '<button class="remove-row btn btn-danger btn-sm" value="' . $item->id . '">Remove</button>'
                ];
            });
   
   
            return response()->json(['success' => true, 'data' => $responseData], 200);
        }
   
        return response()->json(['error' => 'Invalid request.'], 400);    
    }

    public function purchaseorder_close_items(Request $request)
    {
        $id=$request['item'];
        $purchased_item = PurchaseOrderItem::find($id);
        $data = '';
        if ($purchased_item) {
            $purchased_item->status = 'Cancel';
            $purchased_item->save();
            $data = "Purchase order item is cancelled!";
        }
        echo json_encode($data);
    }


    public function incoming_get_account_code(Request $request)
    {
        $accountId = $request->input('account_id');
        // Fetch the account code from the database
        $account = DB::table('account_masters as a')
        ->where('a.AcctCode', 'like', '%' . $accountId . '%')
        ->first();
        if ($account) {
           return response()->json([
                'status' => 'success',
                'account_code' => $accountId, // Assuming `code` is the field
                'account_name' => $account->AcctName, // Assuming `code` is the field
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Account not found.',
        ], 404);

    }

}
