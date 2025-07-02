<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Partner;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductPrice;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
class TestController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function print($id)
    {
        $data = Quotation::find($id);

        return view('admin.print_quotation',compact('data'));
    }

    public function create()
    {
        return view('admin.create_quotation_test');
    }

    public function edit($id)
    {
        $quotation = Quotation::with('Items')->find($id); 
        $customer = Customer::where('customer_code', $quotation->CustomerCode)->first();
        $quotation->CustomerName = $customer->name;//print_r($quotation);
        echo json_encode(array($quotation));
        //$details = Quotation::select('quotations.*')->with(array('Items.products.stock','customer','referral1','referral2','referral3'))->find($id); //print_r($details);
        //return view('admin.create_quotation_test', compact('details'));
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
            $data = Customer::select("*")
            ->orWhere('name','LIKE',"%$search%")
            ->orWhere('phone','LIKE',"%$search%")->skip($offset)->take($resultCount)->get();

            $count = Customer::select("id","phone","name")
            ->orWhere('name','LIKE',"%$search%")
            ->orWhere('phone','LIKE',"%$search%")->count();

        }
        else{
        /** get the users**/
        $data = Customer::select("*")->skip($offset)->take($resultCount)->get();

        $count =Customer::select("id","phone","name")->count();
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
            $data = Product::select("productCode","productName")->with('category','stock.warehouse')
            ->orWhere('productName','LIKE',"%$search%")
            ->orWhere('productCode','LIKE',"%$search%")
            ->skip($offset)->take($resultCount)->get();

            $count = Product::select("id","phone","name")
            ->orWhere('productName','LIKE',"%$search%")
            ->orWhere('productCode','LIKE',"%$search%")
            ->count();

        }
        else{
        /** get the users**/
        $data = Product::select("productCode","productName")->with('category','stock.warehouse')->skip($offset)->take($resultCount)->get();

        $count =Product::select("productCode","productName")->count();
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
        $product = ProductStock::with('warehouse','product')->where('productCode',$request->productCode)->where('whsCode',$request->whsCode)->first();

        $product['price_list'] = ProductPrice::where('productCode',$request->productCode)->where('priceList',$request->price_list)->first();
        return response()->json($product);
    }

    public function insert(Request $request)
    {
        $quotation = new Quotation;
        $quotation->CustomerCode = $request->customer;
        $quotation->user_id = Auth::user()->id;
        $quotation->Ref1 = $request->partner1;
        $quotation->Ref2 = $request->partner2;
        $quotation->Ref3 = $request->partner3;
        $quotation->DocDate = $request->date;
        $quotation->DocNo = date("Y").'-'.$request->docNumber;
        $quotation->priceList = $request->priceList;
        $quotation->VehType = $request->vehicle_type;
        $quotation->Distance = $request->km;
        $quotation->Remarks = $request->remarks;
        $quotation->DiscPrcnt = $request->discountPercent;
        $quotation->DiscAmount = $request->discount_amount;
        $quotation->TaxAmount = $request->tax_amount;
        $quotation->DocTotal = $request->grand_total;
        $quotation->save();
        $quotation_id = $quotation->id;
        $products = $request->product;        
        $warehouses = $request->warehouse;        
        $quantity = $request->quantity;      
        $select_uom = $request->select_uom;      
        $disc_perct = $request->disc_perct;
        $count = count($products);
        for($i=0; $i<$count; $i++)
        {
            if(!$quantity[$i])
                $quantity[$i] = 1;
            if(!empty($products[$i]) && !empty($quantity[$i]) && !empty($warehouses[$i]))
            {
                $quotationItem = new QuotationItem;
                $quotationItem->quotation_id = $quotation_id;
                $quotationItem->LineNo = $i+1;
                $quotationItem->ItemCode = $products[$i];
                $quotationItem->whsCode = $warehouses[$i];
                $quotationItem->Qty = $quantity[$i];
                $item = Product::where('productCode',$products[$i])->first();
                if(!empty($item))
                {
                    $price_list = ProductPrice::where('productCode',$products[$i])->where('priceList',$request->priceList)->first();
                    $quotationItem->UOM = $item->invUOM;
                    $quotationItem->SqmtQty = $quantity[$i] * $item->conv_Factor;
                    $quotationItem->SqftQty = $quantity[$i] * $item->sqft_Conv;
                    if(!empty($price_list))
                    {
                        $quotationItem->UnitPrice = $price_list->price;
                        $quotationItem->LineDiscPrcnt = $disc_perct[$i];
                        $quotationItem->PriceAfterDisc = ($price_list->price - $price_list->price * $disc_perct[$i]/100) * $quantity[$i];
                        $quotationItem->TaxRate = $item->taxRate;
                        $quotationItem->TaxAmount = $quotationItem->PriceAfterDisc * $item->taxRate/100;
                        $quotationItem->LineTotal = $quotationItem->PriceAfterDisc + $quotationItem->TaxAmount;
                        $quotationItem->save();
                    }
                }
            }
        }
        return redirect('admin/quotations');
    }
    public function download_excel(Request $request)
    {
        try 
        {
            //$data = QuotationItem::query();
            $data = QuotationItem::join('quotations', 'quotation_items.quotation_id', '=', 'quotations.id')->join('products', 'quotation_items.itemCode', '=', 'products.productCode')->join('customers', 'quotations.CustomerCode', '=', 'customers.customer_code')->join('partners', 'quotations.Ref3', '=', 'partners.partner_code')->select('DocNo','status','DocDate','quotation_items.ItemCode','products.productName','products.brand','quotation_items.Qty','quotation_items.LineTotal','partners.name as partner_name','customers.customer_code','customers.name as customer_name');
            if (Auth::user()->hasRole('Admin')) {

                //$data->join('quotations', 'quotation_items.quotation_id', '=', 'quotations.id');

                //$data->join('products', 'quotation_items.itemCode', '=', 'products.productCode');

                //$data->join('customers', 'quotations.CustomerCode', '=', 'customers.customer_code');

                //$data->join('partners', 'quotations.Ref3', '=', 'partners.partner_code');

                //QuotationItem::with(['quotation','quotation.customer', 'quotation.referral1', 'quotation.referral2', 'quotation.referral3']);
                //print_r($data);exit;
            } else {
                $data->where(function ($query) {
                        $query->where('manager1', Auth::user()->id)
                            ->orWhere('manager2', Auth::user()->id)
                            ->orWhere('createdBy', Auth::user()->id);
                    });
            }
            if (!empty($request->from_date)) {
                //echo "here1";
                $data->where('quotations.DocDate', '>=', $request->from_date);
            }
            if (!empty($request->to_date)) {
                //echo "here2";
                $data->where('quotations.DocDate', '<=', $request->to_date);
            }
            if (!empty($request->customer)) {
                //echo "here";
                $data->where('quotations.CustomerCode', $request->customer);
            }
            if (!empty($request->user)) {
                //echo "here";
                $data->where('quotations.createdBy', $request->user);
            }
            if (!empty($request->status)) {
                if ($request->status == "All") {
                    // $request->status= 'Cancel';
                    // $data->where('quotations.status', '!=', $request->status);
                    $data->whereIn('quotations.status',$request->stsval);
                } else {
                    $data->where('quotations.status', $request->status);
                }
            } else {
                $data->where('quotations.status', '!=', 'Cancel');
            }
            //dd($data->toSql(), $data->getBindings()) ;
            $data->orderBy('DocDate',"desc");

            $file_name = 'quotations_'.time().'.xlsx';
            $allData = collect([]);
            $data->chunk(3000, function ($query) use ($allData) {
                $allData->push($query);
            });

            // Concatenate data from all chunks
            $concatenatedData = $allData->collapse();

            // Export concatenated data
            (new FastExcel($concatenatedData))->export(public_path('exports').'/'.$file_name);
            return response()->json(["url" => request()->getSchemeAndHttpHost()."/exports/".$file_name]);
        }
        catch (\Exception $e) {
            // If an exception is caught, handle it gracefully
            return $e;
        }
    }
}
