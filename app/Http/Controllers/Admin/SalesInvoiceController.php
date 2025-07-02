<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Partner;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductPrice;
use App\Models\CustomQuotation;
use App\Models\SalesInvoiceMaster;
use App\Models\SalesInvoiceItem;
use App\Models\SalesOrderItem;
use App\Models\SalesOrderMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;
use App\Jobs\GenerateInvoiceAndSendEmail;
use Illuminate\Support\Facades\Log;


class SalesInvoiceController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            if (Auth::user()->hasRole('Admin')) {
                $data = SalesOrderMaster::select('sales_order_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3','user'));
            } else {
                $data = SalesOrderMaster::select('sales_order_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3','user'))
                    ->where(function ($query) {
                        $query->Where('createdBy', Auth::user()->id);
                    });
            }
            if (!empty($request->from_date)) {
                //echo "here";
                $data->where('doc_date', '>=', $request->from_date);
            }
            if (!empty($request->to_date)) {
                //echo "here";
                $data->where('doc_date', '<=', $request->to_date);
            }
            if (!empty($request->customer)) {
                //echo "here";
                $data->where('sales_order_masters.cid', $request->customer);
            }
            if (!empty($request->user)) {
                //echo "here";
                $data->where('sales_order_masters.createdBy', $request->user);
            }
            if (!empty($request->status)) {
                if ($request->status == "All") {
                    $data->where('sales_order_masters.status', '!=', 'Cancel');
                } else {
                    $data->where('sales_order_masters.status', $request->status);
                }
            } else {
                $data->where('sales_order_masters.status', 'Open');
            }
                $data->where('sales_order_masters.branch', session('branch_code'));

                $data->orderBy('cid', 'desc');

                // dd($data);
                return Datatables::of($data)
                ->addColumn('DocNo', function ($row) {
                    if ($row->doc_num)
                        return $row->doc_num;
                    else
                        return null;

                })
                ->addColumn('action', function ($row) {
                    $url = url('admin/sales-order/' . $row->id);
                    $url_edit = url('admin/sales-order/' . $row->id . '/edit');
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
                    if ($row->cid && $row->doc_date) {
                        return \Carbon\Carbon::parse($row->doc_date)->format('d-m-Y');
                    } else {
                        return null;
                    }
                })

                ->addColumn('delivery_date', function ($row) {
                    if ($row->cid)
                     return \Carbon\Carbon::parse($row->delivery_date)->format('d-m-Y');
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
                    if ($row->total)
                        return $row->total;
                    else
                        return null;

                })
               
                ->addColumn('status_show', function ($row) {
                    $row->status_show = $row->status;
                    if ($row->status == 'Cancel')
                        $row->status_show = 'Cancelled';
                    elseif ($row->status == 'Approve')
                        $row->status_show = 'Approved';
                    elseif ($row->status == 'Confirm')
                        $row->status_show = 'Confirmed';
                    return $row->status_show;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.salesinvoice');
    }

    public function create()
    {
        return view('admin.create_salesinvoice');
    }

        // Added for getting the customer details
        public function get_customer_details(Request $request)
        {

            if(isset($request['customer_code']))
            {
                // Fetch the customer details
                $data = Customer::where('customer_code', $request['customer_code'])
                                ->where('is_active', 1)
                                ->first();
        
                // Fetch the quotations related to the customer
                $sales_order = DB::table('sales_order_masters as s')
                                ->join('sales_order_items as st', 's.id', '=', 'st.sm_id')
                                ->where('s.status', 'Open')
                                ->where('s.branch', session('branch_code'))
                                ->where('s.cid', $request['customer_code'])
                                ->select('s.id', 's.doc_num')
                                ->groupBy('s.id', 's.doc_num')
                                ->get();
        
                // Return both the customer details and quotations in the JSON response
                return response()->json([
                    'customer' => $data,
                    'salesorder' => $sales_order
                ]);
            }
        }


        // Added for getting the customer open quotations
    public function get_customer_open_salesorders(Request $request)
    {
        if(isset($request['customer_code']))
        {
            $query = DB::table('sales_order_masters as s')
            ->join('sales_order_items as st', 's.id', '=', 'st.sm_id')
            ->where('s.status', 'Open')
            ->where('s.branch', session('branch_code'))->where('s.sales_emp_id', Auth::user()->id)
            ->where('s.cid', $request['customer_code'])
            ->where(function ($query) {
                $query->where('st.status', '<>', 'Cancel')
                    ->where('st.status', '<>', 'Confirm')
                    ->where('st.open_qty', '<>', 0);
            })
            ->select('s.id', 's.doc_num')
            ->groupBy('s.id', 's.doc_num')
            ->get();
            // dd($query->toSql(), $query->getBindings());
                return response()->json($query);
        }
    }   

    public function edit($id)
    {
        $details = SalesInvoiceMaster::select('sales_invoice_masters.*')->with(array('Item_details.products.stock','customer','referral1','referral2','referral3'))->find($id); 
        return view('admin.edit_salesinvoice', compact('details'));
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
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = Customer::select("*")->where('is_active',1)
            ->where(function($query) use ($search){$query->where('name','LIKE',"%$search%")
            ->orWhere('phone','LIKE',"%$search%");
            })
            ->skip($offset)->take($resultCount)->get();

            $count = Customer::select("id","phone","name")
            ->where('is_active',1)
            ->where(function($query) use ($search){$query->where('name','LIKE',"%$search%")
            ->orWhere('phone','LIKE',"%$search%");
            })->count();

        }
        else{
        /** get the users**/
        $data = Customer::select("*")->where('is_active',1)->skip($offset)->take($resultCount)->get();

        $count =Customer::select("id","phone","name")->where('is_active',1)->count();
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
    // Validate input
    $request->validate([
        'customer' => 'required',
        'product' => 'required|array|min:1',
        'quantity' => 'required|array|min:1'
    ]);

    // Find SalesInvoiceMaster
    $salesinvoice = SalesInvoiceMaster::find($id);
    if (!$salesinvoice) {
        return redirect()->back()->with('error', 'Sales invoice not found');
    }

    // Update SalesInvoiceMaster
    $salesinvoice->cid = $request->customer;
    $salesinvoice->ref_no = $request->refno;
    $salesinvoice->address_bill = $request->bill_to_address;
    $salesinvoice->posting_date = $request->DocuDate;
    $salesinvoice->docdue_date = $request->delivery_date;
    $salesinvoice->doc_date = $request->DocuDate;
    $salesinvoice->payment_term = $request->payment_term;
    $salesinvoice->tax_regno = $request->tax_reg_no;
    $salesinvoice->sales_emp_id = auth()->id();
    $salesinvoice->remarks = $request->remarks;
    $salesinvoice->total_bf_discount = $request->total_bef_discount;
    $salesinvoice->discount_percent = $request->discount;
    $salesinvoice->discount_amount = $request->discount_amount_value;
    $salesinvoice->total_exp = $request->expense;
    $salesinvoice->tax_amount = $request->tax_amount;
    $salesinvoice->rounding = $request->roundtext;
    $salesinvoice->total = $request->grand_total;
    $salesinvoice->updatedBy = auth()->id();
    $salesinvoice->save();
  

    // Get related SalesInvoiceItem order_item_ids
    $orderItemIds = SalesInvoiceItem::where('sm_id', $id)->pluck('order_item_id')->toArray();
    // Get the first related SalesOrderMaster ID
    $som_id = SalesOrderItem::whereIn('id', $orderItemIds)->pluck('sm_id')->first();
// dd($som_id);
    if ($som_id==null) {
        // return redirect()->back()->with('error', 'Sales Order not found');
        return redirect('admin/sales-invoice')->with('error', 'Sales Order not found');

    }
    else
    {

            $salesorder = SalesOrderMaster::find($som_id);
            if (!$salesorder) {
                return redirect()->back()->with('error', 'Sales Order Master not found');
            }

            // Update SalesOrderMaster
            $salesorder->cid = $request->customer;
            $salesorder->ref_no = $request->refno;
            $salesorder->add_type_bill_to = $request->bill_to;
            $salesorder->add_type_ship_to = $request->ship_to;
            $salesorder->address_bill = $request->bill_to_address;
            $salesorder->address_ship = $request->bill_to_address;
            $salesorder->pl_supply = $request->place_of_sply;
            $salesorder->tax_type = $request->tax_type;
            $salesorder->posting_date = $request->DocuDate;
            $salesorder->delivery_date = $request->delivery_date;
            $salesorder->doc_date = $request->DocuDate;
            $salesorder->payment_term = $request->payment_term;
            $salesorder->tax_regno = $request->tax_reg_no;
            $salesorder->open_quotation = $request->open_qutn ?? 0;
            $salesorder->sales_emp_id = auth()->id();
            $salesorder->remarks = $request->remarks;
            $salesorder->total_bf_discount = $request->total_bef_discount;
            $salesorder->discount_percent = $request->discount;
            $salesorder->discount_amount = $request->discount_amount_value;
            $salesorder->total_exp = $request->expense;
            $salesorder->tax_amount = $request->tax_amount;
            $salesorder->rounding = $request->roundtext;
            $salesorder->total = $request->grand_total;
            $salesorder->updatedBy = auth()->id();
            $salesorder->save();

            // Delete old items
            SalesInvoiceItem::where('sm_id', $id)->delete();
            SalesOrderItem::whereIn('id', $orderItemIds)->delete();

            // Re-insert updated items
            $products   = $request->product;
            $warehouses = $request->whscode;
            $units      = $request->unit;
            $quantities = $request->quantity;
            $lineTotals = $request->linetotal;
            $unitPrices = $request->unitprice;
            $discPrices = $request->discprice;
            $taxCodes   = $request->taxcode;
            $serialNos  = $request->serialno;

            for ($i = 0; $i < count($products); $i++) {
                if (!empty($products[$i]) && !empty($quantities[$i]) && !empty($warehouses[$i])) {
                    // Create new SalesOrderItem
                    $soItem = new SalesOrderItem();
                    $soItem->sm_id      = $som_id;
                    $soItem->item_id    = $products[$i];
                    $soItem->unit       = $units[$i];
                    $soItem->whs_code   = $warehouses[$i];
                    $soItem->qty        = $quantities[$i];
                    $soItem->open_qty   = 0;
                    $soItem->unit_price = $unitPrices[$i];
                    $soItem->disc_price = $discPrices[$i];
                    $soItem->tax_code   = $taxCodes[$i];
                    $soItem->line_total = $lineTotals[$i];
                    $soItem->serial_no  = $serialNos[$i];
                    $soItem->status     = 'Confirm';
                    $soItem->save();

                    // Create corresponding SalesInvoiceItem
                    $siItem = new SalesInvoiceItem();
                    $siItem->sm_id        = $id;
                    $siItem->order_item_id = $soItem->id;
                    $siItem->item_id      = $products[$i];
                    $siItem->unit         = $units[$i];
                    $siItem->whs_code     = $warehouses[$i];
                    $siItem->qty          = $quantities[$i];
                    $siItem->open_qty     = $quantities[$i];
                    $siItem->unit_price   = $unitPrices[$i];
                    $siItem->disc_price   = $discPrices[$i];
                    $siItem->tax_code     = $taxCodes[$i];
                    $siItem->line_total   = $lineTotals[$i];
                    $siItem->serial_no    = $serialNos[$i];
                    $siItem->status     = 'Open';
                    $siItem->save();
                }
            }

            // Final update to SalesInvoiceMaster
            $salesinvoice->e_status = 'Yes';
            $salesinvoice->save();

            return redirect('admin/sales-invoice')->with('success', 'Sales Invoice updated successfully');
}
}


   



        public function insert(Request $request)
        {
            $validator = $request->validate([
                'customer' => 'required',
                'product' => 'required|array|min:1',
                'quantity' => 'required|array|min:1'
            ]);

            $docnum = $request->doc_list . "-" . $request->docNumber;
        
            $exists = SalesInvoiceMaster::where('doc_num', $docnum)->exists();

            if ($exists) {
                return back()->withErrors(['docnum' => 'This Document Number already exists.'])->withInput();
            }
            $latestBillNo = SalesInvoiceMaster::max('bill_no');
            $bill_no = $latestBillNo ? $latestBillNo + 1 : 111111;

            $salesinvoice = new SalesInvoiceMaster;
            $salesinvoice->cid = $request->customer;
            $salesinvoice->ref_no = $request->refno;
            $salesinvoice->bill_no = $bill_no;
            $salesinvoice->address_bill = $request->bill_to_address;
            $salesinvoice->scan_here = $request->scan_here;
            $salesinvoice->doc_num = $docnum;
            $salesinvoice->status = $request->status;
            $salesinvoice->branch = session('branch_code');
            $salesinvoice->posting_date = $request->posting_date;
            $salesinvoice->docdue_date = $request->delivery_date;
            $salesinvoice->doc_date = $request->DocuDate;
            $salesinvoice->payment_term = $request->payment_term;
            $salesinvoice->tax_regno = $request->tax_reg_no;
            $salesinvoice->open_salesorder = $request->open_qutn ? $request->open_qutn : 0;
            $salesinvoice->sales_emp_id = auth()->user()->id;
            $salesinvoice->remarks = $request->remarks;
            $salesinvoice->total_bf_discount = $request->total_bef_discount;
            $salesinvoice->discount_percent = $request->discount;
            $salesinvoice->discount_amount = $request->discount_amount_value;
            $salesinvoice->total_exp = $request->expense;
            $salesinvoice->tax_amount = $request->tax_amount;
            $salesinvoice->rounding = $request->roundtext;
            $salesinvoice->total = $request->grand_total;
            $salesinvoice->applied_amount = 0;
            $salesinvoice->createdBy = Auth::user()->id;
            $salesinvoice->updatedBy = null;
            $salesinvoice->save();

            $salesinvoice_id = $salesinvoice->id;

            $total = $request->grand_total;
            if ($total > 0) {
                $lpoint = $total * (env('LOYALTY_POINT') / 100);
                $lpoint_in_rs = round($lpoint, 2);

                $customer = Customer::where('customer_code', $request->customer)->first();
                if ($customer) {
                    $currentPoints = $customer->loyalty_point ?? 0;
                    $customer->update(['loyalty_point' => $currentPoints + $lpoint_in_rs]);
                    $customername = $customer->name;
                    $customerphone = $customer->alt_phone;
                    $country_code = $customer->country_code;
                    $customeremail = $customer->email;
                }
            }

            $products = $request->product ?? [];
            $quotation_item_id = $request->quotation_item_id ?? [];
            $warehouses = $request->whscode ?? [];
            $unit = $request->unit ?? [];
            $quantity = $request->quantity ?? [];
            $av_quantity = $request->av_quantity ?? [];
            $LineTotal = $request->linetotal ?? [];
            $unitprice = $request->unitprice ?? [];
            $discprice = $request->discprice ?? [];
            $taxcode = $request->taxcode ?? [];
            $serialno = $request->serialno ?? [];
            $warrenty = $request->warrenty ?? [];

            $count = count($products);

            for ($i = 0; $i < $count; $i++) {
                if (!isset($quantity[$i]) || !$quantity[$i]) {
                    $quantity[$i] = 1;
                }

                if (!empty($products[$i]) && !empty($quantity[$i])) {

                    if (isset($av_quantity[$i]) && isset($quotation_item_id[$i]) && $av_quantity[$i] != '0' && $quotation_item_id[$i] != '0') {
                        $balance_qty = $av_quantity[$i] - $quantity[$i];
                        $quotationitem = SalesOrderItem::find($quotation_item_id[$i]);

                        if ($quotationitem) {
                            if ($balance_qty > 0) {
                                $quotationitem->open_qty = $balance_qty;
                                $quotationitem->line_total = $balance_qty * ($discprice[$i] ?? 0);
                            } else {
                                $quotationitem->open_qty = $balance_qty;
                                $quotationitem->status = 'Confirm';
                            }
                            $quotationitem->save();

                            if ($quotationitem->sm_id) {
                                $pmaster = DB::table('sales_order_items')
                                    ->where('sm_id', $quotationitem->sm_id)
                                    ->get();

                                if ($pmaster->every(fn($item) => $item->status === 'Confirm')) {
                                    DB::table('sales_order_masters')
                                        ->where('id', $quotationitem->sm_id)
                                        ->update(['status' => 'Confirm']);
                                } else {
                                    DB::table('sales_order_masters')
                                        ->where('id', $quotationitem->sm_id)
                                        ->update(['status' => 'Confirm']);
                                }
                            }
                        }
                    }

                    $salesinvoiceItem = new SalesInvoiceItem;
                    $salesinvoiceItem->sm_id = $salesinvoice_id;
                    $salesinvoiceItem->order_item_id = $quotation_item_id[$i] ?? 0;
                    $salesinvoiceItem->item_id = $products[$i];
                    $salesinvoiceItem->whs_code = $warehouses[$i];
                    $salesinvoiceItem->unit = $unit[$i];
                    $salesinvoiceItem->qty = $quantity[$i];
                    $salesinvoiceItem->open_qty = $quantity[$i];
                    $salesinvoiceItem->unit_price = $unitprice[$i];
                    $salesinvoiceItem->disc_price = $discprice[$i];
                    $salesinvoiceItem->tax_code = $taxcode[$i];
                    $salesinvoiceItem->line_total = $LineTotal[$i];
                    $salesinvoiceItem->serial_no = $serialno[$i];
                    $salesinvoiceItem->save();
                }
            }

            GenerateInvoiceAndSendEmail::dispatch($salesinvoice_id);

                //             $data = SalesInvoiceMaster::find($salesinvoice_id);
                //             $cinfo = DB::table('company_infos')->first();
                //             $html = view('admin.pdf_invoice', compact('data', 'cinfo'))->render();
                // try {
                //             set_time_limit(300);
                //             $pdf = Pdf::loadHTML($html)
                //                 ->setPaper('A4', 'portrait')
                //                 ->setOptions([
                //                     'isHtml5ParserEnabled' => true,
                //                     'isRemoteEnabled' => true,
                //                 ]);

                //             $path = public_path('pdf/');
                //             $filename = 'invoice_' . $salesinvoice_id . '.pdf';

                //             if (!File::exists($path)) {
                //                 File::makeDirectory($path, 0755, true);
                //             }

                //             file_put_contents($path . $filename, $pdf->output());

                //             $pdfPath = $path . $filename;
                //             $customeremails = $customeremail ?? 'mmdjfoodsupplies@gmail.com';
                //             Mail::to($customeremails)->send(new InvoiceMail($customer, $cinfo, $pdfPath));
                // } catch (\Exception $e) {
                //     Log::error('PDF or Email error: ' . $e->getMessage());
                //     Log::error($e->getTraceAsString());
                // }
            session()->flash('success', 'Sales Invoice added successfully');
            return redirect('admin/sales-invoice')->with('success', 'Sales Invoice added successfully');
        }




    
    public function get_salesorder_details(Request $request)
    {
        if ($request->ajax()) {

            $sorderId = $request['salesorder'];

            // $salesorders = SalesOrderMaster::with([
            //     'items' => function($query) {
            //         $query->where('status', '!=', 'Cancel');
            //     },
            //     'items.products.stock.warehouse',
            //     'customer',
            //     'referral1',
            //     'referral2'
            // ])->whereIn('sales_order_masters.id', $sorderId)->get();



            $salesorders = DB::table('sales_order_masters')
                ->join('sales_order_items', 'sales_order_masters.id', '=', 'sales_order_items.sm_id')
                ->join('users', 'sales_order_masters.sales_emp_id', '=', 'users.id')
                ->join('products', 'sales_order_items.item_id', '=', 'products.productCode')
                ->join('product_stocks', 'products.productCode', '=', 'product_stocks.productCode')
                ->join('warehouses', 'product_stocks.whsCode', '=', 'warehouses.whsCode')
                ->join('customers', 'sales_order_masters.cid', '=', 'customers.customer_code')
                ->whereIn('sales_order_masters.id', $sorderId) // equivalent to WHERE IN (4, 2)
                // ->where('sales_order_items.status', '=', 'Open')
                ->where(function ($query) {
                    $query->where('sales_order_items.status', '<>', 'Cancel')
                        ->where('sales_order_items.status', '<>', 'Confirm')
                        ->where('sales_order_items.open_qty', '<>', 0);
    
                })
                ->whereNull('customers.deleted_at')
                ->select(
                    'sales_order_masters.*', 
                    'sales_order_items.*', 
                    'products.productCode', 
                    'products.productName', 
                    'product_stocks.whsCode', 
                    'warehouses.whsName', 
                    'customers.*',
                    'sales_order_items.line_total', 
                    'sales_order_items.open_qty', 
                    'sales_order_items.unit_price', 
                    'sales_order_items.disc_price', 
                    'sales_order_items.tax_code',
                    'sales_order_items.id as sitemid', 
                    'sales_order_items.serial_no', 
                    'sales_order_items.status',
                    'users.name',
                    'users.id'
                )
                ->get();
                // dd($salesorders);
                $responseData = $salesorders->map(function($item) {
                $line_total = round($item->line_total, 2);
                return [
                    'refno' => $item->ref_no,
                    'sales_emp_id' => $item->sales_emp_id,
                    'partner_name' => $item->name,
                    'tax_regno' => $item->tax_regno,
                    'remarks' => $item->remarks,
                    'productCode' => $item->productCode,
                    'productName' => $item->productName,
                    'Qty' => $item->open_qty,
                    'unit' => $item->unit,
                    'UnitPrice' => round($item->unit_price, 2),
                    'DiscPrice' => round($item->disc_price, 2),
                    'TaxCode' => $item->tax_code,
                    'whsCode' => $item->whsCode,
                    'whsName' => $item->whsName,
                    'LineTotal' => $line_total,
                    'itemid' => $item->sitemid,
                    'serialno' => $item->serial_no, // Placeholder value, replace as needed
                    'status' => $item->status,
                    'action' => '<button class="remove-row btn btn-danger btn-sm" value="' . $item->id . '">Remove</button>'
                ];
            });
//dd($salesorders);

            return response()->json(['success' => true, 'data' => $responseData], 200);
        }

        return response()->json(['error' => 'Invalid request.'], 400);
    }


    public function salesinvoice_close_items(Request $request)
    {
        //dd($request);
        $id=$request['item'];
        $quotation_item = SalesOrderItem::find($id);

        $data = '';
        if ($quotation_item) { 
            $quotation_item->status = 'Cancel';
            $quotation_item->save();
            $data = "Salesorder item is cancelled!";
        }
        echo json_encode($data);
    }

    public function get_salesinvoice_details(Request $request)
    {
        $query = $request->input('query');
        $results = Product::join('product_stocks', 'products.productCode', '=', 'product_stocks.productCode')
        ->join('product_prices', 'products.productCode', '=', 'product_prices.productCode')
        ->join('warehouses', 'product_stocks.whsCode', '=', 'warehouses.whsCode')
        ->join('itemwarehouses', 'product_stocks.productCode', '=', 'itemwarehouses.ItemCode')
        ->where('products.barcode', '=', $query)
        ->where('itemwarehouses.WhsCode', '=', session('branch_code'))
        ->get();
        return response()->json($results);
    }
    

        function get_invdoc(Request $request)
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            // ->where('id',auth()->user()->id)
            $data = SalesInvoiceMaster::select("*")
            ->where(function ($query) use ($search) {
                $query->where('doc_num','LIKE',"%$search%");
            })->skip($offset)->take($resultCount)->get();
        // ->where('id',auth()->user()->id)
            $count = SalesInvoiceMaster::select("id","doc_num")
            ->where(function ($query) use ($search) {
                $query->where('doc_num','LIKE',"%$search%");
            })->count();
        
        }
        else{
        /** get the users**/
        // $data = User::select("*")->where('id',auth()->user()->id)->skip($offset)->take($resultCount)->get();
        $data = SalesInvoiceMaster::select("*")->skip($offset)->take($resultCount)->get();
        
        $count =SalesInvoiceMaster::select("id","doc_num")->count();
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

} 