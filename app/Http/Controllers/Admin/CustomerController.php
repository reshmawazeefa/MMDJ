<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Partner;
use App\Models\SalesOrderMaster;
use App\Models\PurchaseOrderMaster;
use App\Models\GoodsReturnMaster;
use App\Models\PurchaseInvoiceMaster;
use App\Models\PurchaseReturnMaster;
use App\Models\SalesInvoiceMaster;
use App\Models\SalesReturnMaster;
use App\Models\StockTransferRequest;
use App\Models\StockOutMaster;
use App\Models\StockInMaster;
use App\Models\IncomingPaymentMaster;
use App\Models\OutgoingPaymentMaster;
use App\Models\Quotation;
use App\Models\CustomQuotation;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    if ($request->ajax()) {
        $data = Customer::select('*')->orderBy('id','desc');

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $checked_status = $row->is_active == 1 ? 'Active' : 'Deactive';
                $button_class = $row->is_active == 1 ? 'btn-success' : 'btn-danger';
                $token = csrf_token();
            
                return '<button data-token="'.$token.'" data-id="'.$row->id.'" class="checkActive btn btn-sm '.$button_class.' toggleStatus" >
                            '.$checked_status.'
                        </button>';
            })
            
            
            ->addColumn('action', function ($row) {
                $url = url('admin/customers/'.$row->id);
                $url_edit = url('admin/customers/'.$row->id.'/edit');
                $delete_url = url('admin/customers/'.$row->id);
                $token = csrf_token();
            
                return '<a href='.$url.' class="edit btn btn-primary btn-sm">View</a>&nbsp;&nbsp;<a href="'.$url_edit.'" class="btn btn-info btn-sm">
                            <i class="mdi mdi-square-edit-outline"></i> Edit
                        </a>
                        &nbsp;&nbsp;
                        <form action="'.$delete_url.'" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this customer?\');">
                            '.csrf_field().'
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="mdi mdi-delete"></i> Delete
                            </button>
                        </form>';
            })
            
            ->rawColumns(['status', 'action']) // Ensure status column is processed as HTML
            ->make(true);
    }

    return view('admin.customers');
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_customer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {         
        $last = Customer::where('added_from', 'pos')->orderBy('id','desc')->first();
        $array = array();
        if($last)
        {
            $code = $last->customer_code;
            $array = explode('CU',$code);
        }
        if(count($array) > 1)
            $num = $array[1]+1;            
        else
            $num = 1;
        /*if(strlen($num) < 7)
                $num = str_pad($num, 7, '0', STR_PAD_LEFT);*/

        $checking = $request->sepBilling ? 'on': 'off';    
        
        $request->merge([
            'phone' => trim($request->phone),
            'alt_phone' => trim($request->alt_phone),
            'email' => strtolower(trim($request->email)),
        ]); 
        if($request->ajax())
        {
            $rules = [
                        'name' => 'max:50',
                        'phone' => 'required|numeric|digits_between:10,14|unique:customers,phone',
                        'alt_phone' => 'nullable|numeric|digits_between:10,14|unique:customers,alt_phone',
                        'email' => 'nullable|email|max:50|unique:customers,email',

                        'addressID' => 'max:45', 
                        'address' => 'max:50', 
                        'address2' => 'max:50', 
                        'place' => 'max:50',
                        'zip_code' => 'max:15', 
                        'state' => 'max:50', 
                        'country' => 'max:50',

                        'addressIDBilling' => 'max:45', 
                        'addressBilling' => 'max:50', 
                        'address2Billing' => 'max:50', 
                        'placeBilling' => 'max:50',
                        'zip_codeBilling' => 'max:15', 
                        'stateBilling' => 'max:50', 
                        'countryBilling' => 'max:50',

                        'gstin' => 'max:100'
                    ];

                    $messages = [
                        'phone.digits_between' => 'Phone number must be between 10 and 14 digits.',
                        'phone.numeric' => 'Phone number must contain only numbers.',
                        'phone.unique' => 'This phone number is already taken.',

                        'alt_phone.digits_between' => 'WhatsApp number must be between 10 and 14 digits.',
                        'alt_phone.numeric' => 'WhatsApp number must contain only numbers.',
                        'alt_phone.unique' => 'This WhatsApp number is already taken.',

                        'email.unique' => 'This email address is already registered.',
                    ];

                    $validator = Validator::make($request->all(), $rules, $messages);

                    if ($validator->fails()) {
                        if ($request->ajax()) {
                            return response()->json(['error' => $validator->errors()->all()], 422);
                        } else {
                            return redirect()->back()->withErrors($validator)->withInput();
                        }
                    }

        }
        else{        
           $rules = [
                    'name' => 'max:50',
                    'phone' => 'required|numeric|digits_between:10,14|unique:customers,phone',
                    'alt_phone' => 'nullable|numeric|digits_between:10,14|unique:customers,alt_phone',
                    'email' => 'nullable|email|max:50|unique:customers,email',

                    'addressID' => 'max:45', 
                    'address' => 'max:50', 
                    'address2' => 'max:50', 
                    'place' => 'max:50',
                    'zip_code' => 'max:15', 
                    'state' => 'max:50', 
                    'country' => 'max:50',

                    'addressIDBilling' => 'max:45', 
                    'addressBilling' => 'max:50', 
                    'address2Billing' => 'max:50', 
                    'placeBilling' => 'max:50',
                    'zip_codeBilling' => 'max:15', 
                    'stateBilling' => 'max:50', 
                    'countryBilling' => 'max:50',

                    'gstin' => 'max:100'
                ];

                $messages = [
                    'phone.digits_between' => 'Phone number must be between 10 and 14 digits.',
                    'phone.numeric' => 'Phone number must contain only numbers.',
                    'phone.unique' => 'This phone number is already taken.',

                    'alt_phone.digits_between' => 'WhatsApp number must be between 10 and 14 digits.',
                    'alt_phone.numeric' => 'WhatsApp number must contain only numbers.',
                    'alt_phone.unique' => 'This WhatsApp number is already taken.',

                    'email.unique' => 'This email address is already registered.',
                ];

                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    if ($request->ajax()) {
                        return response()->json(['error' => $validator->errors()->all()], 422);
                    } else {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                }
      
        }

        $Customer= new Customer();
        $Customer->name= $request->name;
        //$Customer->customer_code= $request->customer_code;
        $Customer->customer_code= 'CU'.$num;
        $Customer->phone= $request->phone;
        $cleanedCountryCode = preg_replace('/[^A-Za-z0-9]/', '', $request->country_code);
        $Customer->country_code = $cleanedCountryCode;
        $Customer->alt_phone= $request->alt_phone;
        $Customer->type= $request->type;
        $Customer->email= $request->email;            
        $Customer->same_checking= $checking;            
        $Customer->addressID= $request->prefix.' '.$request->addressID;            
        $Customer->address= $request->address;            
        $Customer->address2= $request->address2;  
        $Customer->place= $request->place;
        $Customer->zip_code= $request->zip_code;
        $Customer->state= $request->state;
        $Customer->country= $request->country;       
        $Customer->addressIDBilling= $request->prefixBilling.' '.$request->addressIDBilling;            
        $Customer->addressBilling= $request->addressBilling;            
        $Customer->address2Billing= $request->address2Billing;  
        $Customer->placeBilling= $request->placeBilling;
        $Customer->zip_codeBilling= $request->zip_codeBilling;
        $Customer->stateBilling= $request->stateBilling;
        $Customer->countryBilling= $request->countryBilling;
        $Customer->description= $request->description;
        $Customer->gstin = $request->gstin;
        $Customer->save();

        $url = 'http://178.33.58.18:5002/MG/Customer';

        $cust = array("CustomerCode" => $Customer->customer_code,
        "CustomerName" => $Customer->name,            
        "ContactNumber" => $Customer->phone,            
        "EMail" => $Customer->email,                
            "ContactNumber" => $Customer->phone,              
            "AltContactNumber" => $Customer->alt_phone,            
            "EMail" => $Customer->email,      
            "Place" => $Customer->place,  
            "AddressID" => $Customer->addressID,             
            "Address" => $Customer->address,                 
            "Address2" => $Customer->address2,                
            "ZipCode" => $Customer->zip_code,            
            "State" => $Customer->state,       
            "Country" => $Customer->country,    
            "AddressIDBilling" => $Customer->addressIDBilling,             
            "AddressBilling" => $Customer->addressBilling,                 
            "Address2Billing" => $Customer->address2Billing, 
            "PlaceBilling" => $Customer->placeBilling,                 
            "ZipCodeBilling" => $Customer->zip_codeBilling,            
            "StateBilling" => $Customer->stateBilling,       
            "CountryBilling" => $Customer->countryBilling,     
            "Description" => $Customer->description,            
            "GSTIN" => $Customer->gstin,
        );

        // Create a new cURL resource
        $ch = curl_init($url);

        // Setup request to send json via POST
        $payload = json_encode($cust);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
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

        $res = json_decode($result);

        curl_close($ch);

        if($request->ajax())
        {
            return response()->json(['success'=>'Added new records.']);
        }
        else
        {
            return redirect('admin/customers')->with('success','Customer added successfully');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('admin.customer_details', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('admin.edit_customer', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {

        //dd($request);

        $rules = [
                'name' => 'required|max:50',
                'phone' => 'required|numeric|digits_between:10,14|unique:customers,phone,' . $customer->id,
                'alt_phone' => 'nullable|numeric|digits_between:10,14|unique:customers,alt_phone,' . $customer->id,
                'email' => 'nullable|email|max:100|unique:customers,email,' . $customer->id,

                'addressID' => 'required|max:45',
                'address' => 'required|max:70',
                'address2' => 'required|max:70',
                'place' => 'max:255',
                'zip_code' => 'required|max:15',
                'state' => 'max:100',
                'country' => 'max:100',

                'addressIDBilling' => 'required|max:45',
                'addressBilling' => 'required|max:70',
                'address2Billing' => 'required|max:70',
                'placeBilling' => 'max:255',
                'zip_codeBilling' => 'required|max:15',
                'stateBilling' => 'max:100',

                'gstin' => 'max:100',
            ];

            $messages = [
                'phone.digits_between' => 'Contact number must be between 10 and 14 digits.',
                'phone.numeric' => 'Contact number must contain only numbers.',

                'alt_phone.digits_between' => 'WhatsApp number must be between 10 and 14 digits.',
                'alt_phone.numeric' => 'WhatsApp number must contain only numbers.',

                'phone.unique' => 'This contact number is already in use.',
                'alt_phone.unique' => 'This WhatsApp number is already in use.',
                'email.unique' => 'This email address is already in use.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                if ($request->ajax()) {
                    return response()->json(['error' => $validator->errors()->all()], 422);
                } else {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }

        

        //$validator->description = $request->description;
        $checking = $request->sepBilling ? 'on': 'off';        

        $Customer = Customer::where('id', $customer->id)->first();
        $Customer->name= $request->name;
        //$Customer->customer_code= $request->customer_code;
        $Customer->phone= $request->phone;
        $cleanedCountryCode = preg_replace('/[^A-Za-z0-9]/', '', $request->country_code);
        $Customer->country_code = $cleanedCountryCode;
        
        $Customer->alt_phone= $request->alt_phone;
        $Customer->type= $request->type;
        $Customer->email= $request->email;        
        $Customer->same_checking= $checking;            
        $Customer->addressID= $request->prefix.' '.$request->addressID;            
        $Customer->address= $request->address;            
        $Customer->address2= $request->address2; 
        $Customer->place= $request->place;
        $Customer->zip_code= $request->zip_code;
        $Customer->state= $request->state;
        $Customer->country= $request->country;
        $Customer->addressIDBilling= $request->prefixBilling.' '.$request->addressIDBilling;            
        $Customer->addressBilling= $request->addressBilling;            
        $Customer->address2Billing= $request->address2Billing;  
        $Customer->placeBilling= $request->placeBilling;
        $Customer->zip_codeBilling= $request->zip_codeBilling;
        $Customer->stateBilling= $request->stateBilling;
        $Customer->countryBilling= $request->countryBilling;
        $Customer->description= $request->description;
        $Customer->gstin = $request->gstin;
        $Customer->save();

        return redirect('admin/customers')->with('success','Customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($customer)
    {
        $customer = Customer::find($customer);


        if (!$customer) {
            return redirect()->route('customers.index')->with('error', 'Customer not found.');
        }
    
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function generateBarcodeNumber(Request $request) {
        $type = $request->type;

        if ($type == 'partner') 
        {
            $partner = Partner::orderBy('id','desc')->first();
            $array = array();
            if($partner)
            {
                $code = $partner->partner_code;
                $array = explode('PA',$code);
            }
            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;
            /*if(strlen($num) < 7)
                $num = str_pad($num, 7, '0', STR_PAD_LEFT);*/
            return 'PA'.$num;
        }
        elseif($type == 'customer')
        {
            $customer = Customer::where('added_from', 'pos')->orderBy('id','desc')->first();
            $array = array();
            if($customer)
            {
                $code = $customer->customer_code;
                $array = explode('CU',$code);
            }
            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;

            /*if(strlen($num) < 7)
                $num = str_pad($num, 7, '0', STR_PAD_LEFT);*/
            return 'CU'.$num;
        }
        elseif($type == 'salesorder')
        {
            $salesorder = SalesOrderMaster::orderBy('id','desc')->first();
            $array = array();
            if($salesorder)
            {
                $code = $salesorder->doc_num;
                $array = explode('SO',$code);
            }
            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;

            return 'SO'.$num;
        }
        elseif($type == 'salesinvoice')
        {
            $salesinvoice = SalesInvoiceMaster::orderBy('id','desc')->first();
            
            $array = array();
            if($salesinvoice)
            {
                $code = $salesinvoice->doc_num;
                $array = explode('SI',$code);
            }
            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;

            return 'SI'.$num;
        }
        elseif($type == 'salesreturn')
        {
            $salesreturn = SalesReturnMaster::orderBy('id','desc')->first();
            
            $array = array();
            if($salesreturn)
            {
                $code = $salesreturn->doc_num;
                $array = explode('TRKABH-RTN',$code);
            }
            // dd($array);
            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;

            return 'RTN'.$num;
        }
        elseif($type == 'stock-transfer-request')
        {
            $salestransfer = StockTransferRequest::orderBy('id','desc')->first();
            
            $array = array();
            if($salestransfer)
            {
                $code = $salestransfer->doc_number;
                $array = explode('WSJLB-STR',$code);
            }
            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;

            return 'STR'.$num;
        } 
        elseif($type == 'stock-out')
        {
            $salestransfer = StockOutMaster::orderBy('id','desc')->first();
            
            $array = array();
            if($salestransfer)
            {
                $code = $salestransfer->doc_number;
                $array = explode('WSJLB-SOT',$code);
            }
            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;

            return 'SOT'.$num;
        }
        elseif($type == 'stock-in')
        {
            $salestransfer = StockInMaster::orderBy('id','desc')->first();
            
            $array = array();
            if($salestransfer)
            {
                $code = $salestransfer->doc_number;
                $array = explode('WSJLB-SIN',$code);
            }
            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;

            return 'SIN'.$num;
        }
        elseif($type == 'purchaseorder')
        {
            $purchaseorder = PurchaseOrderMaster::orderBy('id','desc')->first();
            
            $array = array();
            if($purchaseorder)
            {
                $code = $purchaseorder->doc_num;
                $array = explode('WSJLB-PO',$code);
            }
            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;

            return 'PO'.$num;
        }
        elseif($type == 'goodsreturn')
        {
            $purchaseorder = GoodsReturnMaster::orderBy('id','desc')->first();
            
            $array = array();
            if($purchaseorder)
            {
                $code = $purchaseorder->doc_num;
                $array = explode('WSJLB-GRN',$code);
            }
            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;

            return 'GRN'.$num;
        }
        elseif($type == 'purchaseinvoice')
        {
            $purchaseorder = PurchaseInvoiceMaster::orderBy('id','desc')->first();
            
            $array = array();
            if($purchaseorder)
            {
                $code = $purchaseorder->doc_num;
                $array = explode('WSJLB-PI',$code);
            }
            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;

            return 'PI'.$num;
        }
        elseif($type == 'purchasereturn')
        {
            $purchasereturn = PurchaseReturnMaster::orderBy('id','desc')->first();
            
            $array = array();
            if($purchasereturn)
            {
                $code = $purchasereturn->doc_num;
                $array = explode('WSJLB-PR',$code);
            }
            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;

            return 'PR'.$num;
        }
        elseif($type == 'incomingpayment')
        {
            $incoming = IncomingPaymentMaster::orderBy('DocEntry','desc')->first();
            $array = array();
            if($incoming)
            {
                $code = $incoming->DocNum;
                $array = explode('WSJLB-IP',$code);
            }

            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;

            return 'IP'.$num;
        }
        elseif($type == 'outgoingpayment')

        {
            $outgoing = OutgoingPaymentMaster::orderBy('DocEntry','desc')->first();
            // dd($outgoing);
            $array = array();
            if($outgoing)
            {
                $code = $outgoing->DocNum;
                $array = explode('TRKFHL-OP',$code);
            }

            if(count($array) > 1)
                $num = $array[1]+1;            
            else
                $num = 1;

            return 'OP'.$num;
        }
        else
        {
            $lastQuotation = Quotation::orderBy('id','desc')->first();
            $arrayQuotation = array();
            if($lastQuotation)
            {                
                $codeQuotation = $lastQuotation->DocNo;
                $arrayQuotation = explode('-',$codeQuotation);
            }
            if(count($arrayQuotation) > 1)
                $numQuotation = $arrayQuotation[1]+1;            
            else
                $numQuotation = 1;

            $last = CustomQuotation::orderBy('id','desc')->first();
            $array = array();
            if($last)
            {                
                $code = $last->DocNo;
                $array = explode('-',$code);
            }
            if(count($array) > 1)
                $numCustom = $array[1]+1;            
            else
                $numCustom = 1;
            if($numQuotation > $numCustom)
                $num = $numQuotation;
            else
                $num = $numCustom;
            return $num;
        }
    }
    public function status(Request $request)
    {
        $id = $request->id;
        $Customer = Customer::find($id);
    
        if ($Customer) {
            $Customer->is_active = $request->is_active;
            $Customer->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'is_active' => $Customer->is_active
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Customer not found'
        ]);
    }
    

    public function get_supplier(Request $request)//get Customers
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            $data = Customer::select("*")->where('is_active',1)->where('type','S')
            ->where(function($query) use ($search){$query->where('name','LIKE',"%$search%")
            ->orWhere('phone','LIKE',"%$search%");
            })
            ->skip($offset)->take($resultCount)->get();

            $count = Customer::select("id","phone","name")
            ->where('is_active',1)->where('type','S')
            ->where(function($query) use ($search){$query->where('name','LIKE',"%$search%")
            ->orWhere('phone','LIKE',"%$search%");
            })->count();

        }
        else{
        /** get the users**/
        $data = Customer::select("*")->where('is_active',1)->where('type','S')->skip($offset)->take($resultCount)->get();

        $count =Customer::select("id","phone","name")->where('is_active',1)->where('type','S')->count();
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


        public function get_posupplier(Request $request)//get Customers
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
           $data = PurchaseOrderMaster::join('customers', 'purchase_order_masters.cid', '=', 'customers.customer_code')
            ->select('customers.customer_code', 'customers.name', 'customers.phone') 
            ->where('customers.is_active',1)
            ->where('customers.deleted_at',NULL)
            ->where('purchase_order_masters.branch', session('branch_code'))
            ->where('purchase_order_masters.obj_type', "Purchase Order")->groupBy('customers.customer_code', 'customers.name', 'customers.phone')
            ->where(function($query) use ($search){$query->where('customers.name','LIKE',"%$search%")
            ->orWhere('customers.phone','LIKE',"%$search%");
            })
            ->skip($offset)->take($resultCount);
            
            // Debug SQL before execution
            // dd($data->toSql(), $data->getBindings());
            // Only executed if you remove dd()
            $data = $data->get();

            $count = PurchaseOrderMaster::join('customers', 'purchase_order_masters.cid', '=', 'customers.customer_code')->select('customers.customer_code', 'customers.name', 'customers.phone')->where('customers.is_active',1)->where('customers.deleted_at',NULL)->where('purchase_order_masters.branch', session('branch_code'))->where('purchase_order_masters.obj_type', "Purchase Order")->groupBy('customers.customer_code', 'customers.name', 'customers.phone')
            ->where(function($query) use ($search){$query->where('customers.name','LIKE',"%$search%")
            ->orWhere('customers.phone','LIKE',"%$search%");
            })->count();

        }
        else
        {
            /** get the users**/
            $data = PurchaseOrderMaster::join('customers', 'purchase_order_masters.cid', '=', 'customers.customer_code')
            ->select('customers.customer_code', 'customers.name', 'customers.phone') // Select only customer fields
            ->where('customers.is_active', 1)
            ->whereNull('customers.deleted_at')
            ->where('purchase_order_masters.branch', session('branch_code'))
            ->where('purchase_order_masters.obj_type', "Purchase Order")
            ->groupBy('customers.customer_code', 'customers.name', 'customers.phone') // Group by selected fields
            ->skip($offset)
            ->take($resultCount);

            // Debug SQL before execution
            // dd($data->toSql(), $data->getBindings());

            // Only executed if you remove dd()
            $data = $data->get();

            $count = PurchaseOrderMaster::join('customers', 'purchase_order_masters.cid', '=', 'customers.customer_code')->select('customers.customer_code', 'customers.name', 'customers.phone')->where('customers.is_active',1)->where('customers.deleted_at',NULL)->where('purchase_order_masters.branch', session('branch_code'))->where('purchase_order_masters.obj_type', "Purchase Order")            ->groupBy('customers.customer_code', 'customers.name', 'customers.phone')->count();
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


            public function get_exsupplier(Request $request)//get Customers
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
           $data = PurchaseOrderMaster::join('customers', 'purchase_order_masters.cid', '=', 'customers.customer_code')
            ->select('customers.customer_code', 'customers.name', 'customers.phone') 
            ->where('customers.is_active',1)
            ->where('customers.deleted_at',NULL)
            ->where('purchase_order_masters.branch', session('branch_code'))
            ->where('purchase_order_masters.obj_type', "Other Expense")->groupBy('customers.customer_code', 'customers.name', 'customers.phone')
            ->where(function($query) use ($search){$query->where('customers.name','LIKE',"%$search%")
            ->orWhere('customers.phone','LIKE',"%$search%");
            })
            ->skip($offset)->take($resultCount);
            
            // Debug SQL before execution
            // dd($data->toSql(), $data->getBindings());
            // Only executed if you remove dd()
            $data = $data->get();

            $count = PurchaseOrderMaster::join('customers', 'purchase_order_masters.cid', '=', 'customers.customer_code')->select('customers.customer_code', 'customers.name', 'customers.phone')->where('customers.is_active',1)->where('customers.deleted_at',NULL)->where('purchase_order_masters.branch', session('branch_code'))->where('purchase_order_masters.obj_type', "Other Expense")->groupBy('customers.customer_code', 'customers.name', 'customers.phone')
            ->where(function($query) use ($search){$query->where('customers.name','LIKE',"%$search%")
            ->orWhere('customers.phone','LIKE',"%$search%");
            })->count();

        }
        else
        {
            /** get the users**/
            $data = PurchaseOrderMaster::join('customers', 'purchase_order_masters.cid', '=', 'customers.customer_code')
            ->select('customers.customer_code', 'customers.name', 'customers.phone') // Select only customer fields
            ->where('customers.is_active', 1)
            ->whereNull('customers.deleted_at')
            ->where('purchase_order_masters.branch', session('branch_code'))
            ->where('purchase_order_masters.obj_type', "Other Expense")
            ->groupBy('customers.customer_code', 'customers.name', 'customers.phone') // Group by selected fields
            ->skip($offset)
            ->take($resultCount);

            // Debug SQL before execution
            // dd($data->toSql(), $data->getBindings());

            // Only executed if you remove dd()
            $data = $data->get();

            $count = PurchaseOrderMaster::join('customers', 'purchase_order_masters.cid', '=', 'customers.customer_code')->select('customers.customer_code', 'customers.name', 'customers.phone')->where('customers.is_active',1)->where('customers.deleted_at',NULL)->where('purchase_order_masters.branch', session('branch_code'))->where('purchase_order_masters.obj_type', "Other Expense")            ->groupBy('customers.customer_code', 'customers.name', 'customers.phone')->count();
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
}
