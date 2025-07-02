<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductPrice;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Warehouse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;



class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $data = Product::with(['price','stock', 'Itemwarehouse']);
            $data = DB::table('products')
            ->join('product_prices', 'products.productCode', '=', 'product_prices.productCode')
            ->join('product_stocks', 'products.productCode', '=', 'product_stocks.productCode') 
            ->join('warehouses', 'product_stocks.whsCode', '=', 'warehouses.whsCode') 
            ->select('products.*','product_stocks.whsCode as whsCode', 'warehouses.whsName as whsName', 'product_prices.unit as unit') 
            ->orderBy('productName', 'asc'); 

            //  dd($data->get());
            if (!empty($request->product)) {
                $data->where('products.productCode', $request->product);
            }
            if (!empty($request->unit)) {
                $data->where('product_prices.unit', 'LIKE', '%' . $request->unit . '%');
            }
            
            if(!empty($request->whscode)) {
                $data->where('product_stocks.whsCode', $request->whscode);
            }
            
            
           
            return Datatables::of($data)
            ->addColumn('unit', function ($row) {
                return $row->unit; 
            })
            ->addColumn('whsName', function ($row) {
                return $row->whsName; 
            })
            ->addColumn('image', function ($row){
                    if(!empty($row->image))
                        $image = asset('').'/assets/images/products/'.$row->image;
                    else
                        $image = $row->image;                    
                    return  '<img style="max-height:100px" src=" '.$image.' "/>';
                })
                ->addColumn('status', function ($row) {
                    $checked_status = $row->is_active == 'Y' ? 'Active' : 'Deactive';
                    $button_class = $row->is_active == 'Y' ? 'btn-success' : 'btn-danger';
                    $token = csrf_token();
                
                    return '<button data-token="'.$token.'" data-id="'.$row->id.'" class="checkActive  btn '.$button_class.' toggleStatus ms-1 btn-sm" >
                                '.$checked_status.'
                            </button>';
                })
                ->addColumn('action', function($row){
                    $token = csrf_token();
                    $url = url('admin/products/'.$row->id);
                    $edit_url = url('admin/products/'.$row->id.'/edit');
                    $delete_url = url('admin/products/close/'.$row->id);
                    $btn = '<a href='.$url.' class="edit btn btn-primary btn-sm">View</a>
                            <a href='.$edit_url.' class="edit btn btn-info ms-1 btn-sm">Edit</a>
                           <form action="'.$delete_url.'" method="POST" class="style-btn" onsubmit="return confirm(\'Are you sure you want to delete this Product?\');">
                            '.csrf_field().'
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger ms-1 btn-sm">
                                <i class="mdi mdi-delete"></i> Delete
                            </button>
                        </form>';

                        return $btn;
                })
                ->rawColumns(['action','image','status'])
                ->make(true);
        }
        return view('admin.products');
    }

    public function show($product)
    {
        $details = Product::with(['stock.Warehouse', 'price'])->find($product); //print_r($details);
        //dd($details);
        return view('admin.product_details', compact('details'));
    }

    public function create()
    {
        $month = date('m');
        $lastProduct = Product::latest('id')->first();

        if ($lastProduct) {
            $lastThreeDigits = substr($lastProduct->productCode, -3);
            $last3 = (int) $lastThreeDigits + 1;
            $prcode = 'IN' . $month . str_pad($last3, 3, '0', STR_PAD_LEFT);
        } else {
            $prcode = 'IN' . $month . '001';
        }
        $data = Warehouse::select("whsCode","whsName")->get();
        return view('admin.create_product', compact('prcode','data'));
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
            $data = Warehouse::whereHas('warehouse', function ($query) use ($search) {
                $query->where('whsName', 'LIKE', "%$search%")
                      ->orWhere('whsCode', 'LIKE', "%$search%");
            })
            ->skip($offset)
            ->take($resultCount)
            ->get();
        
        $count = Warehouse::whereHas('warehouse', function ($query) use ($search) {
                $query->where('whsName', 'LIKE', "%$search%")
                      ->orWhere('whsCode', 'LIKE', "%$search%");
            })
            ->count();
        

        }
        else{

        /** get the users**/
        $data = Warehouse::select("*")->skip($offset)->take($resultCount)->get($data);
        $count =Warehouse::select("whsCode","whsName")->count();
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

    public function get_categories(Request $request)//get Partners
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = Category::select("categoryCode","categoryName")
            ->orWhere('categoryName','LIKE',"%$search%")->skip($offset)->take($resultCount)->get();

            $count = Category::select("categoryCode","categoryName")
            ->orWhere('categoryName','LIKE',"%$search%")->count();

        }
        else{
        /** get the users**/
        $data = Category::with('products')->skip($offset)->take($resultCount)->get();

        $count =Category::select("categoryCode","categoryName")->count();
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

    public function get_subcategories(Request $request)//get Partners
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = CategoryAttribute::select("subCateg")
            ->orWhere('subCateg','LIKE',"%$search%")->groupBy("subCateg")->skip($offset)->take($resultCount)->get();

            $count = CategoryAttribute::select("subCateg")
            ->orWhere('subCateg','LIKE',"%$search%")->groupBy("subCateg")->count();

        }
        else{
        /** get the users**/
        $data = CategoryAttribute::select("subCateg")->groupBy("subCateg")->skip($offset)->take($resultCount)->get();

        $count =CategoryAttribute::select("subCateg")->groupBy("subCateg")->count();
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

    public function get_types(Request $request)//get Partners
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = CategoryAttribute::select("type")
            ->orWhere('type','LIKE',"%$search%")->groupBy("type")->skip($offset)->take($resultCount)->get();

            $count = CategoryAttribute::select("type")
            ->orWhere('type','LIKE',"%$search%")->groupBy("type")->count();

        }
        else{
        /** get the users**/
        $data = CategoryAttribute::select("type")->groupBy("type")->skip($offset)->take($resultCount)->get();

        $count =CategoryAttribute::select("type")->groupBy("type")->count();
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
    
    public function get_brands(Request $request)//get Partners
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = CategoryAttribute::select("brand")
            ->orWhere('brand','LIKE',"%$search%")->groupBy("brand")->skip($offset)->take($resultCount)->get();

            $count = CategoryAttribute::select("brand")
            ->orWhere('brand','LIKE',"%$search%")->groupBy("brand")->count();

        }
        else{
        /** get the users**/
        $data = CategoryAttribute::select("brand")->groupBy("brand")->skip($offset)->take($resultCount)->get();

        $count =CategoryAttribute::select("brand")->groupBy("brand")->count();
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

    public function get_sizes(Request $request)//get Partners
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = CategoryAttribute::select("size")
            ->orWhere('size','LIKE',"%$search%")->groupBy("size")->skip($offset)->take($resultCount)->get();

            $count = CategoryAttribute::select("size")
            ->orWhere('size','LIKE',"%$search%")->groupBy("size")->count();

        }
        else{
        /** get the users**/
        $data = CategoryAttribute::select("size")->groupBy("size")->skip($offset)->take($resultCount)->get();

        $count =CategoryAttribute::select("size")->groupBy("size")->count();
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

    public function get_colors(Request $request)//get Partners
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = CategoryAttribute::select("color")
            ->orWhere('color','LIKE',"%$search%")->groupBy("color")->skip($offset)->take($resultCount)->get();

            $count = CategoryAttribute::select("color")
            ->orWhere('color','LIKE',"%$search%")->groupBy("color")->count();

        }
        else{
        /** get the users**/
        $data = CategoryAttribute::select("color")->groupBy("color")->skip($offset)->take($resultCount)->get();

        $count =CategoryAttribute::select("color")->groupBy("color")->count();
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

    public function get_finish(Request $request)//get Partners
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = CategoryAttribute::select("finish")
            ->orWhere('finish','LIKE',"%$search%")->groupBy("finish")->skip($offset)->take($resultCount)->get();

            $count = CategoryAttribute::select("finish")
            ->orWhere('finish','LIKE',"%$search%")->groupBy("finish")->count();

        }
        else{
        /** get the users**/
        $data = CategoryAttribute::select("finish")->groupBy("finish")->skip($offset)->take($resultCount)->get();

        $count =CategoryAttribute::select("finish")->groupBy("finish")->count();
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
    
    
    public function insert(Request $request)
    {
                 //dd($request);
                // $lastProduct = Product::latest('id')->first();
                // dd($lastProduct->productCode);

                //$active = filter_var($request->activeToggle, FILTER_VALIDATE_BOOLEAN) ? "Y" : "N";

                $updateDate = $request->updated_date
                ? Carbon::createFromFormat('Y-m-d', $request->updated_date)
                    ->setTime(now()->hour, now()->minute, now()->second)
                    ->format('Y-m-d H:i:s')
                : now()->format('Y-m-d H:i:s');

                $request->validate([
                    'proname' => 'required|unique:products,productName|max:100',
                    'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'price' => 'required|numeric|min:0.01',
                ], [
                    'proname.required' => 'Product name is required.',
                    'proname.unique' => 'This product name already exists.',
                ]);
                
                
                
            
                $product = Product::firstOrNew(['productCode' => $request->procode]);

                if ($request->hasFile('image')) {
                    $image = $request->file('image'); // Get uploaded file
                    $imageName = time() . '_' . $request->procode . ".jpg";
                    $image->move(public_path('/assets/images/products'), $imageName);
                } else {
                    $imageName = 'default.jpg'; // Set a default image or handle missing image case
                }
                
                // Fill product details $request->open_qutn ? $request->open_qutn : 0;
                $product->fill([
                    'productName'   => $request->proname ? $request->proname : 0,
                    'barcode'       => $request->barcode ?? '',
                    'invUOM'        => $request->invuom ?? '',
                    'saleUOM'       => $request->saleuom ?? '',
                    'hsnCode'       => $request->hsn_code ?? '',
                    'taxRate'       => $request->tax_rate ?? 0, // Set default 0 if missing
                    'categoryCode'  => $request->category ?? '',
                    'subCateg'      => $request->subcategory ?? '',
                    'type'          => $request->type ?? '',
                    'brand'         => $request->brand ?? '',
                    'size'          => $request->size ?? '',
                    'color'         => $request->color ?? '',
                    'finish'        => $request->finish ?? '',
                    'thickness'     => $request->thickness ?? '',
                    'conv_Factor'   => $request->conv_factor ?? 0,
                    'sqft_Conv'     => $request->sqft_conv ?? 0,
                    'boxQty'        => $request->box_qty ?? 0,
                    'weight'        => $request->weight ?? 0,
                    'image'         => $imageName ,
                    'is_active'     => 'Y',
                    'updated_date'  => $updateDate,
                ]);

                $product->save();


                $ProductStock = ProductStock::where('whsCode', $request->warehouse)
                            ->where('productCode', $request->procode)
                            ->first();
        
                if (empty($ProductStock)) {
                    $ProductStock = new ProductStock;
                }
        
                $ProductStock->whsCode = $request->warehouse;
                $ProductStock->productCode = $request->procode ? $request->procode : 0;
                $ProductStock->onHand = $request->on_hand ? $request->on_hand : 0;
                $ProductStock->blockQty = $request->block_qty ? $request->block_qty : 0;
                $ProductStock->updated_date = $updateDate;
                $ProductStock->save();


                $ProductPrice = ProductPrice::where('productCode', $request->procode)
                    ->where('priceList', $request->price_list)
                    ->first();
    
                if (empty($ProductPrice)) {
                    $ProductPrice = new ProductPrice;
                }
    
                $ProductPrice->productCode = $request->procode ? $request->procode : 0;
                $ProductPrice->priceList = $request->price_list ?? 'Retail Price';
                $ProductPrice->unit = $request->unit ? $request->unit : 0;
                $ProductPrice->price = $request->price ? $request->price : 0;
                $ProductPrice->updated_date = $updateDate;
                $ProductPrice->save();
                // if ($request->ajax()) {
                 
                //     return response()->json(['success' => true, 'message' => 'Product added successfully!']);
                // }
                
                return redirect('admin/products')->with('success', 'Product added successfully.');


    }

    public function edit($id)
    {
        $details = Product::with(['stock', 'price'])->find($id);
        $data = Warehouse::select("whsCode","whsName")->get();
        // dd($details->stock->whsCode);    
        return view('admin.edit_product', compact('details','data'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        $active = filter_var($request->activeToggle, FILTER_VALIDATE_BOOLEAN) ? "Y" : "N";
    
        // Handle Updated Date
        $updateDate = $request->updated_date
            ? Carbon::createFromFormat('Y-m-d', $request->updated_date)->format('Y-m-d H:i:s')
            : now()->format('Y-m-d H:i:s');
    
            $request->validate([
                'proname' => 'required|max:100|unique:products,productName,' . $id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'price' => 'required|numeric|min:0.01',
            ], [
                'proname.required' => 'Product name is required.',
                'proname.unique' => 'This product name already exists.',
            ]);
            
            
        // Handle Product Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $request->procode . ".jpg";
            $image->move(public_path('/assets/images/products'), $imageName);
            $product->image = $imageName;
        }
    
        // Update Product Details
        $product->update([
            'productName'   => $request->proname ?? '',
            'barcode'       => $request->barcode ?? '',
            'invUOM'        => $request->invuom ?? '',
            'saleUOM'       => $request->saleuom ?? '',
            'hsnCode'       => $request->hsn_code ?? '',
            'taxRate'       => $request->tax_rate ?? 0,
            'categoryCode'  => $request->category ?? '',
            'subCateg'      => $request->subcategory ?? '',
            'type'          => $request->type ?? '',
            'brand'         => $request->brand ?? '',
            'size'          => $request->size ?? '',
            'color'         => $request->color ?? '',
            'finish'        => $request->finish ?? '',
            'thickness'     => $request->thickness ?? '',
            'conv_Factor'   => $request->conv_factor ?? 0,
            'sqft_Conv'     => $request->sqft_conv ?? 0,
            'boxQty'        => $request->box_qty ?? 0,
            'weight'        => $request->weight ?? 0,
            'is_active'     => $active,
            'updated_date'  => $updateDate,
        ]);

        ProductStock::where('productCode', $request->procode ?? 0)
            ->update([
                'whsCode'      => $request->warehouse ?? 0,
                'onHand'       => $request->on_hand ?? 0,
                'blockQty'     => $request->block_qty ?? 0,
                'updated_date' => $updateDate
            ]);


         ProductPrice::where('productCode', $request->procode ?? 0)
            ->update([
                'unit'         => $request->unit ?? 0,
                'price'        => $request->price ?? 0,
                'priceList'    => $request->price_list ?? 'Retail Price',
                'updated_date' => $updateDate
            ]);

    
        return redirect('admin/products')->with('success', 'Product updated successfully.');
    }
    

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->stock()->delete();
        $product->price()->delete();

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }
    
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    
    }
    


    public function upload_product_image(Request $request)
    {
        // dd($request);
        $product = Product::find($request->product_id); 
        $product->image = $imageName = time().'_'.$product->productCode.".jpg";
        $request->image->move(public_path('/assets/images/products'), $imageName);
        $product->save();
        // return redirect('admin/products/'.$request->product_id);
        return back()->with('success', 'Product updated successfully.');
    }

    public function get_product_details(Request $request)
    {
        $product = DB::table('product_prices as i')
            ->join('products', 'i.productCode', '=', 'products.productCode')
            ->where('i.productCode', $request->productCode)
            ->first();
    
        if ($product) {
            // Add the price_list as an additional property in the $product object
            $product->price_list = ProductPrice::where('productCode', $request->productCode)->first();
            $product->stock = ProductStock::where('productCode', $request->productCode)->first();
        }
    
        return response()->json($product); 
    }

    public function status(Request $request)
    {
        // dd($request);
        $id = $request->id;
        $product = Product::find($id);
    
        if ($product) {
            $product->is_active = $request->is_active;
            $product->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'is_active' => $product->is_active
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Product not found'
        ]);
    }
    
}
