<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesOrderMaster;
use App\Models\SalesOrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
public function insert(Request $request)
{
    try {
        $authHeader = $request->header('Authorization');
        $validToken = env('API_STATIC_TOKEN'); // Use .env for security

        if ($authHeader !== $validToken) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


    $whatsup_no = $request->phone_no;
    $customer = DB::table('customers')
    ->where('alt_phone', $whatsup_no)
    ->where('type', 'C')
    ->first();
        if($customer==null)
        {
            return response()->json([
                'error' => 'Invalid phone number'
            ], 409);
        }
        $items = $request['items'];
        $totalAmount = 0;

        foreach ($items as $item) {
            $product = DB::table('product_prices')
                ->where('productCode', $item['pid'])
                ->first(); // Use `first()` instead of `get()`

            if (!$product) {
                return response()->json(['error' => 'Product ID '.$item['pid'].' not found'], 404);
            }

            $lineTotal = $item['pqty'] * $product->price;
            $totalAmount += $lineTotal;
        }


    //$docnum = $request->doc_list . "-" . $request->docNumber;
    $prefix = 'WSJLB-SO';
    $lastOrder = SalesOrderMaster::latest('id')->first();
    if ($lastOrder && preg_match('/^' . preg_quote($prefix) . '(\d+)$/', $lastOrder->doc_num, $matches)) {
    $lastNumber = (int) $matches[1]; // Get the number part
    $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1; // Start from 1 if no previous record
    }

    $newDocNum = $prefix . $nextNumber;


    $salesorder = new SalesOrderMaster;
    $salesorder->cid = $customer->customer_code;
    //$salesorder->ref_no = $request->refno;
    $salesorder->add_type_bill_to = $customer->addressIDBilling;
    $salesorder->add_type_ship_to = $customer->addressID;
    $salesorder->address_bill = $customer->addressBilling;
    $salesorder->address_ship = $customer->address;
    $salesorder->pl_supply = $customer->state;
    //$salesorder->tax_type = $request->tax_type;
    $salesorder->doc_num = $newDocNum;
    $salesorder->status = 'Open';
    $salesorder->branch = 11111;
    $salesorder->posting_date = "null";
    $salesorder->delivery_date = $request->delivery_date;
    $salesorder->doc_date = date('d-m-Y');
   // $salesorder->payment_term = $request->payment_term;
    //$salesorder->tax_regno = $request->tax_reg_no;
    $salesorder->open_quotation =  0;
    $salesorder->sales_emp_id = 1;//for admin
    $salesorder->remarks = $request->remarks ?? null;
    $salesorder->total_bf_discount = $totalAmount;
    $salesorder->discount_percent = 0;//$request->discount;
    $salesorder->discount_amount = 0;//$request->discount_amount_value;
    $salesorder->total_exp =0; //$request->expense;
    $salesorder->tax_amount =0; //$request->tax_amount;
    $salesorder->rounding = 0;//$request->roundtext;
    $salesorder->total = $totalAmount;
    $salesorder->createdBy = 1;
    $salesorder->updatedBy = null;
    $salesorder->save();

    $salesorder_id = $salesorder->id;
    
    // Ensure all the arrays are treated properly
    $quotation_item_id = is_array($request->quotation_item_id) ? $request->quotation_item_id : [];

    $productCodes = collect($items)->pluck('pid')->toArray();
    $productpqty = collect($items)->pluck('pqty')->toArray();
    $uniqueProductCodes = array_unique($productCodes);

    $productDetails = \App\Models\Product::with(['price', 'stock', 'Itemwarehouse'])
        ->whereIn('productCode', $uniqueProductCodes)
        ->get()
        ->keyBy('productCode');

    $count = count($productCodes);

    for ($i = 0; $i < $count; $i++) {
       $productCode = $productCodes[$i] ?? null;
        $productqty = $productpqty[$i] ?? 1;

        if (!$productCode || !isset($productDetails[$productCode])) {
            continue;
        }

        $product = $productDetails[$productCode];
        $qty = $productqty;

        $whsCode = $product->stock->whsCode ?? session('branch_code');
        $unit = $product->price->unit ?? '';
        $uPrice = $product->price->price ?? 0;
        $dPrice = $product->price->price ?? 0;
        $total = ($uPrice) * $qty;

        if (!$product->stock) {
            error_log("No stock found for productCode={$productCode}");
            continue;
        }

        // Update stock
        if ($product->Itemwarehouse && $product->Itemwarehouse->WhsCode == session('branch_code')) {
            DB::table('itemwarehouses')
                ->where('ItemCode', $productCode)
                ->where('WhsCode', session('branch_code'))
                ->update([
                    'OnHand' => max(0, $product->Itemwarehouse->OnHand - $qty)
                ]);
        }

        DB::table('product_stocks')
            ->where('productCode', $productCode)
            ->update([
                'onHand' => max(0, $product->stock->onHand - $qty)
            ]);

        // Insert into sales order items
        $salesorderItem = new SalesOrderItem;
        $salesorderItem->sm_id = $salesorder_id;
        $salesorderItem->quotation_item_id = $quotation_item_id[$i] ?? 0;
        $salesorderItem->unit = $unit;
        $salesorderItem->item_id = $productCode;
        $salesorderItem->whs_code = $whsCode;
        $salesorderItem->qty = $qty;
        $salesorderItem->open_qty = $qty;
        $salesorderItem->tax_code = 0;
        $salesorderItem->unit_price = $uPrice;
        $salesorderItem->disc_price = $dPrice;
        $salesorderItem->line_total = $total;
        $salesorderItem->status = "Open";
        $salesorderItem->save();

    }
       return response()->json([
            'success' => true,
            'salesorder_id' => $salesorder_id,
            'message' => 'Sales Order added successfully'
        ], 201);

    } catch (\Exception $e) {
        \Log::error('Sales Order Insertion Failed: '.$e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong!',
            'error' => $e->getMessage()
        ], 500); // Internal Server Error
    }

    // return redirect('admin/sales-order/' . $salesorder_id)->with('success', 'Sales Order added successfully');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
