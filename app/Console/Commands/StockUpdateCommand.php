<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\ProductStock;
// use App\Models\Category;

class StockUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stock list update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $cat = Category::find(203);
        // $cat->categoryCode = 124;
        // $cat->save();
        //$dateP = Product::orderBy('updated_date','desc')->first();

        $last_up = date('d/m/Y');//date('d/m/Y',strtotime($dateP->updated_date));

        $url = 'http://178.33.58.18:5002/MG/ProdStock';

        // Create a new cURL resource
        $ch = curl_init($url);
        $payload = '{"UpdateDate":"'.$last_up.'"}';
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        // Set the content type to application/json
        $headers = array(
            "Authorization: Bearer eyJhbGciOiJSUzI1NiIsImtpZCI6IjEzRjhFREM2QjJCNTU3OUQ0MEVGNDg1QkNBOUNFRDBBIiwidHlwIjoiYXQrand0In0.eyJuYmYiOjE2OTgwNDM3MDQsImV4cCI6MTcyOTU3OTcwNCwiaXNzIjoiaHR0cDovL2xvY2FsaG9zdDo1MDAwIiwiYXVkIjoiQ3VzdG9tZXJTZXJ2aWNlLkFwaSIsImNsaWVudF9pZCI6Im5hc19jbGllbnQiLCJzdWIiOiJkMWU0YjcyYi0zNmZkLTQ0YTItYTJkNy1iZmE4ODhiNGE4Y2QiLCJhdXRoX3RpbWUiOjE2OTgwNDM3MDMsImlkcCI6ImxvY2FsIiwic2VydmljZS51c2VyIjoiYWRtaW4iLCJqdGkiOiI3RTkwNTNGRjU3RUFDNzQ1QzZGMDY2N0IwMjQ4OTE4NCIsInNpZCI6IjFCRkIyRTYwNjkzRUE4OUMwQjVDQ0M2MkJDNEExMjIwIiwiaWF0IjoxNjk4MDQzNzA0LCJzY29wZSI6WyJvcGVuaWQiLCJwcm9maWxlIiwibmFzLmNsaWVudCIsIm5hcy5zZXJ2aWNlcyJdLCJhbXIiOlsicHdkIl19.c7luIjRCKOaDauPUOf8_2rBRn3oRczJkh0gN-CLrI3Gk83JQjZ8nuW1Cuzj6Y4nmc6n8_LvKFvqm9vj0Os-IdhAUGjyIaUQkNe64npARCm6qloUY8KBWBqWj3-sSVGkeR395zmBTAz4ppVqxjR2Symy-9C061kKzF13NCWWFrbwwfmFEubejgEVxoD9KE-_38KMruhLDTfE1MxFRuMnoqPF2LuPxTBruJp57zYdgxCmLdn47GvRXdumXzxiRD6XqPByyT95FwCZzuoN_Cfk_W3ZGKVi6ivBmzP2Ktb_gJoUCN4uayXACDGjoc3FaokDCwmrfE6rYXb_L24gnTVzR3g",
            "Content-Type: application/json",
         );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the POST request
        $result = curl_exec($ch);

        // Close cURL resource
        curl_close($ch);
        $stocks = json_decode($result);
        if(count($stocks) > 0)
        {
            //ProductStock::truncate();
            foreach ($stocks as $key => $value) 
            {
                $ProductStock = ProductStock::where('whsCode',$value->whsCode)->where('productCode',$value->productCode)->first();
                if(empty($ProductStock))
                {
                    $ProductStock = new ProductStock;
                }
                
                $ProductStock->whsCode = $value->whsCode;
                $ProductStock->productCode = $value->productCode;
                $ProductStock->onHand = $value->onHand;
                $ProductStock->blockQty = $value->blockQty;
                $ProductStock->updated_date = date("Y-m-d", strtotime(str_replace('/', '-', $value->updateDate)));
                $ProductStock->save();
            }
        }

    }
}
