<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Product;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Warehouse;
use App\Models\ProductStock;
use App\Models\ProductPrice;
use Redirect;
use Illuminate\Support\Facades\Log;

class CronController extends Controller
{

    public function product()
    {
        try {
            $last_up = date('d/m/Y');
            $url = 'http://178.33.58.18:5002/MG/ProductMaster';
            $token = env('API_BEARER_TOKEN');

            $headers = [
                "Authorization: Bearer " . $token,
                "Content-Type: application/json",
            ];

            $ch = curl_init($url);
            
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // Ensure GET request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);

            $result = curl_exec($ch);

            if ($result === false) {
                throw new \Exception('cURL error: ' . curl_error($ch));
            }

            curl_close($ch);

            if (!$result) {
                throw new \Exception('API response is empty.');
            }

            $products = json_decode($result);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('JSON decode error: ' . json_last_error_msg());
            }

            if (is_object($products)) {
                $products = [$products];
            }

            if (!is_array($products) || count($products) === 0) {
                return back()->with('info', 'No new products to update.');
            }

            foreach ($products as $value) {
                $updateDate = date("Y-m-d", strtotime(str_replace('/', '-', $value->updateDate)));

                $product = Product::firstOrNew(['productCode' => $value->productCode]);
                $product->fill([
                    'productName'   => $value->productName,
                    'barcode'       => $value->barcode,
                    'invUOM'        => $value->invUOM,
                    'saleUOM'       => $value->saleUOM,
                    'hsnCode'       => $value->hsnCode,
                    'taxRate'       => $value->taxRate,
                    'categoryCode'  => $value->categoryCode,
                    'subCateg'      => $value->subCateg,
                    'type'          => $value->type,
                    'brand'         => $value->brand,
                    'size'          => $value->size,
                    'color'         => $value->color,
                    'finish'        => $value->finish,
                    'thickness'     => $value->thickness,
                    'conv_Factor'   => $value->conv_Factor,
                    'sqft_Conv'     => $value->sqft_Conv,
                    'boxQty'        => $value->boxQty,
                    'weight'        => $value->weight,
                    'image'         => $value->imagePath,
                    'is_active'     => $value->active,
                    'updated_date'  => $updateDate,
                ]);
                $product->save();
            }

            return back()->with('success', 'Product master updated successfully.');

        } catch (\Exception $e) {
            Log::error('Product Import Error: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function category()
    {
        $url = 'http://178.33.58.18:5002/MG/Category?updateDate=""';

        // Create a new cURL resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $token = env('API_BEARER_TOKEN');
        // Set the content type to application/json
        $headers = array(
            "Authorization: Bearer ".$token,
            "Content-Type: application/json",
         );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the POST request
        echo $result = curl_exec($ch);

        if ($result === false) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        // Close cURL resource
        curl_close($ch);
        $categories = json_decode($result);
        foreach ($categories as $key => $value) 
        {
            $category = Category::where('categoryCode',$value->categoryCode)->first();
            if(empty($category))
            {
                $category = new Category;
            }
            $category->categoryCode = $value->categoryCode;
            $category->categoryName = $value->categoryName;

            $category->save();
        }
    }
    
    public function categoryAttribute()
    {
        $url = 'http://178.33.58.18:5002/MG/CategoryAttributes';

        // Create a new cURL resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $token = env('API_BEARER_TOKEN');

        // Set the content type to application/json
        $headers = array(
            "Authorization: Bearer ".$token,
            "Content-Type: application/json",
         );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the POST request
        echo $result = curl_exec($ch);

        if ($result === false) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        // Close cURL resource
        curl_close($ch);
        $categories = json_decode($result);
        foreach ($categories as $key => $value) 
        {
            $category = CategoryAttribute::where('categoryCode',$value->categoryCode)->where('subCateg',$value->subCateg)->first();
            if(empty($category))
            {
                $category = new CategoryAttribute;
            }
            $category->categoryCode = $value->categoryCode;
            $category->subCateg = $value->subCateg;
            $category->type = $value->type;
            $category->brand = $value->brand;
            $category->size = $value->size;
            $category->color = $value->color;
            $category->finish = $value->finish;
            $category->thickness = $value->thickness;
                
            $category->save();
        }
    }

    public function warehouse()
    {
        phpinfo();exit;
        $url = 'http://178.33.58.18:5002/MG/Warehouse?UpdateDate=""';

        // Create a new cURL resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $token = env('API_BEARER_TOKEN');
        // Set the content type to application/json
        $headers = array(
            "Authorization: Bearer ".$token,
            "Content-Type: application/json",
         );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the POST request
        echo $result = curl_exec($ch);

        if ($result === false) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }


        // Close cURL resource
        curl_close($ch);
        $Warehouses = json_decode($result);
        foreach ($Warehouses as $key => $value) 
        {
            $Warehouse = Warehouse::where('whsCode',$value->whsCode)->first();
            if(empty($Warehouse))
            {
                $Warehouse = new Warehouse;
            }
            
            $Warehouse->whsCode = $value->whsCode;
            $Warehouse->whsName = $value->whsName;
            $Warehouse->save();
        }
    }

    public function prodStock()
    {
        //$dateP = ProductStock::orderBy('updated_date','desc')->first();

        $last_up = date('d/m/Y');//date('d/m/Y',strtotime($dateP->updated_date));

        $url = 'http://178.33.58.18:5002/MG/ProdStock';

        // Create a new cURL resource
        $ch = curl_init($url);
        $payload = '{"UpdateDate":"'.$last_up.'"}';
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $token = env('API_BEARER_TOKEN');

        // Set the content type to application/json
        $headers = array(
            "Authorization: Bearer ".$token,
            "Content-Type: application/json",
         );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the POST request
        $result = curl_exec($ch);

        if ($result === false) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }


        // Close cURL resource
        curl_close($ch);
        if (!$result) {
            return Redirect::back()->with('error', 'Failed to fetch stock data.');
        }
        
        $stocks = json_decode($result);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return Redirect::back()->with('error', 'Invalid JSON response: ' . json_last_error_msg());
        }
        
        if (is_array($stocks) && count($stocks) > 0) {
            foreach ($stocks as $key => $value) {
                $ProductStock = ProductStock::where('whsCode', $value->whsCode)
                    ->where('productCode', $value->productCode)
                    ->first();
        
                if (empty($ProductStock)) {
                    $ProductStock = new ProductStock;
                }
        
                $ProductStock->whsCode = $value->whsCode;
                $ProductStock->productCode = $value->productCode;
                $ProductStock->onHand = $value->onHand;
                $ProductStock->blockQty = $value->blockQty;
                $ProductStock->updated_date = date("Y-m-d", strtotime(str_replace('/', '-', $value->updateDate)));
                $ProductStock->save();
            }
        } else {
            return Redirect::back()->with('error', 'No stock data available.');
        }
        
        return Redirect::back()->with('success', 'Stock updated successfully.');
    }

    public function prodPrice()
    {
        $last_up = date('d/m/Y');
        $url = 'http://178.33.58.18:5002/MG/ProdPrice';
    
        $ch = curl_init($url);
        $payload = '{"UpdateDate":"' . $last_up . '"}';
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $token = env('API_BEARER_TOKEN');

        $headers = [
            "Authorization: Bearer ".$token,
            "Content-Type: application/json",
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $result = curl_exec($ch);

        if ($result === false) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

    
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return Redirect::back()->with('error', "cURL Error: $error_msg");
        }
    
        curl_close($ch);
    
        $ProductPrices = json_decode($result);

    
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($ProductPrices)) {
            return Redirect::back()->with('error', 'Invalid response from API or no data found.');
        }
    
        if (count($ProductPrices) > 0) {
            foreach ($ProductPrices as $value) {
                $ProductPrice = ProductPrice::where('productCode', $value->productCode)
                    ->where('priceList', $value->priceList)
                    ->first();
    
                if (empty($ProductPrice)) {
                    $ProductPrice = new ProductPrice;
                }
    
                $ProductPrice->productCode = $value->productCode;
                $ProductPrice->priceList = $value->priceList;
                $ProductPrice->price = $value->price;
                $ProductPrice->updated_date = date("Y-m-d", strtotime(str_replace('/', '-', $value->updateDate)));
                $ProductPrice->save();
            }
        }
    
        return Redirect::back()->with('success', 'Price updated successfully');
    }
    
}
