<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Http\Response;

class CustomerAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function customerAPI(Request $request)
    {
        // echo "ppppp".$bearerToken = $request->header('Authorization'); exit;
        // $validator = $request->validate( ['name' => 'required|max:50', 
        //     'customerCode' => 'required']);          
        
        // if ($validator->fails()) {
        //     return response()->json(['error'=>$validator->errors()->all()]);
        // }

        if($request->securityKey != "eyJhbGciOiJSUzI1NiIsImtpZCI6IjEzRj")
        {            
            $data = [
                'success' => false,
                'message' => "Authorization failed",
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }        

        if(empty($request->name) || empty($request->customerCode))
        {            
            $data = [
                'success' => false,
                'message' => "Name and customer code are mandatory fields",
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
        $Customer= new Customer();
        $Customer->name= $request->name;
        $Customer->customer_code= $request->customerCode;
        $Customer->phone= $request->phone;
        $Customer->alt_phone= $request->altPhone;
        $Customer->email= $request->email;            
        $Customer->addressID= $request->addressID;            
        $Customer->address= $request->address;            
        $Customer->address2= $request->address2;  
        $Customer->place= $request->place;
        $Customer->zip_code= $request->zipCode;
        $Customer->state= $request->state;
        $Customer->country= $request->country;       
        $Customer->addressIDBilling= $request->addressIDBilling;            
        $Customer->addressBilling= $request->addressBilling;            
        $Customer->address2Billing= $request->address2Billing;  
        $Customer->placeBilling= $request->placeBilling;
        $Customer->zip_codeBilling= $request->zipCodeBilling;
        $Customer->stateBilling= $request->stateBilling;
        $Customer->countryBilling= $request->countryBilling;
        $Customer->description= $request->description;
        $Customer->gstin = $request->GSTIN;
        $Customer->added_from = 'sap';
        $Customer->save();
        $data = [
            'success' => true,
            'message' => "Data added",
        ];
       return response()->json($data, Response::HTTP_OK);

    }
}

// name
// customerCode
// phone
// altPhone
// email
// addressID
// address
// address2
// place
// zipCode
// state
// country
// addressIDBilling
// addressBilling
// address2Billing
// placeBilling
// zipCodeBilling
// stateBilling
// countryBilling
// description
// GSTIN
