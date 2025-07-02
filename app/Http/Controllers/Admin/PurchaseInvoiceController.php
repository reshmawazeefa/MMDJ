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
use App\Models\GoodsReturnMaster;
use App\Models\PurchaseInvoiceMaster;
use App\Models\CustomQuotation;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseInvoiceItem;
use App\Models\SalesOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Rap2hpoutre\FastExcel\FastExcel;


class PurchaseInvoiceController extends Controller
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
                $data = PurchaseInvoiceMaster::select('purchase_invoice_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3','user'));
            } else {
                $data = PurchaseInvoiceMaster::select('purchase_invoice_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3','user'))
                    ->where(function ($query) {
                        $query->Where('createdBy', Auth::user()->id);
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
                $data->where('purchase_invoice_masters.cid', $request->customer);
            }
            if (!empty($request->user)) {
                //echo "here";
                $data->where('purchase_invoice_masters.createdBy', $request->user);
            }
            if (!empty($request->status)) {
                if ($request->status == "All") {
                    $data->where('purchase_invoice_masters.status', '!=', 'Cancel');
                } else {
                    $data->where('purchase_invoice_masters.status', $request->status);
                }
            } else {
                $data->where('purchase_invoice_masters.status', 'Open');
            }
                $data->where('purchase_invoice_masters.branch', session('branch_code'));

                $data->orderBy('cid', 'desc')->get();
                // dd($data);

                // dd($data);
                return Datatables::of($data)
                ->addColumn('DocNo', function ($row) {
                    if ($row->doc_num)
                        return $row->doc_num;
                    else
                        return null;

                })
                ->addColumn('action', function ($row) {
                    $url = url('admin/purchase_invoice/' . $row->id);
                    $url_banking = url('admin/outgoing-payment-create');
                    $btn = '<a href=' . $url . ' class="btn btn-primary"><i class="mdi mdi-eye"></i>View</a>';
                        /*
                        <a href="javascript:void(0);" onclick="open_closemodal('.$row->id.')" class="btn btn-danger close-icon"><i class="mdi mdi-delete"></i>Close</a>
                        */
                    if ((($row->status == 'Approve' || $row->status == 'Open') && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) || $row->status == 'Send for Approval') {
                        $btn .= '&nbsp;<a href=' . $url_banking . ' class="btn btn-info"><i class="mdi mdi-cash-fast"></i>Add Payment</a>&nbsp;';
                    }

                    if ($row->status == 'Approve' && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) {
                        $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_approvemodal(' . $row->id . ')" class="btn btn-primary"><i class="mdi mdi-plus-circle me-1"></i>Confirm</a>';
                    }

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
                    if ($row->cid)
                        return \Carbon\Carbon::parse($row->doc_date)->format('d-m-Y');
                    else
                        return null;

                })
                ->addColumn('docdue_date', function ($row) {
                    if ($row->cid)
                        return \Carbon\Carbon::parse($row->docdue_date)->format('d-m-Y');
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

        return view('admin.purchaseinvoice');
    }

    public function create()
    {
        return view('admin.create_purchaseinvoice');
    }

    public function show($id)
    {
        $details = PurchaseInvoiceMaster::select('purchase_invoice_masters.*')->with(array('Item_details.products.stock.warehouse', 'customer', 'referral1', 'referral2','referral3'))->find($id); //print_r($details);
        //dd($details);

        return view('admin.purchaseinvoice_details', compact('details'));
    }

    public function edit($id)
    {
        $details = PurchaseInvoiceMaster::select('purchase_invoice_masters.*')->with(array('Item_details.products.stock','customer','referral1','referral2','referral3'))->find($id); 
        // dd(json_encode($details));
        return view('admin.edit_goodsreturn', compact('details'));
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
        //dd($request);
        $validator = $request->validate([
            'customer' => 'required',
            'product' => 'required|array|min:1',
            'quantity' => 'required|array|min:1'
        ]);
    
        // Find existing PurchaseInvoiceMaster by id
        $goodsreturn = PurchaseInvoiceMaster::find($id);
        if (!$goodsreturn) {
            return redirect()->back()->with('error', 'Sales Order not found');
        }
    
        // $docnum = $request->doc_list . "-" . $request->docNumber;
    
        // Update the PurchaseInvoiceMaster fields
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
    
        // Update the PurchaseInvoiceItem details
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
        PurchaseInvoiceItem::where('sm_id', $id)->delete();
        
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
                $goodsreturnItem = new PurchaseInvoiceItem;
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
    
        return redirect('admin/goods-return/' . $id)->with('success', 'Purchase Invoice updated successfully');
    }    

    public function insert(Request $request)
        {

            // dd($request);
                $validator = $request->validate([
                    'customer' => 'required', 
                    // 'product' => 'required|array|min:1',
                    // 'quantity' => 'required|array|min:1'
                ]);

                $docnum = $request->doc_list . "-" . $request->docNumber;
                
                $purchaseinvoice = new PurchaseInvoiceMaster;
                $purchaseinvoice->cid = $request->customer;
                $purchaseinvoice->ref_no = $request->refno;
                // $purchaseinvoice->add_type_bill_to = $request->bill_to;
                // $purchaseinvoice->add_type_ship_to = $request->ship_to;
                $purchaseinvoice->address_bill = $request->bill_to_address;
                $purchaseinvoice->address_ship = $request->ship_to_address;
                $purchaseinvoice->pl_supply = $request->place_of_sply;
                // $purchaseinvoice->tax_type = $request->tax_type;
                $purchaseinvoice->doc_num = $docnum;
                $purchaseinvoice->status = $request->status;
                $purchaseinvoice->branch = session('branch_code');
                $purchaseinvoice->posting_date = $request->posting_date;
                $purchaseinvoice->docdue_date = $request->delivery_date;
                $purchaseinvoice->doc_date = $request->DocuDate;
                // $purchaseinvoice->payment_term = $request->payment_term;
                $purchaseinvoice->tax_regno = $request->tax_reg_no;
                $purchaseinvoice->open_quotation = $request->open_qutn ? $request->open_qutn : 0;
                $purchaseinvoice->sales_emp_id = auth()->user()->id;//$request->partner3;
                $purchaseinvoice->remarks = $request->msg;
                $purchaseinvoice->total_bf_discount = $request->total_bef_discount;
                $purchaseinvoice->discount_percent = $request->discount;
                $purchaseinvoice->discount_amount = $request->discount_amount_value;
                $purchaseinvoice->total_exp = $request->expense;
                $purchaseinvoice->tax_amount = $request->tax_amount;
                $purchaseinvoice->rounding = $request->roundtext;
                $purchaseinvoice->total = $request->grand_total;
                $purchaseinvoice->applied_amount = 0;
                $purchaseinvoice->createdBy = Auth::user()->id;
                $purchaseinvoice->updatedBy = null;
                $purchaseinvoice->save();

                $purchaseinvoice_id = $purchaseinvoice->id;
                
                // Ensure all the arrays are treated properly
                $quotation_item_id = is_array($request->quotation_item_id) ? $request->quotation_item_id : [];
                $remarks = is_array($request->remarks) ? $request->remarks : [];
                $LineTotal = is_array($request->linetotal) ? $request->linetotal : [];

                $products = is_array($request->product) ? $request->product : [];
                $unit = is_array($request->unit) ? $request->unit : [];
                $warehouses = is_array($request->whscode) ? $request->whscode : [];
                $quantity = is_array($request->quantity) ? $request->quantity : [];
                $av_quantity = is_array($request->av_quantity) ? $request->av_quantity : [];
                $unitprice = is_array($request->unitprice) ? $request->unitprice : [];
                $discprice = is_array($request->discprice) ? $request->discprice : [];
                $taxcode = is_array($request->taxcode) ? $request->taxcode : [];
                $serialno = is_array($request->serialno) ? $request->serialno : [];

                $count = count($quotation_item_id);
                $lineNo = 1;
                $grand_total = 0;

                for ($i = 0; $i < $count; $i++) {
                    // if (!isset($quantity[$i]) || !$quantity[$i]) {
                    //     $quantity[$i] = 1;
                    // }
            
                        // if (!empty($products[$i]) && !empty($quantity[$i])) 
                        // {
                        
                            if (isset($quotation_item_id[$i]) && $quotation_item_id[$i] != '0') 
                            {
                                    // $balance_qty = $av_quantity[$i] - $quantity[$i]; 
                                    
                                    $purchaseditem = PurchaseOrderMaster::find($quotation_item_id[$i]);
                                    // dd($purchaseditem);
                                    if ($purchaseditem) {
                                        if ($purchaseditem->total==$LineTotal[$i]) 
                                        {
                                            // $purchaseditem->open_qty = $balance_qty;
                                            $purchaseditem->status = 'Confirm';
                                            $purchaseditem->save();
                                        }
                                           


                                            // if ($purchaseditem->sm_id) {
                                            //     $allConfirmed = PurchaseOrderItem::where('sm_id', $purchaseditem->sm_id)
                                            //         ->where('status', '<>', 'Confirm')
                                            //         ->doesntExist(); // returns true if all items are 'Confirm'
                                    
                                            //     DB::table('purchase_order_masters')
                                            //         ->where('id', $purchaseditem->sm_id)
                                            //         ->update(['status' => $allConfirmed ? 'Confirm' : 'Open']);
                                            // }

                                       
                                    }

                            }

                            $purchaseinvoiceItem = new PurchaseInvoiceItem;
                            $purchaseinvoiceItem->sm_id = $purchaseinvoice_id;
                            $purchaseinvoiceItem->quotation_item_id = $quotation_item_id[$i] ?? 0;
                            $purchaseinvoiceItem->remarks = $remarks[$i];
                            $purchaseinvoiceItem->total_amount = $LineTotal[$i];
                            $purchaseinvoiceItem->item_id     = $products[$i]     ?? null;
                            $purchaseinvoiceItem->unit        = $unit[$i]         ?? null;
                            $purchaseinvoiceItem->whs_code    = $warehouses[$i]   ?? null;
                            $purchaseinvoiceItem->qty         = $quantity[$i]     ?? null;
                            $purchaseinvoiceItem->open_qty    = $quantity[$i]     ?? null;
                            $purchaseinvoiceItem->unit_price  = $unitprice[$i]    ?? null;
                            $purchaseinvoiceItem->disc_price  = $discprice[$i]    ?? null;
                            $purchaseinvoiceItem->tax_code    = $taxcode[$i]      ?? null;
                            $purchaseinvoiceItem->line_total  = $LineTotal[$i]    ?? null;
                            $purchaseinvoiceItem->serial_no   = $serialno[$i]     ?? null;
                            $purchaseinvoiceItem->status = "Open";
                            $purchaseinvoiceItem->save();
                        // }
                        
                    }
                    session()->flash('success', 'Purchase Invoice added successfully');
                    return response()->json([
                        'success' => true,
                        'purchaseinvoice_id' => $purchaseinvoice_id,  // Pass the saved Sales Order ID
                        'message' => 'Purchase Invoice added successfully'
                    ]);

            // return redirect('admin/purchase-order/' . $purchaseinvoice_id)->with('success', 'Purchase Invoice added successfully'); 
        }

    public function download_excel(Request $request)
        {
            // dd($request);
            try 
            {
                // dd(Auth::user()->id);
                //$data = QuotationItem::query();
                $data = PurchaseInvoiceItem::join('purchase_invoice_masters', 'purchase_invoice_items.sm_id', '=', 'purchase_invoice_masters.id')
                ->join('products', 'purchase_invoice_items.item_id', '=', 'products.productCode')
                ->join('customers', 'purchase_invoice_masters.cid', '=', 'customers.customer_code')
                ->join('partners', 'purchase_invoice_masters.sales_emp_id', '=', 'partners.partner_code')
                ->select('purchase_invoice_masters.doc_num',
                'purchase_invoice_masters.status',
                'purchase_invoice_masters.doc_date',
                'purchase_invoice_items.item_id',
                'products.productName',
                'products.brand',
                'purchase_invoice_items.qty',
                'purchase_invoice_items.line_total',
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
                    $data->where('purchase_invoice_masters.docdue_date', '>=', $request->from_date);
                }
                if (!empty($request->to_date)) {
                    //echo "here2";
                    $data->where('purchase_invoice_masters.docdue_date', '<=', $request->to_date);
                }
                if (!empty($request->customer)) {
                    //echo "here";
                    $data->where('purchase_invoice_masters.cid', $request->customer);
                }
                if (!empty($request->user)) {
                    //echo "here";
                    $data->where('purchase_invoice_masters.createdBy', $request->user);
                }
                if (!empty($request->status)) {
                    if ($request->status == "All") {
                        // $request->status= 'Cancel';
                        // $data->where('quotations.status', '!=', $request->status);
                        //$data->whereIn('purchase_invoice_masters.status','Open');
                        $data->whereIn('purchase_invoice_masters.status',$request->stsval);
                    } else {
                        $data->where('purchase_invoice_masters.status', $request->status);
                    }
                } else {
                    $data->where('purchase_invoice_masters.status', '!=', 'Cancel');
                }
                //dd($data->toSql(), $data->getBindings()) ;
                $data->orderBy('doc_date',"desc");
                //dd($data);
                $file_name = 'purchase-invoice'.time().'.xlsx';
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

    public function close(Request $request, $id)
        {
            $goodsreturn = PurchaseInvoiceMaster::find($id);
            $data = '';
            if ($goodsreturn->status == 'Confirm') {
                $data = "Purchase Invoice is already confirmed!";
            } else {
                $goodsreturn->status = 'Cancel';
                $goodsreturn->cancelReason = $request->cancel_reason;
                $goodsreturn->save();
                $data = "Purchase Invoice is cancelled!";
            }
            echo json_encode($data);
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
            $purchase_order = DB::table('purchase_order_masters as q')
                            ->join('purchase_order_items as qt', 'q.id', '=', 'qt.sm_id')
                            ->where('q.status', 'Open')
                            ->where('q.cid', $request['customer_code'])
                            ->where(function ($query) {
                                $query->where('qt.status', '<>', 'Cancel')
                                    ->where('qt.status', '<>', 'Confirm');
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

    public function get_edit_customer_details(Request $request)
    {
        if(isset($request['customer_code']))
        {
            // Fetch the customer details
            $data = Customer::where('customer_code', $request['customer_code'])
                            ->where('is_active', 1)
                            ->first();
    
            // Fetch the quotations related to the customer
            $purchase_order = DB::table('purchase_order_masters as q')
                            ->join('purchase_order_items as qt', 'q.id', '=', 'qt.sm_id')
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


    public function get_customer_open_grpo(Request $request)
    {
        if(isset($request['customer_code']))
        {
            // $data = Customer::where('customer_code',$request['customer_code'])
            // ->where('is_active',1)->first();

            $purchase_order = DB::table('purchase_order_masters as q')
            ->join('purchase_order_items as qt', 'q.id', '=', 'qt.sm_id')
            ->where('q.status', 'open') // Only open quotations
            ->where('q.cid', $request['customer_code']) // Customer-specific quotations
            ->where(function ($query) {
                $query->where('qt.status', '<>', 'Cancel')
                    ->where('qt.status', '<>', 'Confirm');
            }) // Exclude items with 'Cancel' or 'Confirm' status
            ->select('q.id', 'q.doc_num')
            ->groupBy('q.id', 'q.doc_num')
            ->get();
                
                return response()->json($purchase_order);
        
        }
    }

    public function get_edit_customer_open_grpo(Request $request)
    {
        if(isset($request['customer_code']))
        {
            // $data = Customer::where('customer_code',$request['customer_code'])
            // ->where('is_active',1)->first();

            $purchase_order = DB::table('purchase_order_masters as q')
            ->join('purchase_order_items as qt', 'q.id', '=', 'qt.sm_id')
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
    public function get_grpo_details (Request $request)
    {
        if ($request->ajax()) {

            $grpoId = $request['grpo'];
   
            $salesorders = DB::table('purchase_order_masters')
                ->join('purchase_order_items', 'purchase_order_masters.id', '=', 'purchase_order_items.sm_id')
                ->join('products', 'purchase_order_items.item_id', '=', 'products.productCode')
                ->join('product_stocks', 'products.productCode', '=', 'product_stocks.productCode')
                ->join('warehouses', 'product_stocks.whsCode', '=', 'warehouses.whsCode')
                ->join('customers', 'purchase_order_masters.cid', '=', 'customers.customer_code')
                ->whereIn('purchase_order_masters.id', $grpoId) // equivalent to WHERE IN (4, 2)
                // ->where('purchase_order_items.status', '=', 'Open')
                ->where(function ($query) {
                    $query->where('purchase_order_items.status', '<>', 'Cancel')
                        ->where('purchase_order_items.status', '<>', 'Confirm')
                        ->where('purchase_order_items.qty', '<>', 0);
    
                })
                ->select(
                    'purchase_order_masters.*', 
                    'purchase_order_items.*', 
                    'products.productCode', 
                    'products.productName', 
                    'product_stocks.whsCode', 
                    'warehouses.whsName', 
                    'customers.*',
                    'purchase_order_items.line_total', 
                    'purchase_order_items.qty', 
                    'purchase_order_items.unit_price', 
                    'purchase_order_items.tax_code',
                    'purchase_order_items.id', 
                    'purchase_order_items.serial_no', 
                    'purchase_order_items.status'
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
   
            $salesorders = DB::table('purchase_order_masters')
                ->join('purchase_order_items', 'purchase_order_masters.id', '=', 'purchase_order_items.sm_id')
                ->join('products', 'purchase_order_items.item_id', '=', 'products.productCode')
                ->join('product_stocks', 'products.productCode', '=', 'product_stocks.productCode')
                ->join('warehouses', 'product_stocks.whsCode', '=', 'warehouses.whsCode')
                ->join('customers', 'purchase_order_masters.cid', '=', 'customers.customer_code')
                ->whereIn('purchase_order_masters.id', $grpoId) // equivalent to WHERE IN (4, 2)
                // ->where('purchase_order_items.status', '=', 'Open')
                // ->where(function ($query) {
                //     $query->where('purchase_order_items.status', '<>', 'Confirm')
                //         ->where('purchase_order_items.qty', '<>', 0);
    
                // })
                ->select(
                    'purchase_order_masters.*', 
                    'purchase_order_items.*', 
                    'products.productCode', 
                    'products.productName', 
                    'product_stocks.whsCode', 
                    'warehouses.whsName', 
                    'customers.*',
                    'purchase_order_items.line_total', 
                    'purchase_order_items.qty', 
                    'purchase_order_items.unit_price', 
                    'purchase_order_items.tax_code',
                    'purchase_order_items.id', 
                    'purchase_order_items.serial_no', 
                    'purchase_order_items.status'
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

}
