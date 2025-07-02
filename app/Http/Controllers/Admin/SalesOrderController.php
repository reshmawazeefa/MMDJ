<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Partner;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductPrice;
use App\Models\SalesOrderMaster;
use App\Models\SalesOrderItem;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\CustomQuotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SalesOrderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        
    }

    public function create()
    {
        return view('admin.create_salesorder');
    }

    public function edit($id)
    {
        $details = SalesOrderMaster::select('sales_order_masters.*')->with(array('Item_details.products.stock','customer','referral1','referral2','referral3','user'))->find($id); 
        //dd($details);

        return view('admin.edit_salesorder', compact('details'));
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
    //  dd($request);
    $validator = $request->validate([
        'customer' => 'required',
        'product' => 'required|array|min:1',
        'quantity' => 'required|array|min:1'
    ]);

    // Find existing SalesOrderMaster by id
    $salesorder = SalesOrderMaster::find($id);
    if (!$salesorder) {
        return redirect()->back()->with('error', 'Sales Order not found');
    }

    // $docnum = $request->doc_list . "-" . $request->docNumber;

    // Update the SalesOrderMaster fields
    $salesorder->cid = $request->customer;
    $salesorder->ref_no = $request->refno;
    $salesorder->add_type_bill_to = $request->bill_to;
    $salesorder->add_type_ship_to = $request->ship_to;
    $salesorder->address_bill = $request->bill_to_address;
    $salesorder->address_ship = $request->ship_to_address;
    $salesorder->pl_supply = $request->place_of_sply;
    $salesorder->tax_type = $request->tax_type;
    // $salesorder->doc_num = $docnum;
    //$salesorder->status = $request->status;
    $salesorder->posting_date = $request->DocuDate;//$request->posting_date;
    $salesorder->delivery_date = $request->delivery_date;
    $salesorder->doc_date = $request->DocuDate;
    $salesorder->payment_term = $request->payment_term;
    $salesorder->tax_regno = $request->tax_reg_no;
    $salesorder->open_quotation = $request->open_qutn ? $request->open_qutn : 0;
    $salesorder->sales_emp_id = auth()->user()->id;//$request->partner3;
    $salesorder->remarks = $request->remarks;
    $salesorder->total_bf_discount = $request->total_bef_discount;
    $salesorder->discount_percent = $request->discount;
    $salesorder->discount_amount = $request->discount_amount_value;
    $salesorder->total_exp = $request->expense;
    $salesorder->tax_amount = $request->tax_amount;
    $salesorder->rounding = $request->roundtext;
    $salesorder->total = $request->grand_total;
    $salesorder->updatedBy = Auth::user()->id;  // You may want to track who updated it
    $salesorder->save();

    // Update the SalesOrderItem details
    $products = $request->product;
    $warehouses = $request->whscode;
    $unit = $request->unit;
    $quantity = $request->quantity;
    $pquantity = $request->pquantity;
    $LineTotal = $request->linetotal;
    $unitprice = $request->unitprice;
    $discprice = $request->discprice;
    $taxcode = $request->taxcode;
    $serialno = $request->serialno;
    
    // Remove existing items first (optional, based on your needs)
    SalesOrderItem::where('sm_id', $id)->delete();
    
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


            $salesorderItem = new SalesOrderItem;
            $salesorderItem->sm_id = $salesorder->id;
            $salesorderItem->item_id = $products[$i];
            $salesorderItem->unit = $unit[$i];
            $salesorderItem->whs_code = $warehouses[$i];
            $salesorderItem->qty = $quantity[$i];
            $salesorderItem->open_qty = $quantity[$i];
            $salesorderItem->unit_price = $unitprice[$i];
            $salesorderItem->disc_price = $discprice[$i];
            $salesorderItem->tax_code = $taxcode[$i];
            $salesorderItem->line_total = $LineTotal[$i];
            $salesorderItem->serial_no = $serialno[$i];
            $salesorderItem->status = 'Open';
            $salesorderItem->save();
        }
    }

    //return redirect('admin/sales-order/' . $id)->with('success', 'Sales Order updated successfully');
    return redirect('admin/sales-order')->with('success', 'Sales Order updated successfully');
}
 

public function insert(Request $request)
{
   // dd($request);
    $validator = $request->validate([
        'customer' => 'required', 
        'partner3' => 'required', 
        'product' => 'required|array|min:1',
        'quantity' => 'required|array|min:1'
    ]);

    $docnum = $request->doc_list . "-" . $request->docNumber;
    
    $salesorder = new SalesOrderMaster;
    $salesorder->cid = $request->customer;
    $salesorder->ref_no = $request->refno;
    $salesorder->add_type_bill_to = $request->bill_to;
    $salesorder->add_type_ship_to = $request->ship_to;
    $salesorder->address_bill = $request->bill_to_address;
    $salesorder->address_ship = $request->ship_to_address;
    $salesorder->pl_supply = $request->place_of_sply;
    $salesorder->tax_type = $request->tax_type;
    $salesorder->doc_num = $docnum;
    $salesorder->status = $request->status;
    $salesorder->branch = session('branch_code');
    $salesorder->posting_date = $request->DocuDate;//$request->posting_date;
    $salesorder->delivery_date = $request->delivery_date;
    $salesorder->doc_date = $request->DocuDate;
    $salesorder->payment_term = $request->payment_term;
    $salesorder->tax_regno = $request->tax_reg_no;
    $salesorder->open_quotation = $request->open_qutn ? $request->open_qutn : 0;
    $salesorder->sales_emp_id = auth()->user()->id;//$request->partner3;
    $salesorder->remarks = $request->remarks;
    $salesorder->total_bf_discount = $request->total_bef_discount;
    $salesorder->discount_percent = $request->discount;
    $salesorder->discount_amount = $request->discount_amount_value;
    $salesorder->total_exp = $request->expense;
    $salesorder->tax_amount = $request->tax_amount;
    $salesorder->rounding = $request->roundtext;
    $salesorder->total = $request->grand_total;
    $salesorder->createdBy = Auth::user()->id;
    $salesorder->updatedBy = null;
    $salesorder->save();

    $salesorder_id = $salesorder->id;
    
    // Ensure all the arrays are treated properly
    $quotation_item_id = is_array($request->quotation_item_id) ? $request->quotation_item_id : [];
    $products = is_array($request->product) ? $request->product : [];
    $warehouses = is_array($request->whscode) ? $request->whscode : [];
    $unit = is_array($request->unit) ? $request->unit : [];
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

            error_log("Processing product index $i: Product={$products[$i]}, Quantity={$quantity[$i]}, Warehouse={$warehouses[$i]}");

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

            if (isset($av_quantity[$i]) && isset($quotation_item_id[$i]) && $av_quantity[$i] != '0' && $quotation_item_id[$i] != '0') {
                $balance_qty = $av_quantity[$i] - $quantity[$i];
                
                $quotationitem = QuotationItem::find($quotation_item_id[$i]);
                
                if ($quotationitem) {
                    if ($balance_qty > 0) {
                        $quotationitem->open_qty = $balance_qty;
                    } else {
                        $quotationitem->open_qty = $balance_qty;
                        $quotationitem->status = 'Confirm';
                    }
                    $quotationitem->save();
                }
            }

            $salesorderItem = new SalesOrderItem;
            $salesorderItem->sm_id = $salesorder_id;
            $salesorderItem->quotation_item_id = $quotation_item_id[$i] ?? 0;
            $salesorderItem->unit = $unit[$i];
            $salesorderItem->item_id = $products[$i];
            $salesorderItem->whs_code = $warehouses[$i];
            $salesorderItem->qty = $quantity[$i];
            $salesorderItem->open_qty = $quantity[$i];
            $salesorderItem->unit_price = $unitprice[$i];
            $salesorderItem->disc_price = $discprice[$i];
            $salesorderItem->tax_code = $taxcode[$i];
            $salesorderItem->line_total = $LineTotal[$i];
            $salesorderItem->serial_no = $serialno[$i] ?? 0;
            $salesorderItem->status = "Open";
            $salesorderItem->save();
        }
    }
    session()->flash('success', 'Sales Order added successfully');
    return response()->json([
        'success' => true,
        'salesorder_id' => $salesorder_id,  // Pass the saved Sales Order ID
        'message' => 'Sales Order added successfully'
    ]);

    // return redirect('admin/sales-order/' . $salesorder_id)->with('success', 'Sales Order added successfully');
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
        $quotations = DB::table('quotations as q')
                        ->join('quotation_items as qt', 'q.id', '=', 'qt.quotation_id')
                        ->whereIn('q.status', ['Open','Approve'])
                        ->where('q.branch', session('branch_code'))
                        ->where('q.CustomerCode', $request['customer_code'])
                        ->where(function ($query) {
                            $query->where('qt.status', '<>', 'Cancel')
                                ->where('qt.status', '<>', 'Confirm');
                        }) // Exclude items with 'Cancel' or 'Confirm' status
                        ->select('q.id', 'q.DocNo')
                        ->groupBy('q.id', 'q.DocNo')
                        ->get();

        // Return both the customer details and quotations in the JSON response
        return response()->json([
            'customer' => $data,
            'quotations' => $quotations
        ]);
    }
}


    // Added for getting the customer open quotations
    public function get_customer_open_quotations(Request $request)
    {
        if(isset($request['customer_code']))
        {
            // $data = Customer::where('customer_code',$request['customer_code'])
            // ->where('is_active',1)->first();

            $quotations = DB::table('quotations as q')
            ->join('quotation_items as qt', 'q.id', '=', 'qt.quotation_id')
            ->whereIn('q.status', ['Open','Approve']) // Only open quotations
            ->where('q.branch', session('branch_code'))
            ->where('q.CustomerCode', $request['customer_code']) // Customer-specific quotations
            ->where(function ($query) {
                $query->where('qt.status', '<>', 'Cancel')
                    ->where('qt.status', '<>', 'Confirm')
                    ->where('qt.open_qty', '<>', 0);
            }) // Exclude items with 'Cancel' or 'Confirm' status
            ->select('q.id', 'q.DocNo')
            ->groupBy('q.id', 'q.DocNo')
            ->get();
                
                return response()->json($quotations);
        
        }
    }

    
    public function get_quotation_details(Request $request)
    {
        if ($request->ajax()) {

            $quotationId = $request['quotation'];
            $quotations = Quotation::with([
                'items' => function($query) {
                    $query->where('status', '!=', 'Cancel');
                    $query->where('open_qty', '<>', 0);
                },
                'items.products.stock.warehouse',
                'customer',
                'referral1',
                'referral2'
            ])
            ->whereIn('quotations.id', $quotationId)->where('quotations.branch',session('branch_code'))->get();
            //   dd($quotations);
            $allItems = collect(); // Initialize an empty collection
            
            // Loop through each quotation and merge its items into the $allItems collection
            foreach ($quotations as $quotation) {
                $allItems = $allItems->merge($quotation->items);
            }
          
            // Format the data to return it as a JSON response for the grid view
            $responseData = $allItems->map(function($item) {
                // dd($item->products->stock->warehouse);
                $line_total = round($item->LineTotal * (100+$item->TaxRate)/100,2);
                return [
                    'productCode' => optional($item->products)->productCode,
                    'productName' => optional($item->products)->productName,
                    'Qty' => $item->open_qty,
                    'UnitPrice' => round($item->UnitPrice * (100+$item->TaxRate)/100,2),
                    'TaxCode' => $item->TaxCode,
                    'whsCode' => $item->products->stock->warehouse->whsCode,
                    'whsName' => $item->products->stock->warehouse->whsName,
                    'LineTotal' => $line_total,
                    'itemid' =>$item->id,
                    'serialno' => 'serialno', // Placeholder value, replace as needed
                    'action' => '<button class="remove-row btn btn-danger btn-sm" value="'.$item->id.'">Remove</button>'
                ];
            });
            // dd($responseData);
          
            return response()->json(['success' => true, 'data' => $responseData], 200);
        }

        return response()->json(['error' => 'Invalid request.'], 400);
    }


    public function salesorder_close_items(Request $request)
    {
        $id=$request['item'];
        $quotation_item = QuotationItem::find($id);
        $data = '';
        if ($quotation_item) {
            //$quotation_item->status = 'Cancel';
            $quotation_item->save();
            $data = "Quotation item is cancelled!";
        }
        echo json_encode($data);
    }

    
}
