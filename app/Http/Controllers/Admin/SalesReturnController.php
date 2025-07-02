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
use App\Models\CustomQuotation;
use App\Models\SalesOrderItem;
use App\Models\SalesOrderMaster;
use App\Models\SalesInvoiceMaster;
use App\Models\SalesInvoiceItem;
use App\Models\SalesReturnMaster;
use App\Models\SalesReturnItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

use Rap2hpoutre\FastExcel\FastExcel;


class SalesReturnController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            //echo "here";
            if (Auth::user()->hasRole('Admin')) {
                $data = SalesReturnMaster::select('sales_return_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3'));
            } else {
                $data = SalesReturnMaster::select('sales_return_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3'))
                    ->where(function ($query) {
                        $query->where('manager1', Auth::user()->id)
                            ->orWhere('manager2', Auth::user()->id)
                            ->orWhere('createdBy', Auth::user()->id);
                    });
            }
            if (!empty($request->from_date)) {
                //echo "here";
                $data->where('docdue_date', '>=', $request->from_date);
            }
            if (!empty($request->to_date)) {
                //echo "here";
                $data->where('docdue_date', '<=', $request->to_date);
            }
            if (!empty($request->customer)) {
                //echo "here";
                $data->where('sales_return_masters.cid', $request->customer);
            }
            if (!empty($request->user)) {
                //echo "here";
                $data->where('sales_return_masters.sales_emp_id', $request->user);
            }
            if (!empty($request->status)) {
                if ($request->status == "All") {
                    $data->where('sales_return_masters.status', '!=', 'Cancel');
                } else {
                    $data->where('sales_return_masters.status', $request->status);
                }
            } else {
                $data->where('sales_return_masters.status', 'Open');
            }
                $data->where('sales_return_masters.branch', session('branch_code'));

                $data->orderBy('id', 'desc');
                return Datatables::of($data)
                ->addColumn('DocNo', function ($row) {
                    if ($row->doc_num)
                        return $row->doc_num;
                    else
                        return null;

                })
                ->addColumn('action', function ($row) {
                    $url = url('admin/sales-return/' . $row->id);
                    $url_edit = url('admin/sales-return/' . $row->id . '/edit');
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
                ->addColumn('DocDate', function ($row) {
                    if ($row->customer)
                        return date('d-m-Y', strtotime($row->doc_date));
                    else
                        return null;

                })
                ->addColumn('DueDate', function ($row) {
                    if ($row->customer)
                        return date('d-m-Y', strtotime($row->docdue_date));
                    else
                        return null;
                })
                // ->addColumn('referral1', function ($row) {
                //     if ($row->referral1)
                //         return $row->referral1->name;
                //     else
                //         return null;

                // })
                // ->addColumn('referral2', function ($row) {
                //     if ($row->referral2)
                //         return $row->referral2->name;
                //     else
                //         return null;

                // })
                ->addColumn('referral3', function ($row) {
                    if ($row->referral3)
                        return $row->referral3->name;
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

        return view('admin.salesreturn');
    }

    public function create()
    {
        return view('admin.create_salesreturn');
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
            $sales_invoice = DB::table('sales_invoice_masters as s')
                            ->join('sales_invoice_items as st', 's.id', '=', 'st.sm_id')
                            // ->where('s.status', 'Confirm')
                            ->where('s.branch', session('branch_code'))
                            ->where('st.open_qty', '<>', 0)
                            ->where('s.cid', $request['customer_code'])
                            ->select('s.id', 's.doc_num', DB::raw('SUM(st.qty) as total_qty'), DB::raw('MAX(st.status) as status'))
                            ->groupBy('s.id', 's.doc_num')
                            ->get();


    
            // Return both the customer details and quotations in the JSON response
            return response()->json([
                'customer' => $data,
                'salesinvoice' => $sales_invoice
            ]);
        }
    }

    public function get_customer_open_invoice(Request $request)
    {
        if(isset($request['customer_code']))
        {
            // $data = Customer::where('customer_code',$request['customer_code'])
            // ->where('is_active',1)->first();

            $invoices = DB::table('sales_invoice_masters as s')
            ->join('sales_invoice_items as st', 's.id', '=', 'st.sm_id')
            // ->where('s.status', 'Confirm') // Only open quotations
            ->where('s.branch', session('branch_code'))
            ->where('s.cid', $request['customer_code']) // Customer-specific quotations
            ->where(function ($query) {
                $query->where('st.open_qty', '<>', 0);
                    // ->where('st.status', '<>', 'Cancel')
                    // ->where('st.status', '<>', 'Confirm')
            }) // Exclude items with 'Cancel' or 'Confirm' status
            ->select('s.id', 's.doc_num')
            ->groupBy('s.id', 's.doc_num')
            ->get();
                
                return response()->json($invoices);
        
        }
    }

    public function salesreturn_close_items(Request $request)
    {
        $id=$request['item'];
        $ordered_item = SalesOrderItem::find($id);
        $data = '';
        if ($ordered_item) {
            $ordered_item->status = 'Cancel';
            $ordered_item->save();
            $data = "Ordered item is cancelled!";
        }
        echo json_encode($data);
    }


    public function edit($id)
    {
        $details = SalesReturnMaster::select('sales_return_masters.*')->with(array('Item_details.products.stock.warehouse', 'customer', 'referral1', 'referral2'))->find($id); //print_r($details);
        //echo(json_encode($details));
       
        return view('admin.edit_salesreturn', compact('details'));
    }

    public function update(Request $request, $id)
    {
        $validator = $request->validate([
            'customer' => 'required',
            'product' => 'required|array|min:1',
            'quantity' => 'required|array|min:1'
        ]);
    
        // Find existing SalesOrderMaster by id
        $salesreturn = SalesReturnMaster::find($id);
        if (!$salesreturn) {
            return redirect()->back()->with('error', 'Sales return not found');
        }
    
        // $docnum = $request->doc_list . "-" . $request->docNumber;
    
        // Update the SalesOrderMaster fields
        $salesreturn->cid = $request->customer;
        $salesreturn->ref_no = $request->refno;
        $salesreturn->address_bill = $request->bill_to_address;
        $salesreturn->address_ship = $request->ship_to_address;
        $salesreturn->pl_supply = $request->place_of_sply;
        $salesreturn->tax_type = $request->tax_type;
        //$salesreturn->doc_num = $docnum;
        $salesreturn->status = $request->status;
        $salesreturn->posting_date = $request->posting_date;
        $salesreturn->docdue_date = $request->docdue_date;
        $salesreturn->doc_date = $request->DocuDate;
        // $salesreturn->payment_term = $request->payment_term;
        $salesreturn->tax_regno = $request->tax_reg_no;
        $salesreturn->open_invoice = $request->open_qutn ? $request->open_qutn : 0;
        $salesreturn->sales_emp_id = $request->partner3;
        $salesreturn->remarks = $request->remarks;
        $salesreturn->return_reason = $request->return_reason;
        $salesreturn->damage_type = $request->damage;
        $salesreturn->total_bf_discount = $request->total_bef_discount;
        $salesreturn->discount_percent = $request->discount;
        $salesreturn->discount_amount = $request->discount_amount_value;
        $salesreturn->total_exp = $request->expense;
        $salesreturn->tax_amount = $request->tax_amount;
        $salesreturn->rounding = $request->roundtext;
        $salesreturn->total = $request->grand_total;
        $salesreturn->updatedBy = Auth::user()->id;  // You may want to track who updated it
        $salesreturn->save();
    
        // Update the SalesOrderItem details
        $products = $request->product;
        $warehouses = $request->whscode;
        $quantity = $request->quantity;
        $LineTotal = $request->linetotal;
        $unitprice = $request->unitprice;
        $discprice = $request->discprice;
        $taxcode = $request->taxcode;
        $serialno = $request->serialno;
        
        // Remove existing items first (optional, based on your needs)
        SalesReturnItem::where('sm_id', $id)->delete();
        
        // Re-insert the items with updated values
        $count = count($products);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($products[$i]) && !empty($quantity[$i]) && !empty($warehouses[$i])) {
                $salesreturnItem = new SalesReturnItem;
                $salesreturnItem->sm_id = $salesreturn->id;
                $salesreturnItem->invoice_item_id = $invoice_item_id[$i] ?? 0;
                $salesreturnItem->item_id = $products[$i];
                $salesreturnItem->whs_code = $warehouses[$i];
                $salesreturnItem->qty = $quantity[$i];
                $salesreturnItem->unit_price = $unitprice[$i];
                $salesreturnItem->disc_price = $discprice[$i];
                $salesreturnItem->tax_code = $taxcode[$i];
                $salesreturnItem->line_total = $LineTotal[$i];
                $salesreturnItem->serial_no = $serialno[$i];
                $salesreturnItem->status = "Open";
                $salesreturnItem->save();
            }
        }
    
        return redirect('admin/sales-return/' . $id)->with('success', 'Sales Return updated successfully');
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
            $data = SalesInvoiceMaster::join('customers', 'sales_invoice_masters.cid', '=', 'customers.customer_code')
            ->select('customers.id','customers.phone','customers.customer_code', 'customers.name')
            ->where('customer.is_active',1)
            ->where('sales_invoice_masters.branch', session('branch_code'))
            ->where('sales_invoice_masters.status', "Confirm")
            ->where(function($query) use ($search){$query->where('customers.name','LIKE',"%$search%")
            ->orWhere('customers.phone','LIKE',"%$search%");
            })
            ->groupBy('customers.id','customers.phone','customers.customer_code', 'customers.name')
            ->skip($offset)->take($resultCount)->get();



            $count = SalesInvoiceMaster::join('customers', 'sales_invoice_masters.cid', '=', 'customers.customer_code')
            ->select('customers.id','customers.phone','customers.customer_code', 'customers.name')
            ->where(function($query) use ($search){$query->where('customers.name','LIKE',"%$search%")
            ->orWhere('customers.phone','LIKE',"%$search%");
            })   
            ->where('sales_invoice_masters.status', "Confirm")         
            ->groupBy('customers.id','customers.phone','customers.customer_code', 'customers.name')
            ->count();

        }
        else{
        /** get the users**/
        $data = SalesInvoiceMaster::join('customers', 'sales_invoice_masters.cid', '=', 'customers.customer_code')
                ->select('customers.id','customers.phone','customers.customer_code', 'customers.name')
                ->where('sales_invoice_masters.branch', session('branch_code'))
                ->where('sales_invoice_masters.status', "Confirm")
                ->groupBy('customers.id','customers.phone','customers.customer_code', 'customers.name')
                ->skip($offset)
                ->take($resultCount)
                ->get();

        // $count =SalesInvoiceMaster::with('customer')->select("customers.id","customers.phone","customers.name")->where('customer.is_active',1)->count();

        $count = SalesInvoiceMaster::join('customers', 'sales_invoice_masters.cid', '=', 'customers.customer_code')
                ->select('customers.id','customers.phone','customers.customer_code', 'customers.name')
                ->where('sales_invoice_masters.branch', session('branch_code'))
                ->where('sales_invoice_masters.status', "Confirm")
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

     public function insert(Request $request)
    {
        //dd($request);
        $validator = $request->validate([
            'customer' => 'required', 
            'product' => 'required|array|min:1',
            'quantity' => 'required|array|min:1'
        ]);

        $docnum = $request->doc_list . "-" . $request->docNumber;
        
        $salesreturn = new SalesReturnMaster;
        $salesreturn->cid = $request->customer;
        $salesreturn->ref_no = $request->refno;
        $salesreturn->address_bill = $request->bill_to_address;
        $salesreturn->address_ship = $request->ship_to_address;
        $salesreturn->pl_supply = $request->place_of_sply;
        $salesreturn->tax_type = $request->tax_type;
        $salesreturn->doc_num = $docnum;
        $salesreturn->status = $request->status;
        $salesreturn->branch = session('branch_code');
        $salesreturn->posting_date = $request->posting_date;
        $salesreturn->docdue_date = $request->docdue_date;
        $salesreturn->doc_date = $request->DocuDate;
        // $salesreturn->payment_term = $request->payment_term;
        $salesreturn->tax_regno = $request->tax_reg_no;
        $salesreturn->open_invoice = $request->open_qutn ? $request->open_qutn : 0;
        $salesreturn->sales_emp_id = $request->partner3;
        $salesreturn->remarks = $request->remarks;
        $salesreturn->return_reason = $request->return_reason;
        $salesreturn->damage_type = $request->damage;
        $salesreturn->total_bf_discount = $request->total_bef_discount;
        $salesreturn->discount_percent = $request->discount;
        $salesreturn->discount_amount = $request->discount_amount_value;
        $salesreturn->total_exp = $request->expense;
        $salesreturn->tax_amount = $request->tax_amount;
        $salesreturn->rounding = $request->roundtext;
        $salesreturn->total = $request->grand_total;
        $salesreturn->applied_amount = 0;
        $salesreturn->createdBy = Auth::user()->id;
        $salesreturn->updatedBy = null;
        $salesreturn->save();

        $salesreturn_id = $salesreturn->id;
        $total = $request->grand_total;
        if ($total > 0) {
            $lpoint = $total * (env('LOYALTY_POINT') / 100);
            $lpoint_in_rs = round($lpoint, 2);
       
            $customer = Customer::where('customer_code', $request->customer)->first();
         
            if ($customer) {
                // Ensure loyalty_point is initialized to 0 if NULL
                $currentPoints = $customer->loyalty_point ?? 0;
                
                // Update loyalty_point with the new value
                $customer->update(['loyalty_point' => $currentPoints - $lpoint_in_rs]);
            } 
            // else {
            //     // dd('Customer not found');
            // }
        }
        
        // Ensure all the arrays are treated properly
        $invoice_item_id = is_array($request->invoice_item_id) ? $request->invoice_item_id : [];
        $products = is_array($request->product) ? $request->product : [];
        $warehouses = is_array($request->whscode) ? $request->whscode : [];
        $quantity = is_array($request->quantity) ? $request->quantity : [];
        $av_quantity = is_array($request->av_quantity) ? $request->av_quantity : [];
        $LineTotal = is_array($request->linetotal) ? $request->linetotal : [];
        $unitprice = is_array($request->unitprice) ? $request->unitprice : [];
        $discprice = is_array($request->discprice) ? $request->discprice : [];
        $taxcode = is_array($request->taxcode) ? $request->taxcode : [];
        $serialno = is_array($request->serialno) ? $request->serialno : [];

        $count = count($products);
        $lineNo = 1;
        $grand_total = 0;

        for ($i = 0; $i < $count; $i++) {
            if (!isset($quantity[$i]) || !$quantity[$i]) {
                $quantity[$i] = 1;
            }
            
            if (!empty($products[$i]) && !empty($quantity[$i]) && !empty($warehouses[$i])) {
                // if (isset($av_quantity[$i]) && isset($invoice_item_id[$i]) && $av_quantity[$i] != '0' && $invoice_item_id[$i] != '0') {
                    $balance_qty = $av_quantity[$i] - $quantity[$i];
                    
                    $invoiceitem = SalesInvoiceItem::find($invoice_item_id[$i]);
                    
                    if ($invoiceitem) {
                        if ($balance_qty > 0) {
                            $invoiceitem->open_qty = $balance_qty;
                        } else {
                            $invoiceitem->open_qty = $balance_qty;
                            $invoiceitem->status = 'Confirm';
                        }
                        $invoiceitem->save();
                    }
                    $salesinv = SalesOrderItem::find($invoiceitem->order_item_id);
                    // dd($quotation_item_id[$i]);
                            if ($salesinv) {
                                if ($balance_qty > 0) {
                                    $salesinv->open_qty = $balance_qty;
                                } else {
                                    $salesinv->open_qty = $balance_qty;
                                    $salesinv->status = 'Confirm';
                                }
                                $salesinv->save();
                            }


                        $bstock = DB::table('itemwarehouses as i')
                        ->where('i.ItemCode', $products[$i])
                        ->where('i.WhsCode', session('branch_code'))
                        ->first();
                        $pstock = DB::table('product_stocks as s')
                                    ->where('productCode', $products[$i])
                                    ->first();
                        if ($pstock && $bstock) {
                            // Record exists, update the quantity
                            DB::table('itemwarehouses as i')
                                ->where('i.ItemCode', $products[$i])
                                ->where('i.WhsCode', session('branch_code'))
                                ->update([
                                    'OnHand' => $bstock->OnHand - $quantity[$i]
                                ]);

                            DB::table('product_stocks')
                                ->where('productCode', $products[$i])
                                ->update([
                                    'onHand' => $pstock->onHand - $quantity[$i]
                                ]);
                        } else {
                            // Optional: Log or handle products without an existing stock record
                            error_log("No stock found for productCode={$products[$i]}");
                        }


                // }

                $salesreturnItem = new SalesReturnItem;
                $salesreturnItem->sm_id = $salesreturn_id;
                $salesreturnItem->invoice_item_id = $invoice_item_id[$i] ?? 0;
                $salesreturnItem->item_id = $products[$i];
                $salesreturnItem->whs_code = $warehouses[$i];
                $salesreturnItem->qty = $quantity[$i];
                $salesreturnItem->open_qty = $quantity[$i];
                $salesreturnItem->unit_price = $unitprice[$i];
                $salesreturnItem->disc_price = $discprice[$i];
                $salesreturnItem->tax_code = $taxcode[$i];
                $salesreturnItem->line_total = $LineTotal[$i];
                $salesreturnItem->serial_no = $serialno[$i];
                $salesreturnItem->status = "Open";
                $salesreturnItem->save();
            }
        }
        session()->flash('success', 'Sales Return added successfully');
        return response()->json([
            'success' => true,
            'salesreturn_id' => $salesreturn_id,  // Pass the saved Sales Order ID
            'message' => 'Sales Return added successfully'
        ]);

        // return redirect('admin/sales-order/' . $salesreturn_id)->with('success', 'Sales Order added successfully');
    }

    public function get_invoice_details(Request $request)
    {
        //dd($request);
        if ($request->ajax()) {

            $invoiceId = $request['invoice'];
            $salesorders = DB::table('sales_invoice_masters')
            ->join('sales_invoice_items', 'sales_invoice_masters.id', '=', 'sales_invoice_items.sm_id')
            ->join('partners', 'sales_invoice_masters.sales_emp_id', '=', 'partners.partner_code')
            ->join('products', 'sales_invoice_items.item_id', '=', 'products.productCode')
            ->join('product_stocks', 'products.productCode', '=', 'product_stocks.productCode')
            ->join('itemwarehouses', 'product_stocks.productCode', '=', 'itemwarehouses.ItemCode')
            ->join('warehouses', 'product_stocks.whsCode', '=', 'warehouses.whsCode')
            ->join('customers', 'sales_invoice_masters.cid', '=', 'customers.customer_code')
            ->whereIn('sales_invoice_masters.id', $invoiceId) // equivalent to WHERE IN (4, 2)
             ->where('itemwarehouses.WhsCode', '=', session('branch_code'))
            // ->where('sales_invoice_items.qty', '>', 0)
            ->select(
                'sales_invoice_masters.*', 
                'sales_invoice_items.*', 
                'products.productCode', 
                'products.productName', 
                'product_stocks.whsCode', 
                'warehouses.whsName', 
                'customers.*',
                'sales_invoice_items.line_total', 
                'sales_invoice_items.qty', 
                'sales_invoice_items.unit_price', 
                'sales_invoice_items.tax_code',
                'sales_invoice_items.id', 
                'sales_invoice_items.serial_no', 
                'sales_invoice_items.status',
                'partners.name',
                'partners.partner_code'
            )
            ->get();

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
        // dd($responseData);
            return response()->json(['success' => true, 'data' => $responseData], 200);
        }

        return response()->json(['error' => 'Invalid request.'], 400);
    }

    public function salesinvoice_close_items(Request $request)
    {
        $id=$request['item'];
        $invoice_item = SalesInvoiceItem::find($id);
        $data = '';
        if ($invoice_item) {
            //$invoice_item->status = 'Cancel';
            $invoice_item->save();
            $data = "Invoice item is cancelled!";
        }
        echo json_encode($data);
    }
    public function show($id)
    {
        $details = SalesReturnMaster::select('sales_return_masters.*')->with(array('Item_details.products.stock.warehouse', 'customer', 'referral1', 'referral2'))->find($id); //print_r($details);
        //dd($details);
        return view('admin.salesretun_details', compact('details'));
    }

    public function close(Request $request, $id)
    {
        $salesreturn = SalesReturnMaster::find($id);
        $data = '';
        if ($salesreturn->status == 'Confirm') {
            $data = "Sales Return is already confirmed!";
        } else {
            $salesreturn->status = 'Cancel';
            $salesreturn->cancelReason = $request->cancel_reason;
            $salesreturn->save();
            $data = "Sales Return is cancelled!";
        }
        echo json_encode($data);
    }

    public function download_excel(Request $request)
    {
        // dd($request);
        try 
        {
            // dd(Auth::user()->id);
            //$data = QuotationItem::query();
            $data = SalesReturnItem::join('sales_return_masters', 'sales_return_items.sm_id', '=', 'sales_return_masters.id')
            ->join('products', 'sales_return_items.item_id', '=', 'products.productCode')
            ->join('customers', 'sales_return_masters.cid', '=', 'customers.customer_code')
            ->join('partners', 'sales_return_masters.sales_emp_id', '=', 'partners.partner_code')
            ->select('sales_return_masters.doc_num',
            'sales_return_masters.status',
            'sales_return_masters.doc_date',
            'sales_return_items.item_id',
            'products.productName',
            'products.brand',
            'sales_return_items.qty',
            'sales_return_items.line_total',
            'partners.name as partner_name',
            'customers.customer_code',
            'customers.name as customer_name');
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
                $data->where('sales_return_masters.docdue_date', '>=', $request->from_date);
            }
            if (!empty($request->to_date)) {
                //echo "here2";
                $data->where('sales_return_masters.docdue_date', '<=', $request->to_date);
            }
            if (!empty($request->customer)) {
                //echo "here";
                $data->where('sales_return_masters.cid', $request->customer);
            }
            if (!empty($request->user)) {
                //echo "here";
                $data->where('sales_return_masters.sales_emp_id', $request->user);
            }
            if (!empty($request->status)) {
                if ($request->status == "All") {
                    // $request->status= 'Cancel';
                    // $data->where('quotations.status', '!=', $request->status);
                    //$data->whereIn('sales_return_masters.status','Open');
                    $data->whereIn('sales_return_masters.status',$request->stsval);
                } else {
                    $data->where('sales_return_masters.status', $request->status);
                }
            } else {
                $data->where('sales_return_masters.status', '!=', 'Cancel');
            }
            //dd($data->toSql(), $data->getBindings()) ;
            $data->orderBy('doc_date',"desc");
            //dd($data);
            $file_name = 'sales_return_'.time().'.xlsx';
            $allData = collect([]);
            $data->chunk(3000, function ($query) use ($allData) {
                if ($query->isEmpty()) {
                    logger("Chunk is empty");
                } else {
                    $allData->push($query);
                }
            });
            if ($allData->isEmpty()) {
                logger("No data found to export.");
                return response()->json(["error" => "No data available for the selected filters."], 400);
            }
            // Concatenate data from all chunks
            $concatenatedData = $allData->collapse();
            if ($concatenatedData->isEmpty()) {
                return response()->json(["error" => "No data to export."], 400);
            }

            // Export concatenated data
            (new FastExcel($concatenatedData))->export(public_path('exports').'/'.$file_name);

            // Get the scheme and host, plus the correct base path without "index.php"
            $host = request()->getSchemeAndHttpHost() . str_replace('/index.php', '', request()->getBaseUrl());
            
            return response()->json(["url" => $host . '/exports/' . $file_name]);
        }
        catch (\Exception $e) {
            return $e;
        }
    }



}
