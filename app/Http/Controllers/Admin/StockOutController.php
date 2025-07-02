<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\Partner;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductPrice;
use App\Models\SalesOrder;
use App\Models\CustomQuotation;
use App\Models\SalesOrderItem;
use App\Models\SalesInvoiceMaster;
use App\Models\SalesInvoiceItem;
use App\Models\StockOutMaster;
use App\Models\StockOutItem;
use App\Models\StockTransferRequest;
use App\Models\StockTransferRequestItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;
use Rap2hpoutre\FastExcel\FastExcel;


class StockOutController extends Controller
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
                $data = StockOutMaster::select('stock_out_masters.*')->with(array('Branch', 'referral1', 'referral2', 'referral3'))->where('stock_out_masters.from_branch', session('branch_code'));
            } else {
                $data = StockOutMaster::select('stock_out_masters.*')->with(array('Branch', 'referral1', 'referral2', 'referral3'))->where('stock_out_masters.from_branch', session('branch_code'))
                    ->where(function ($query) {
                        $query->where('manager1', Auth::user()->id)
                            ->orWhere('manager2', Auth::user()->id)
                            ->orWhere('createdBy', Auth::user()->id);
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
            if (!empty($request->branch)) {
                //echo "here";
                $data->where('stock_out_masters.to_branch', $request->branch);
            }
           
            if (!empty($request->user)) {
                //echo "here";
                $data->where('stock_out_masters.emp_id', $request->user);
            }
            if (!empty($request->status)) {
                if ($request->status == "All") {
                    $data->where('stock_out_masters.status', '!=', 'Cancel');
                } else {
                    $data->where('stock_out_masters.status', $request->status);
                }
            } else {
                $data->where('stock_out_masters.status', 'Open');
            }
                $data->orderBy('id', 'desc');

                return Datatables::of($data)
                ->addColumn('DocNo', function ($row) {
                    if ($row->doc_number)
                        return $row->doc_number;
                    else
                        return null;

                })
                ->addColumn('action', function ($row) {
                    $url = url('admin/stockout/' . $row->id);
                    $url_edit = url('admin/stockout/' . $row->id . '/edit');
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
                ->addColumn('to_branch_name', function ($row) {
                    return $row->to_branch_name ?? 'N/A';
                })
                ->addColumn('DocDate', function ($row) {
                    if ($row->doc_date)
                        return date('d-m-Y', strtotime($row->doc_date));
                    else
                        return null;

                })
                ->addColumn('Deliverydate', function ($row) {
                    if ($row->delivery_date)
                        return date('d-m-Y', strtotime($row->delivery_date));
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
                ->addColumn('emp_id', function ($row) {
                    if ($row->referral3)
                        return $row->referral3->name;
                    else
                        return null;

                })
                ->addColumn('total_qty', function ($row) {
                    if ($row->total_qty)
                        return $row->total_qty;
                    else
                        return null;

                })
                ->addColumn('total_price', function ($row) {
                    if ($row->total_price)
                        return $row->total_price;
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

        return view('admin.stockout');
    }

    public function get_branches(Request $request)//get Customers
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = Branch::select("*")
            ->where(function($query) use ($search){$query->where('BranchName','LIKE',"%$search%")
            ->orWhere('phone','LIKE',"%$search%");
            })
            ->skip($offset)->take($resultCount)->get();

            $count = Branch::select("id","Phone","BranchName","BranchCode")
            // ->where('is_active',1)
            ->where(function($query) use ($search){$query->where('BranchName','LIKE',"%$search%");
            })->count();

        }
        else{
            // DB::enableQueryLog();
        /** get the users**/

        $data = DB::table('branches')
        ->skip($offset)->take($resultCount)->get();
        // $data = Branch::select("*")->skip($offset)->take($resultCount)->get();

        $count = DB::table('branches')->select("id","Phone","BranchName","BranchCode")->count();
        // $queries = DB::getQueryLog();
// print_r($queries);
        }
        // dd($data);

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

    public function create()
    {
        $branch = DB::table('branches')
        ->select('id', 'BranchCode', 'BranchName','Address')
        ->groupBy('id', 'BranchCode')
        ->get();
    
        // Get the branch code from the session
        $branchcode = session('branch_code');
        
        // Retrieve the current branch address
        $branch_address = DB::table('branches')
            ->where('BranchCode', '=', $branchcode)
            ->select('id', 'BranchCode', 'BranchName', 'Address')
            ->groupBy('id', 'BranchCode')
            ->first(); // Use first() to get a single record
        // dd($branch_address);
        return view('admin.create_stockout', ['branch' => $branch, 'address_details' => $branch_address]);
    
    }

    // Added for getting the customer details
    public function get_stock_details(Request $request)
    {

        if(isset($request['branch_code']))
        {
            // Fetch the customer details
            $data = StockTransferRequest::from('stock_transfer_requests as s')
            ->where('s.to_branch', $request['branch_code'])
            ->join('partners', 's.emp_id', '=', 'partners.partner_code')
            ->where('s.status', 'open')
            ->first();
        
            // Fetch the quotations related to the customer
            $stock_transfer = DB::table('stock_transfer_requests as s')
                            ->join('stock_transfer_request_items as st', 's.id', '=', 'st.sm_id')
                            
                            ->where('s.status', 'Open')
                            ->where('s.to_branch', $request['branch_code'])
                            ->select('s.id', 's.doc_number', DB::raw('SUM(st.qty) as total_qty'), DB::raw('MAX(st.status) as status'))
                            ->groupBy('s.id', 's.doc_number') 
                            ->get();

            // Return both the customer details and quotations in the JSON response
            return response()->json([
                'branch' => $data,
                'stocktransfer' => $stock_transfer
            ]);
        }
    }

    public function get_branch_open_stock(Request $request)
    {
        if(isset($request['branch_code']))
        {
            // $data = Customer::where('customer_code',$request['customer_code'])
            // ->where('is_active',1)->first();

            $stocktransfer = DB::table('stock_transfer_requests as s')
            ->join('stock_transfer_request_items as st', 's.id', '=', 'st.sm_id')
            ->where('s.status', 'open') // Only open quotations
            ->where('s.to_branch', $request['branch_code']) // Customer-specific quotations
            ->where(function ($query) {
                $query->where('st.qty', '<>', 0)
                    ->where('st.status', '<>', 'Cancel');
                    // ->where('st.status', '<>', 'Confirm')
            }) // Exclude items with 'Cancel' or 'Confirm' status
            ->select('s.id', 's.doc_number')
            ->groupBy('s.id', 's.doc_number')
            ->get();
                return response()->json($stocktransfer);
        
        }
    }

    public function get_stocktransfer_details(Request $request)
    {
        if ($request->ajax()) {

            $sorderId = $request['stock_transfer'];

            $stock_transfer = DB::table('stock_transfer_requests')
            ->join('stock_transfer_request_items', 'stock_transfer_requests.id', '=', 'stock_transfer_request_items.sm_id')
            ->join('products', 'stock_transfer_request_items.item_id', '=', 'products.productCode')
            ->join('product_stocks', 'products.productCode', '=', 'product_stocks.productCode')
            ->join('warehouses', 'product_stocks.whsCode', '=', 'warehouses.whsCode')
            ->join('branches', 'stock_transfer_requests.to_branch', '=', 'branches.BranchCode')
            // ->join('itemwarehouses', function ($join) {
            //     $join->on('branches.BranchCode', '=', 'itemwarehouses.WhsCode')
            //          ->on('products.productCode', '=', 'itemwarehouses.ItemCode');  // Second condition
            // })  // Use alias 'i'
            ->whereIn('stock_transfer_requests.id', $sorderId)
            // ->where('itemwarehouses.WhsCode', session('branch_code'))
            ->where(function ($query) {
                $query->where('stock_transfer_request_items.status', '<>', 'Cancel')
                      ->where('stock_transfer_request_items.status', '<>', 'Confirm')
                      ->where('stock_transfer_request_items.qty', '<>', 0);
            })
            ->select(
                'stock_transfer_requests.*', 
                'stock_transfer_request_items.*', 
                'products.productCode', 
                'products.productName', 
                'product_stocks.whsCode', 
                'warehouses.whsName', 
                'branches.*',
                'stock_transfer_request_items.qty', 
                'stock_transfer_request_items.open_qty', 
                'stock_transfer_request_items.unit_price', 
                'stock_transfer_request_items.id', 
                'stock_transfer_request_items.status'
            )
            ->get();
            $stock_data = DB::table('stock_transfer_requests')
            ->join('stock_transfer_request_items', 'stock_transfer_requests.id', '=', 'stock_transfer_request_items.sm_id')
            ->join('products', 'stock_transfer_request_items.item_id', '=', 'products.productCode')
            ->join('branches', 'stock_transfer_requests.to_branch', '=', 'branches.BranchCode')
            ->join('itemwarehouses', function ($join) {
                $join->on('products.productCode', '=', 'itemwarehouses.ItemCode');
            })
            ->whereIn('stock_transfer_requests.id', $sorderId)
            ->where('itemwarehouses.WhsCode', session('branch_code'))
            ->select('products.productCode', 'itemwarehouses.OnHand')
            ->get()
            ->keyBy('productCode'); // Key by productCode for easier lookup
        
        // Map the main response data and add `OnHand` value from `$stock_data`
        $responseData = $stock_transfer->map(function($item) use ($stock_data) {
            // Get OnHand stock if available
            $onHand = $stock_data->get($item->productCode)->OnHand ?? null;
        
            return [
                'productCode' => $item->productCode,
                'productName' => $item->productName,
                'Qty' => $item->open_qty,
                'UnitPrice' => round($item->unit_price, 2),
                'whsCode' => $item->whsCode,
                'whsName' => $item->whsName,
                'OnHand' => $onHand, // Add OnHand value here
                'itemid' => $item->id,
                'status' => $item->status,
                'action' => '<button class="remove-row btn btn-danger btn-sm" value="' . $item->id . '">Remove</button>'
            ];
        });

// dd($responseData);
            return response()->json(['success' => true, 'data' => $responseData], 200);
        }

        return response()->json(['error' => 'Invalid request.'], 400);
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
        $branch = DB::table('branches')
        ->select('id', 'BranchCode', 'BranchName','Address')
        ->groupBy('id', 'BranchCode')
        ->get();
        $details = StockOutMaster::select('stock_out_masters.*')->with(array('Item_details.products.stock.warehouse', 'customer', 'referral1', 'referral2','referral3','branch'))->find($id); //print_r($details);
        //echo(json_encode($details));
       //dd($details);
        return view('admin.edit_stockout', compact('details','branch'));
    }

    public function update(Request $request, $id)
    {
   
        $validator = $request->validate([
            'product' => 'required|array|min:1',
            'quantity' => 'required|array|min:1'
        ]);
    
        // Find existing SalesOrderMaster by id
        $stock_out = StockOutMaster::find($id);
        if (!$stock_out) {
            return redirect()->back()->with('error', 'Stock out not found');
        }
    
        // $docnum = $request->doc_list . "-" . $request->docNumber;
    
        // Update the SalesOrderMaster fields
        $stock_out->from_branch = session('branch_code');//$request->from_branch;
        $stock_out->from_branch_name = session('branch_name');//$request->from_branch;
        $stock_out->to_branch = $request->to_branch;
        $stock_out->to_branch_name = $request->to_branch_name;
        $stock_out->address_billto = $request->bill_to_address;
        //$stock_out->doc_number = $docnum;
        $stock_out->status = $request->status;
        $stock_out->posting_date = $request->posting_date;
        $stock_out->delivery_date = $request->delivery_date;
        $stock_out->doc_date = $request->DocuDate;
        $stock_out->emp_id = $request->partner3;
        $stock_out->remarks = $request->remarks;
        $stock_out->total_qty = $request->total_qty;
        $stock_out->total_price = $request->total_price;
        $stock_out->updatedBy = Auth::user()->id;  // You may want to track who updated it
        $stock_out->save();
    
        // Update the SalesOrderItem details
        $products = $request->product;
        $warehouses = $request->whscode;
        $quantity = $request->quantity;
        $unitprice = $request->unitprice;
        $serialno = $request->serialno;
        # $discprice = $request->discprice;
        
        // Remove existing items first (optional, based on your needs)
        StockOutItem::where('sm_id', $id)->delete();
        
        // Re-insert the items with updated values
        $count = count($products);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($products[$i]) && !empty($quantity[$i]) && !empty($warehouses[$i])) {
                
   
                $stockoutItem = new StockOutItem;
                $stockoutItem->sm_id = $stock_out->id;
                $stockoutItem->item_id = $products[$i];
                $stockoutItem->whscode = $warehouses[$i];
                $stockoutItem->qty = $quantity[$i];
                $stockoutItem->unit_price = $unitprice[$i];
                $stockoutItem->serial_no = $serialno[$i];                
                # $stockoutItem->barcode = $barcode[$i];
                $stockoutItem->status = "Open";
                $stockoutItem->save();
            }
        }
    
        return redirect('admin/stockout/' . $id)->with('success', 'Stock Out updated successfully');
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

    public function insert(Request $request)
    {
      // dd($request);
        $validator = $request->validate([
            // 'customer' => 'required', 
            'product' => 'required|array|min:1',
            'quantity' => 'required|array|min:1'
        ]);

        $docnum = $request->doc_list . "-" . $request->docNumber;
        
        $stockout = new StockOutMaster;
        $stockout->from_branch = session('branch_code');//$request->from_branch;
        $stockout->from_branch_name = session('branch_name');//$request->from_branch;
        $stockout->to_branch = $request->to_branch;
        $stockout->to_branch_name = $request->to_branch_name;
        $stockout->address_billto = $request->bill_to_address;
        $stockout->doc_number = $docnum;
        $stockout->open_stock = $request->open_qutn;
        $stockout->status = $request->status;
        $stockout->posting_date = $request->posting_date;
        $stockout->delivery_date = $request->delivery_date;
        $stockout->doc_date = $request->DocuDate;
        $stockout->emp_id = $request->partner3;
        $stockout->remarks = $request->remarks;
        $stockout->total_qty = $request->total_qty;
        $stockout->total_price = $request->total_price;
        $stockout->createdBy = Auth::user()->id;
        $stockout->updatedBy = null;
        $stockout->save();

        $stockout_id = $stockout->id;

        // if(isset($stockout->open_stock))
        // {
        //     $result = StockTransferRequest::find($stockout->open_stock);
        //      if ($result) {
        //          $result->status = 'Confirm';
        //           $result->save();
        //      }
        // }
        // Ensure all the arrays are treated properly
        $invoice_item_id = is_array($request->quotation_item_id) ? $request->quotation_item_id : [];
        $products = is_array($request->product) ? $request->product : [];
        $warehouses = is_array($request->whscode) ? $request->whscode : [];
        $quantity = is_array($request->quantity) ? $request->quantity : [];
        $av_quantity = is_array($request->av_quantity) ? $request->av_quantity : [];
        $unitprice = is_array($request->unitprice) ? $request->unitprice : [];
        $serialno = is_array($request->serialno) ? $request->serialno : [];
        
        $count = count($products);
        $lineNo = 1;
        $grand_total = 0;
        
        for ($i = 0; $i < $count; $i++) {
            if (!isset($quantity[$i]) || !$quantity[$i]) {
                $quantity[$i] = 1;
            }
            
            if (!empty($products[$i]) && !empty($quantity[$i]) && !empty($warehouses[$i])) {
                // Debugging Output to confirm each product iteration
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

                $balance_qty = floatval($av_quantity[$i]) - floatval($quantity[$i]);
                if (isset($invoice_item_id[$i])) {
                    $quotationitem = StockTransferRequestItems::where('id', $invoice_item_id[$i])->first();
                
                    if ($quotationitem) {
                        if ($balance_qty > 0) 
                        {
                            $quotationitem->open_qty = $balance_qty;
                        } 
                        else {
                            // dd("hi");
                            $quotationitem->open_qty = $balance_qty;
                            $quotationitem->status = 'Confirm';
                
                            $result = StockTransferRequest::find($stockout->open_stock);
                            if ($result) {
                                $result->status = 'Confirm';
                                $result->save();
                            }
                        }
                
                        $quotationitem->save();
                    }
                } else {
                    dd("Undefined index: $i in invoice_item_id", $invoice_item_id);
                }

                $stockoutItem = new StockOutItem;
                $stockoutItem->sm_id = $stockout_id;
                $stockoutItem->item_id = $products[$i];
                $stockoutItem->whscode = $warehouses[$i];
                $stockoutItem->qty = $quantity[$i];
                $stockoutItem->open_qty = $quantity[$i];
                $stockoutItem->balance_stock = $bstock ? ($bstock->OnHand - $quantity[$i]) : 0;
                $stockoutItem->unit_price = $unitprice[$i];
                $stockoutItem->serial_no = $serialno[$i];                
                $stockoutItem->status = "Open";
                $stockoutItem->save();
            }
        }
        
        session()->flash('success', 'Stock Out added successfully');
        
        // return response()->json([
        //     'success' => true,
        //     'stockout_id' => $stockout_id,  // Pass the saved Sales Order ID
        //     'message' => 'Stock Out added successfully'
        // ]);

        // return redirect('admin/stockout/' . $stockout_id)->with('success', 'Stock Out added successfully');
        return redirect('admin/stock-out')->with('success', 'Stock Out added successfully');
    }

    public function get_invoice_details(Request $request)
    {
        //dd($request);
        if ($request->ajax()) {

            $invoiceId = $request['invoice'];
            $salesorders = DB::table('sales_invoice_masters')
            ->join('sales_invoice_items', 'sales_invoice_masters.id', '=', 'sales_invoice_items.sm_id')
            ->join('products', 'sales_invoice_items.item_id', '=', 'products.productCode')
            ->join('product_stocks', 'products.productCode', '=', 'product_stocks.productCode')
            ->join('warehouses', 'product_stocks.whsCode', '=', 'warehouses.whsCode')
            ->join('customers', 'sales_invoice_masters.cid', '=', 'customers.customer_code')
            ->whereIn('sales_invoice_masters.id', $invoiceId) // equivalent to WHERE IN (4, 2)
            // ->where('sales_invoice_items.status', '!=', 'Cancel')
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
                'sales_invoice_items.status'
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
        // dd($responseData);
            return response()->json(['success' => true, 'data' => $responseData], 200);
        }

        return response()->json(['error' => 'Invalid request.'], 400);
    }

    public function stocktransfer_close_items(Request $request)
    {
        $id=$request['item'];
        $stocktransfer_item = StockTransferRequestItems::find($id);
        $data = '';
        if ($stocktransfer_item) {
            $stocktransfer_item->status = 'Cancel';
            $stocktransfer_item->save();
            $data = "Stock transfer item is cancelled!";
        }
        echo json_encode($data);
    }
    public function show($id)
    {
        $details = StockOutMaster::select('stock_out_masters.*')->with(array('Item_details.products.stock.warehouse', 'customer', 'referral1', 'referral2','referral3'))->find($id); 
        //dd($details);
        return view('admin.stock_out_details', compact('details'));
    }

    public function close(Request $request, $id)
    {
       // dd($request);
        $stock_out = StockOutMaster::find($id);
        $data = '';
        if ($stock_out->status == 'Confirm') {
            $data = "Stock Out is already confirmed!";
        } else {
            $stock_out->status = 'Cancel';
            $stock_out->cancelReason = $request->cancel_reason;
            $stock_out->save();
            $data = "Stock Out is cancelled!";
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
            $data = StockOutMaster::join('stock_out_items', 'stock_out_items.sm_id', '=', 'stock_out_masters.id')
            ->join('products', 'stock_out_items.item_id', '=', 'products.productCode')
            ->join('branches', 'stock_out_masters.to_branch', '=', 'branches.BranchCode')
            ->join('partners', 'stock_out_masters.emp_id', '=', 'partners.partner_code')
            ->where('stock_out_masters.from_branch', session('branch_code'))
            ->select('stock_out_masters.doc_number',
            'stock_out_masters.status',
            'stock_out_masters.doc_date',
            'stock_out_items.item_id',
            'products.productName',
            'products.brand',
            'branches.BranchName',
            'branches.BranchCode',
            'stock_out_items.qty',
            'stock_out_items.unit_price',
            'partners.name as employee_name',);
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
                $data->where('stock_out_masters.doc_date', '>=', $request->from_date);
            }
            if (!empty($request->to_date)) {
                //echo "here2";
                $data->where('stock_out_masters.doc_date', '<=', $request->to_date);
            }
            if (!empty($request->branch)) {
                //echo "here";
                $data->where('stock_out_masters.to_branch', $request->branch);
            }

            if (!empty($request->user)) {
                //echo "here";
                $data->where('stock_out_masters.emp_id', $request->user);
            }
            if (!empty($request->status)) {
                if ($request->status == "All") {
                    // $request->status= 'Cancel';
                    // $data->where('quotations.status', '!=', $request->status);
                    //$data->whereIn('sales_return_masters.status','Open');
                    $data->whereIn('stock_out_masters.status',$request->stsval);
                } else {
                    $data->where('stock_out_masters.status', $request->status);
                }
            } else {
                $data->where('stock_out_masters.status', '!=', 'Cancel');
            }
            //dd($data->toSql(), $data->getBindings()) ;
            $data->orderBy('doc_date',"desc");
            //dd($data);
            $file_name = 'stock_out_'.time().'.xlsx';
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


public function get_branch_product_stock(Request $request)
{

    $product = DB::table('itemwarehouses as i')
    ->join('products', 'i.ItemCode', '=', 'products.productCode')
    ->join('branches', 'i.WhsCode', '=', 'branches.BranchCode')
    ->where('i.ItemCode', $request->productCode)
    ->where('i.WhsCode', session('branch_code'))
    ->first();

if ($product) {
    // Add the price_list as an additional property in the $product object
    $product->price_list = ProductPrice::where('productCode', $request->productCode)->first();
}
// dd($product);
return response()->json($product);

}

public function get_bproduct_details(Request $request)
{
    try {
        $query = $request->input('query');

        $results = Product::join('product_stocks', 'products.productCode', '=', 'product_stocks.productCode')
            ->join('product_prices', 'products.productCode', '=', 'product_prices.productCode')
            ->join('warehouses', 'product_stocks.whsCode', '=', 'warehouses.whsCode')
            ->join('itemwarehouses as i', 'products.productCode', '=', 'i.ItemCode')
            ->join('branches', 'i.WhsCode', '=', 'branches.BranchCode')
            ->where('i.WhsCode', session('branch_code'))
            ->where('products.barcode', '=', $query)
            ->get();

        return response()->json($results);

    } catch (\Exception $e) {
        \Log::error("Error in get_product_details: " . $e->getMessage());
        return response()->json(['error' => 'Server Error: Unable to fetch product details'], 500);
    }
}





}
