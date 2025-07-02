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
use App\Models\CustomQuotation;
use App\Models\PurchaseOrderItem;
use App\Models\SalesOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Rap2hpoutre\FastExcel\FastExcel;

class GoodsReceiptPOController extends Controller
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
                $data = PurchaseOrderMaster::select('purchase_order_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3','user'));
            } else {
                $data = PurchaseOrderMaster::select('purchase_order_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3','user'))
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
                $data->where('purchase_order_masters.cid', $request->customer);
            }
            if (!empty($request->user)) {
                //echo "here";
                $data->where('purchase_order_masters.sales_emp_id', $request->user);
            }
            if (!empty($request->status)) {
                if ($request->status == "All") {
                    $data->where('purchase_order_masters.status', '!=', 'Cancel');
                } else {
                    $data->where('purchase_order_masters.status', $request->status);
                }
            } else {
                $data->where('purchase_order_masters.status', 'Open');
            }
                $data->where('purchase_order_masters.obj_type', 'Purchase Order');
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
                    $url = url('admin/purchase-order/' . $row->id);
                    $url_edit = url('admin/purchase-order/' . $row->id . '/edit');
                    $url_invoice = url('admin/purchase_invoice');
                    $btn = '<a href=' . $url . ' class="btn btn-primary"><i class="mdi mdi-eye"></i>View</a>';
                        /*
                        <a href="javascript:void(0);" onclick="open_closemodal('.$row->id.')" class="btn btn-danger close-icon"><i class="mdi mdi-delete"></i>Close</a>
                        */
                    if ((($row->status == 'Approve' || $row->status == 'Open') && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) || $row->status == 'Send for Approval') {
                        $btn .= '&nbsp;<a href=' . $url_edit . ' class="btn btn-info"><i class="mdi mdi-square-edit-outline"></i>Edit</a>&nbsp;';
                         $btn .= '&nbsp;<a href=' . $url_invoice . ' class="btn btn-primary"><i class="mdi mdi-file-cog-outline"></i>Generate Invoice</a>&nbsp;';
                    }


                    if ($row->status == 'Approve' && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) {
                        $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_approvemodal(' . $row->id . ')" class="btn btn-primary"><i class="mdi mdi-plus-circle me-1"></i>Confirm</a>';
                    }

                    if (($row->status == 'Open' || $row->status == 'Send for Approval') && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) {
                        $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_closemodal(' . $row->id . ')" class="btn btn-danger close-icon"><i class="mdi mdi-delete"></i>Close</a>';
                    }
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
                        return $row->doc_date;
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

        return view('admin.purchaseorders');
    }

        public function expenseindex(Request $request)
    {
        // dd($request);

        if ($request->ajax()) {
            if (Auth::user()->hasRole('Admin')) {
                $data = PurchaseOrderMaster::select('purchase_order_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3','user'));
            } else {
                $data = PurchaseOrderMaster::select('purchase_order_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3','user'))
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
                $data->where('purchase_order_masters.cid', $request->customer);
            }
            if (!empty($request->user)) {
                //echo "here";
                $data->where('purchase_order_masters.sales_emp_id', $request->user);
            }
            if (!empty($request->status)) {
                if ($request->status == "All") {
                    $data->where('purchase_order_masters.status', '!=', 'Cancel');
                } else {
                    $data->where('purchase_order_masters.status', $request->status);
                }
            } else {
                $data->where('purchase_order_masters.status', 'Open');
            }
                $data->where('purchase_order_masters.obj_type', "Other Expense");
                $data->orderBy('cid', 'desc')->get();
                // dd($data);

                // dd($data);
                return Datatables::of($data)
                ->addColumn('DocNo', function ($row) {
                    if ($row->invoice_no)
                        return $row->invoice_no;
                    else
                        return null;

                })
                
                ->addColumn('action', function ($row) {
                    $url = url('admin/purchase-order/' . $row->id);
                    $url_edit = url('admin/purchase-order/' . $row->id . '/edit');
                    $btn = '<a href=' . $url . ' class="btn btn-primary"><i class="mdi mdi-eye"></i>View</a>';
                        /*
                        <a href="javascript:void(0);" onclick="open_closemodal('.$row->id.')" class="btn btn-danger close-icon"><i class="mdi mdi-delete"></i>Close</a>
                        */
                    if ((($row->status == 'Approve' || $row->status == 'Open') && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) || $row->status == 'Send for Approval') {
                        $btn .= '&nbsp;<a href=' . $url_edit . ' class="btn btn-info"><i class="mdi mdi-square-edit-outline"></i>Edit</a>&nbsp;';
                    }

                    if ($row->status == 'Approve' && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) {
                        $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_approvemodal(' . $row->id . ')" class="btn btn-primary"><i class="mdi mdi-plus-circle me-1"></i>Confirm</a>';
                    }

                    if (($row->status == 'Open' || $row->status == 'Send for Approval') && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) {
                        $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_closemodal(' . $row->id . ')" class="btn btn-danger close-icon"><i class="mdi mdi-delete"></i>Close</a>';
                    }
                    return $btn;
                })
              ->addColumn('Type', function ($row) {
                    return is_string($row->exp_type) ? substr($row->exp_type, 0, 27) : json_encode($row->exp_type ?? 'Supplier');
                })


                // ->addColumn('customer', function ($row) {
                //     if ($row->customer) {
                //         $n = $row->customer->name;
                //         return substr($n, 0, 27);
                //     } else
                //         return null;
                // })
                ->addColumn('doc_date', function ($row) {
                    if ($row->doc_num)
                        return $row->doc_date;
                    else
                        return null;

                })
                ->addColumn('docdue_date', function ($row) {
                    if ($row->cid)
                        return $row->docdue_date;
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
                 ->addColumn('Remarks', function ($row) {
                    if ($row->remarks)
                        return $row->remarks;
                    else
                        return null;

                })
               
                // ->addColumn('status_show', function ($row) {
                //     $row->status_show = $row->status;
                //     if ($row->status == 'Cancel')
                //         $row->status_show = 'Cancelled';
                //     elseif ($row->status == 'Approve')
                //         $row->status_show = 'Approved';
                //     elseif ($row->status == 'Confirm')
                //         $row->status_show = 'Confirmed';
                //     return $row->status_show;
                // })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.otherexpense');
    }

    public function create()
    {
    return view('admin.create_goodsreceipt_po');
    }
    public function oecreate()
    {
    return view('admin.create_other_expense');
    }

    public function show($id)
    {
        $details = PurchaseOrderMaster::select('purchase_order_masters.*')->with(array('Item_details.products.stock.warehouse', 'customer', 'referral1', 'referral2','referral3','user'))->find($id); //print_r($details);
        //dd($details);

        return view('admin.purchaseorder_details', compact('details'));
    }

    public function edit($id)
    {
        $details = PurchaseOrderMaster::select('purchase_order_masters.*')->with(array('Item_details.products.stock','customer','referral1','referral2','referral3'))->find($id); 
       // dd($details);
        return view('admin.edit_purchaseorder', compact('details'));
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
        if(isset($request->type) && ($request->type=='Purchase Order'))
        {
        $validator = $request->validate([
            'customer' => 'required',
            // 'product' => 'required|array|min:1',
            // 'whscode' => 'required|array|min:1',
            // 'quantity' => 'required|array|min:1'
        ]);
        }

         if($request->type=='Purchase Order')
        {
        $extype='supplier';
        }
        else
        {
         $extype='misc';
        }
    
        // Find existing purchaseorderMaster by id
        $purchaseorder = PurchaseOrderMaster::find($id);
        if (!$purchaseorder) {
            return redirect()->back()->with('error', 'Sales Order not found');
        }
    
        // $docnum = $request->doc_list . "-" . $request->docNumber;
    
        // Update the purchaseorderMaster fields
        $purchaseorder->cid = $request->customer;
        $purchaseorder->ref_no = $request->refno;
        $purchaseorder->invoice_no = $request->inv_no;
        $purchaseorder->payment_method = $request->ptype;
        $purchaseorder->exp_type = $extype;

        // $purchaseorder->add_type_bill_to = $request->bill_to;
        // $purchaseorder->add_type_ship_to = $request->ship_to;
        $purchaseorder->address_bill = $request->bill_to_address;
        $purchaseorder->address_ship = $request->ship_to_address;
        $purchaseorder->pl_supply = $request->place_of_sply;
        // $purchaseorder->tax_type = $request->tax_type;
        // $purchaseorder->doc_num = $docnum;
        //$purchaseorder->status = $request->status;
        $purchaseorder->posting_date = $request->posting_date;
        $purchaseorder->docdue_date = $request->docdue_date;
        $purchaseorder->doc_date = $request->DocuDate;
        // $purchaseorder->payment_term = $request->payment_term;
        $purchaseorder->tax_regno = $request->tax_reg_no;
        $purchaseorder->open_quotation = $request->open_qutn ? $request->open_qutn : 0;
        //$purchaseorder->sales_emp_id = Auth::user()->id;// $request->partner3;
        $purchaseorder->remarks = $request->remarks;
        $purchaseorder->total_bf_discount = $request->total_bef_discount;
        $purchaseorder->discount_percent = $request->discount;
        $purchaseorder->discount_amount = $request->discount_amount_value;
        $purchaseorder->total_exp = $request->expense;
        $purchaseorder->tax_amount = $request->tax_amount;
        $purchaseorder->rounding = $request->roundtext;
        $purchaseorder->total = $request->grand_total;
        $purchaseorder->updatedBy = Auth::user()->id;  // You may want to track who updated it
        $purchaseorder->save();
    
        // Update the purchaseorderItem details
        $products = $request->product;
        $warehouses = $request->whscode;
        $LineTotal = $request->linetotal;
        $quantity = $request->quantity;
        $unit = $request->unit;
        $pquantity = $request->pquantity ? $request->pquantity : $request->quantity;
        $unitprice = $request->unitprice;
        $discprice = $request->discprice;
        $taxcode = $request->taxcode;
        $serialno = $request->serialno;
        
        // Remove existing items first (optional, based on your needs)
        PurchaseOrderItem::where('sm_id', $id)->delete();
        
        // Re-insert the items with updated values
        if (is_array($products))
         {
            // return redirect()->back()->with('error', 'No product data provided');
      

            $count = count($products);
            if($count>0)
            {
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
                            if($pquantity[$i] >= $quantity)
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
                                $qtybalance[$i] = $quantity[$i] - $pquantity[$i];
                                DB::table('itemwarehouses as i')
                                ->where('i.ItemCode', $products[$i])
                                ->where('i.WhsCode', session('branch_code'))
                                ->update([
                                    'OnHand' => $bstock->OnHand + $qtybalance[$i]
                                ]);
                
                                DB::table('product_stocks')
                                    ->where('productCode', $products[$i])
                                    ->update([
                                        'onHand' => $pstock->onHand + $qtybalance[$i]
                                    ]);
                
                            }
                
                        }
                        
                        else
                        {
                
                            DB::table('itemwarehouses as i')
                            ->where('i.ItemCode', $products[$i])
                            ->where('i.WhsCode', session('branch_code'))
                            ->update([
                                'OnHand' => $bstock->OnHand + $quantity[$i]
                            ]);
                
                            DB::table('product_stocks')
                                ->where('productCode', $products[$i])
                                ->update([
                                    'onHand' => $pstock->onHand + $quantity[$i]
                                ]);
                
                        }   
                    } 
                        $purchaseorderItem = new PurchaseOrderItem;
                        $purchaseorderItem->sm_id = $purchaseorder->id;
                        $purchaseorderItem->item_id = $products[$i];
                        $purchaseorderItem->whs_code = $warehouses[$i];
                        $purchaseorderItem->unit = $unit[$i];
                        $purchaseorderItem->qty = $quantity[$i];
                        $purchaseorderItem->open_qty = $quantity[$i];
                        $purchaseorderItem->unit_price = $unitprice[$i];
                        $purchaseorderItem->disc_price = $discprice[$i];
                        $purchaseorderItem->tax_code = $taxcode[$i];
                        $purchaseorderItem->line_total = $LineTotal[$i];
                        $purchaseorderItem->serial_no = $serialno[$i];
                        $purchaseorderItem->status = "Open";
                        $purchaseorderItem->save();
                    }
                }
            }
        }

        $type=$request->type;
        if($type=='Purchase Order')
        {
            $path='admin/goods-receipt';
        }
        else
        {
            $path='admin/goods-expense';
        }
    
        return redirect($path)->with('success', $type.' Updated Successfully');
    }    

    public function insert(Request $request)
    {
        if(isset($request->type) && ($request->type=='Purchase Order'))
        {
           
             $validator = $request->validate([
                'customer' => 'required', 
                'product' => 'required|array|min:1',
                'quantity' => 'required|array|min:1'
            ]);
        }
        if($request->type=='Purchase Order')
        {
        $extype='supplier';
        }
        else
        {
         $extype='misc';
        }

            $docnum = $request->doc_list . "-" . $request->docNumber;
            
            $puchaseorder = new PurchaseOrderMaster;
            $puchaseorder->cid = $request->customer;
            $puchaseorder->ref_no = $request->refno;
            $puchaseorder->obj_type = $request->type;
            $puchaseorder->exp_type = $extype;
            $puchaseorder->invoice_no = $request->inv_no ?? NULL;
            $puchaseorder->payment_method = $request->ptype ?? NULL;
            // $puchaseorder->add_type_bill_to = $request->bill_to;
            // $puchaseorder->add_type_ship_to = $request->ship_to;
            $puchaseorder->address_bill = $request->bill_to_address;
            $puchaseorder->address_ship = $request->ship_to_address;
            $puchaseorder->pl_supply = $request->place_of_sply;
            // $puchaseorder->tax_type = $request->tax_type;
            $puchaseorder->doc_num = $docnum;
            $puchaseorder->status = $request->status;
            $puchaseorder->branch = session('branch_code');
            $puchaseorder->posting_date = $request->posting_date;
            $puchaseorder->docdue_date = $request->delivery_date;
            $puchaseorder->doc_date = $request->DocuDate;
            // $puchaseorder->payment_term = $request->payment_term;
            $puchaseorder->tax_regno = $request->tax_reg_no;
            $puchaseorder->open_quotation = $request->open_qutn ? $request->open_qutn : 0;
            $puchaseorder->sales_emp_id = auth()->user()->id;//$request->partner3;
            $puchaseorder->remarks = $request->remarks;
            $puchaseorder->total_bf_discount = $request->total_bef_discount;
            $puchaseorder->discount_percent = $request->discount;
            $puchaseorder->discount_amount = $request->discount_amount_value;
            $puchaseorder->total_exp = $request->expense;
            $puchaseorder->tax_amount = $request->tax_amount;
            $puchaseorder->rounding = $request->roundtext;
            $puchaseorder->total = $request->grand_total;
            $puchaseorder->createdBy = Auth::user()->id;
            $puchaseorder->updatedBy = null;
            $puchaseorder->save();

            $puchaseorder_id = $puchaseorder->id;
            
            // Ensure all the arrays are treated properly
            $quotation_item_id = is_array($request->quotation_item_id) ? $request->quotation_item_id : [];
            $products = is_array($request->product) ? $request->product : [];
            $warehouses = is_array($request->whscode) ? $request->whscode : [];
            $quantity = is_array($request->quantity) ? $request->quantity : [];
            $unit = is_array($request->unit) ? $request->unit : [];
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
        
            if (!empty($products[$i]) && !empty($quantity[$i])) {
            // dd("hlo");
                // if (isset($av_quantity[$i]) && isset($quotation_item_id[$i]) && $av_quantity[$i] != '0' && $quotation_item_id[$i] != '0') {
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
                                'OnHand' => $bstock->OnHand + $quantity[$i]
                            ]);

                        DB::table('product_stocks')
                            ->where('productCode', $products[$i])
                            ->update([
                                'onHand' => $pstock->onHand + $quantity[$i]
                            ]);
                    } else {
                        // Optional: Log or handle products without an existing stock record
                        error_log("No stock found for productCode={$products[$i]}");
                    }
                // }

                $puchaseorderItem = new PurchaseOrderItem;
                $puchaseorderItem->sm_id = $puchaseorder_id;
                $puchaseorderItem->quotation_item_id = $quotation_item_id[$i] ?? 0;
                $puchaseorderItem->item_id = $products[$i];
                $puchaseorderItem->unit = $unit[$i];
                $puchaseorderItem->whs_code = $warehouses[$i];
                $puchaseorderItem->qty = $quantity[$i];
                $puchaseorderItem->open_qty = $quantity[$i];
                $puchaseorderItem->unit_price = $unitprice[$i];
                $puchaseorderItem->disc_price = $discprice[$i];
                $puchaseorderItem->tax_code = $taxcode[$i];
                $puchaseorderItem->line_total = $LineTotal[$i];
                $puchaseorderItem->serial_no = $serialno[$i];
                $puchaseorderItem->status = "Open";
                $puchaseorderItem->save();
            }
        }
        session()->flash('success',$request->type.' added successfully');
        return response()->json([
            'success' => true,
            'puchaseorder_id' => $puchaseorder_id,  // Pass the saved Sales Order ID
            'message' => ".$request->type.'added successfully'"
        ]);

        // return redirect('admin/purchase-order/' . $puchaseorder_id)->with('success', 'Purchase Order added successfully');
    }

public function download_excel(Request $request)
    {
        // dd($request);
        try 
        {
            // dd(Auth::user()->id);
            //$data = QuotationItem::query();
            $data = PurchaseOrderItem::join('purchase_order_masters', 'purchase_order_items.sm_id', '=', 'purchase_order_masters.id')
            ->join('products', 'purchase_order_items.item_id', '=', 'products.productCode')
            ->join('customers', 'purchase_order_masters.cid', '=', 'customers.customer_code')
            ->join('partners', 'purchase_order_masters.sales_emp_id', '=', 'partners.partner_code')
            ->select('purchase_order_masters.doc_num',
            'purchase_order_masters.status',
            'purchase_order_masters.doc_date',
            'purchase_order_items.item_id',
            'products.productName',
            'products.brand',
            'purchase_order_items.qty',
            'purchase_order_items.line_total',
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
                $data->where('purchase_order_masters.docdue_date', '>=', $request->from_date);
            }
            if (!empty($request->to_date)) {
                //echo "here2";
                $data->where('purchase_order_masters.docdue_date', '<=', $request->to_date);
            }
            if (!empty($request->customer)) {
                //echo "here";
                $data->where('purchase_order_masters.cid', $request->customer);
            }
            if (!empty($request->user)) {
                //echo "here";
                $data->where('purchase_order_masters.sales_emp_id', $request->user);
            }
            if (!empty($request->status)) {
                if ($request->status == "All") {
                    // $request->status= 'Cancel';
                    // $data->where('quotations.status', '!=', $request->status);
                    //$data->whereIn('purchase_order_masters.status','Open');
                    $data->whereIn('purchase_order_masters.status',$request->stsval);
                } else {
                    $data->where('purchase_order_masters.status', $request->status);
                }
            } else {
                $data->where('purchase_order_masters.status', '!=', 'Cancel');
            }
            //dd($data->toSql(), $data->getBindings()) ;
            $data->orderBy('doc_date',"desc");
            //dd($data);
            $file_name = 'purchase_order'.time().'.xlsx';
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
        $purchaseorder = PurchaseOrderMaster::find($id);
        $data = '';
        if ($purchaseorder->status == 'Confirm') {
            $data = "Purchase order is already confirmed!";
        } else {
            $purchaseorder->status = 'Cancel';
            $purchaseorder->cancelReason = $request->cancel_reason;
            $purchaseorder->save();
            $data = "Purchase order is cancelled!";
        }
        echo json_encode($data);
    }


}



