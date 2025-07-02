<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Partner;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductPrice;
use App\Models\CustomQuotation;
use App\Models\Quotation;
use App\Models\CustomQuotationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CustomQuotationController extends Controller
{
    public function approval_list(Request $request, $status='open')
    {
        //echo $status; exit;
        if ($request->ajax()) {
            //echo "here";
            if(Auth::user()->hasRole('Admin'))
            {
                $data = CustomQuotation::select('custom_quotations.*')->with(array('customer','referral1','referral2','referral3'));
            }
            else
            {
                $data = CustomQuotation::select('custom_quotations.*')->with(array('customer','referral1','referral2','referral3'))
                ->where(function ($query) {
                    $query->where('manager1',Auth::user()->id)
                          ->orWhere('manager2',Auth::user()->id);
                });
            }
            
            if(!empty($request->from_date))
            {
                //echo "here";
                $data->where('DocDate','>=', $request->from_date);
            }
            if(!empty($request->to_date))
            {
                //echo "here";
                $data->where('DocDate','<=', $request->to_date);
            }
            if(!empty($request->customer))
            {
                //echo "here";
                $data->where('custom_quotations.CustomerCode', $request->customer);
            }
            if(!empty($request->user))
            {
                //echo "here";
                $data->where('custom_quotations.createdBy', $request->user);
            }
            if(!empty($request->status))
            {
                //echo "here";
                $data->where('custom_quotations.status', $request->status);
            }
            else{
                $data->where('custom_quotations.status', 'Open');
            }
            $data->orderBy('id','desc');
            return Datatables::of($data)
                    ->addColumn('action', function($row){
                        $url = url('admin/custom_quotations/'.$row->id);
                        $url_edit = url('admin/custom_quotations/'.$row->id.'/edit');
                        $btn = '<a href='.$url.' class="btn btn-primary"><i class="mdi mdi-eye"></i>View</a>';
                        if($row->status == 'Open' || 'Approve')
                        {
                            $btn .= '&nbsp;<a href='.$url_edit.' class="btn btn-info"><i class="mdi mdi-square-edit-outline"></i>Edit</a>';
                        }
                        if($row->status == 'Open')
                        {
                            $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_approvemodal('.$row->id.')" class="btn btn-primary"><i class="mdi mdi-plus-circle me-1"></i>Approve</a>';
                        }
                        return $btn;
                    })
                    ->addColumn('customer', function ($row){
                        if($row->customer)
                        {
                            $n = $row->customer->name;
                            return substr($n, 0, 27);
                        }
                        else
                            return null;

                    })
                    ->addColumn('referral1', function ($row){
                        if($row->referral1)
                            return $row->referral1->name;
                        else
                            return null;

                    })
                    ->addColumn('referral2', function ($row){
                        if($row->referral2)
                            return $row->referral2->name;
                        else
                            return null;

                    })
                    ->addColumn('referral3', function ($row){
                        if($row->referral3)
                            return $row->referral3->name;
                        else
                            return null;

                    })
                    ->addColumn('status_show', function ($row){
                        $row->status_show = $row->status;
                        if($row->status == 'Cancel')
                            $row->status_show = 'Cancelled';
                        elseif($row->status == 'Approve')
                            $row->status_show = 'Approved';
                        elseif($row->status == 'Confirm')
                            $row->status_show = 'Confirmed';
                        return $row->status_show;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.custom_approvals',compact('status'));
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
        if(Auth::user()->hasRole('Admin'))
        {
            $data = CustomQuotation::select('custom_quotations.*')->with(array('customer','referral1','referral2','referral3'));
        }
        else
        {
            $data = CustomQuotation::select('custom_quotations.*')->with(array('customer','referral1','referral2','referral3'))
            ->where(function ($query) {
                $query->where('manager1',Auth::user()->id)
                ->orWhere('manager2',Auth::user()->id)
                ->orWhere('createdBy',Auth::user()->id);
            });
        }
        if(!empty($request->from_date))
        {
            //echo "here";
            $data->where('DocDate','>=', $request->from_date);
        }
        if(!empty($request->to_date))
        {
            //echo "here";
            $data->where('DocDate','<=', $request->to_date);
        }
        if(!empty($request->customer))
        {
            //echo "here";
            $data->where('custom_quotations.CustomerCode', $request->customer);
        }
        if(!empty($request->user))
        {
            //echo "here";
            $data->where('custom_quotations.createdBy', $request->user);
        }
        if(!empty($request->status))
        {
            //echo "here";
            $data->where('custom_quotations.status', $request->status);
        }
        else{
            $data->where('custom_quotations.status', 'Open');
        }
        $data->orderBy('id','desc');
        return Datatables::of($data)
                ->addColumn('action', function($row){
                    $url = url('admin/custom_quotations/'.$row->id);
                    $url_edit = url('admin/custom_quotations/'.$row->id.'/edit');
                    $btn = '<a href='.$url.' class="btn btn-primary"><i class="mdi mdi-eye"></i>View</a>';
                    /*
                        <a href="javascript:void(0);" onclick="open_closemodal('.$row->id.')" class="btn btn-danger close-icon"><i class="mdi mdi-delete"></i>Close</a>
                        */
                    if((($row->status == 'Approve' || $row->status == 'Open') && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) || $row->status == 'Send for Approval')
                    {
                        $btn  .= '&nbsp;<a href='.$url_edit.' class="btn btn-info"><i class="mdi mdi-square-edit-outline"></i>Edit</a>&nbsp;';
                    }

                    if($row->status == 'Approve' && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id))
                    {
                        $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_approvemodal('.$row->id.')" class="btn btn-primary"><i class="mdi mdi-plus-circle me-1"></i>Confirm</a>';
                    }
                    
                    if(($row->status == 'Open' || $row->status == 'Send for Approval') && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id))
                    {
                        $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_closemodal('.$row->id.')" class="btn btn-danger close-icon"><i class="mdi mdi-delete"></i>Close</a>';
                    } 
                    
   
                    return $btn;
                })
                ->addColumn('customer', function ($row){
                    if($row->customer)
                    {
                        $n = $row->customer->name;
                        return substr($n, 0, 27);
                    }
                    else
                        return null;

                })
                ->addColumn('DocDate', function ($row){
                    if($row->customer)
                        return date('d-m-Y',strtotime($row->DocDate));
                    else
                        return null;

                })
                ->addColumn('DueDate', function ($row){
                    if($row->customer)
                        return date('d-m-Y',strtotime($row->DueDate));
                    else
                        return null;

                })
                ->addColumn('referral1', function ($row){
                    if($row->referral1)
                        return $row->referral1->name;
                    else
                        return null;

                })
                ->addColumn('referral2', function ($row){
                    if($row->referral2)
                        return $row->referral2->name;
                    else
                        return null;

                })
                ->addColumn('referral3', function ($row){
                    if($row->referral3)
                        return $row->referral3->name;
                    else
                        return null;

                })
                ->addColumn('status_show', function ($row){
                    $row->status_show = $row->status;
                    if($row->status == 'Cancel')
                        $row->status_show = 'Cancelled';
                    elseif($row->status == 'Approve')
                        $row->status_show = 'Approved';
                    elseif($row->status == 'Confirm')
                        $row->status_show = 'Confirmed';
                    return $row->status_show;
                })
                ->rawColumns(['action'])
                ->make(true);
    }
        return view('admin.custom_quotations');
    }

    public function show($id)
    {
        $details = CustomQuotation::select('custom_quotations.*')->with(array('Items.products','customer','referral1','referral2'))->find($id); //print_r($details);
        return view('admin.custom_quotation_details', compact('details'));
    }

    public function create()
    {
        return view('admin.create_custom_quotation');
    }

    public function edit($id)
    {
        $details = CustomQuotation::select('custom_quotations.*')->with(array('Items.products.stock','customer','referral1','referral2','referral3'))->find($id); 
         //echo(json_encode($details));exit;
       
        return view('admin.edit_custom_quotation', compact('details'));
    }

    public function update(Request $request,$quotation_id)
    {
        $validator = $request->validate( ['customer' => 'required', 
            'product' => 'required|array|min:1', 
            'name' => 'required|array|min:1',
            'sqft' => 'required|array|min:1',
            'sqftprice' => 'required|array|min:1']);
        $quotation = CustomQuotation::find($quotation_id);
        $quotation->CustomerCode = $request->customer;
        $quotation->createdBy = Auth::user()->id;
        $quotation->manager1 = Auth::user()->approver1;
        $quotation->manager2 = Auth::user()->approver2;
        $quotation->Ref1 = $request->partner1;
        $quotation->Ref2 = $request->partner2;
        $quotation->Ref3 = $request->partner3;
        $quotation->DocDate = $request->date;
        $quotation->DueDate = $request->DueDate;
        $quotation->PriceList = $request->priceList;
        $quotation->VehType = $request->vehicle_type;
        $quotation->Distance = $request->km;
        $quotation->Remarks = $request->remarks;
        $quotation->DiscPrcnt = $request->discountPercent;
        $quotation->TaxAmount = $request->tax_amount;
        $quotation->FreightCharge = $request->FreightCharge;
        $quotation->LoadingCharge = $request->LoadingCharge;
        $quotation->UnloadingCharge = $request->UnloadingCharge;
        $quotation->save();
        $quotation_id = $quotation->id;
        $product = $request->product;   
        $name = $request->name;        
        $warehouses = $request->warehouse;        
        $quantity = $request->quantity;      
        $select_uom = $request->select_uom;      
        $disc_perct = $request->disc_perct; 
        $LineDiscPrice = $request->LineDiscPrice;
        $discount_type = $request->discount_type;
        $LineTotal = $request->LineTotal;    
        $grandTotal = $request->grand_total;
        $sqft = $request->sqft;
        $sqftprice = $request->sqftprice;
        $area = $request->area;
        $count = count($product); 
        $lineNo = 1; $grand_total = 0;  
        $line_ids = $request->line_id; 
        $p = CustomQuotationItem::whereNotIn('id', $line_ids)->where('custom_quotation_id',$quotation_id)->delete();
        for($i=0; $i<$count; $i++)
        {
            if(!empty($product[$i]) && !empty($name[$i]))
            {
                $quotationItem = CustomQuotationItem::where(array('custom_quotation_id'=>$quotation_id,'id'=>$line_ids[$i]))->first();                
                $item = Product::where('productCode',$product[$i])->first();
                if(empty($quotationItem))
                {
                    $quotationItem = new CustomQuotationItem;
                }
                $quotationItem->custom_quotation_id = $quotation_id;
                $quotationItem->ItemCode = $product[$i];
                $quotationItem->ItemName = $name[$i];
                $quotationItem->area = $area[$i];
                $quotationItem->DiscType = $discount_type[$i];
                if(!empty($item))
                {
                    $quotationItem->Qty = $quotationItem->SqftQty = $sqft[$i];
                    $quotationItem->SqmtQty = $sqft[$i] * 0.093;
                    $quotationItem->UnitPrice = $quotationItem->SqftPrice = round(($sqftprice[$i] * 100)/(100+$item->taxRate),2);
                    $quotationItem->UOM = $item->invUOM;
                    if(!empty($quotationItem->SqftPrice) && !empty($quotationItem->SqftQty))
                    {
                        if($discount_type[$i] == 'Percentage')
                        {                            
                            $quotationItem->LineDiscPrcnt = $disc_perct[$i];
                            $quotationItem->PerSqftDisc = round($quotationItem->SqftPrice*($disc_perct[$i]/100),2);  
                            $quotationItem->LineDiscPrice = round($LineDiscPrice[$i]*100/($item->taxRate+100),2);
                        }                           
                        
                        else
                        {
                            $quotationItem->PerSqftDisc = round($disc_perct[$i]*100/($item->taxRate+100),2);  
                            $quotationItem->LineDiscPrice = round($LineDiscPrice[$i]*100/($item->taxRate+100),2);                      
                        }
                        $quotationItem->PriceAfterDisc = round(($quotationItem->SqftPrice * $quotationItem->SqftQty) - $quotationItem->LineDiscPrice,2);

                        if($item->taxRate)
                            $taxRate = $quotationItem->TaxRate = $item->taxRate;
                        $quotationItem->TaxAmount = round($quotationItem->PriceAfterDisc * $item->taxRate/100,2);
                        $quotationItem->LineTotal = round($quotationItem->PriceAfterDisc,2);
                        $quotationItem->PriceAfterDisc = round($quotationItem->PriceAfterDisc/$quotationItem->SqftQty,2);
                        $quotationItem->LineNo = $lineNo;
                        $quotationItem->LineTotal = round($LineTotal[$i] * 100/($item->taxRate+100),2);
                        $grand_total = $grand_total + $quotationItem->LineTotal;
                        $quotationItem->save();
                        $lineNo++;
                    }
                }
            }
        }
        if(!empty($taxRate))
            $quotation->DiscAmount = round($request->discount_amount*100/($taxRate+100),2);        
        else
            $quotation->DiscAmount = round($request->discount_amount,2);
        /*if(!empty($grandTotal) && !empty($taxRate))
        {
            $quotation->DocTotal = round($grandTotal * 100/($taxRate+100),2);
        }
        else
        {*/
            $DocTotal = $grand_total+$quotation->FreightCharge+$quotation->LoadingCharge+$quotation->UnloadingCharge;
            $quotation->DocTotal = round($DocTotal,2);
        //}
        $quotation->save();
        return redirect('admin/custom_quotations/'.$quotation_id)->with('success','Quotation updated successfully');
    }    

    public function insert(Request $request)
    {
        $validator = $request->validate( ['customer' => 'required', 
            'product' => 'required|array|min:1', 
            'name' => 'required|array|min:1',
            'sqft' => 'required|array|min:1',
            'sqftprice' => 'required|array|min:1']);
        $quotation = new CustomQuotation;
        $quotation->CustomerCode = $request->customer;
        $quotation->createdBy = Auth::user()->id;
        $quotation->manager1 = Auth::user()->approver1;
        $quotation->manager2 = Auth::user()->approver2;
        $quotation->Ref1 = $request->partner1;
        $quotation->Ref2 = $request->partner2;
        $quotation->Ref3 = $request->partner3;
        $quotation->DocDate = $request->date;
        $quotation->DueDate = $request->DueDate;
        //$quotation->DocNo = date("Y").'-'.$request->docNumber;
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
        /*if(strlen($num) < 7)
            $num = str_pad($num, 7, '0', STR_PAD_LEFT);*/
        $quotation->DocNo = date("Y").'-'.$num;
        $quotation->PriceList = $request->priceList;
        $quotation->VehType = $request->vehicle_type;
        $quotation->Distance = $request->km;
        $quotation->Remarks = $request->remarks;
        $quotation->DiscPrcnt = $request->discountPercent;
        $quotation->TaxAmount = $request->tax_amount;
        $quotation->FreightCharge = $request->FreightCharge;
        $quotation->LoadingCharge = $request->LoadingCharge;
        $quotation->UnloadingCharge = $request->UnloadingCharge;
        $quotation->save();
        $quotation_id = $quotation->id;
        $product = $request->product;   
        $name = $request->name;        
        $warehouses = $request->warehouse;        
        $quantity = $request->quantity;      
        $select_uom = $request->select_uom;      
        $disc_perct = $request->disc_perct; 
        $LineDiscPrice = $request->LineDiscPrice;
        $discount_type = $request->discount_type;
        $LineTotal = $request->LineTotal;    
        $grandTotal = $request->grand_total;
        $sqft = $request->sqft;
        $sqftprice = $request->sqftprice;
        $area = $request->area;
        $count = count($product); 
        $lineNo = 1; $grand_total = 0;  
        for($i=0; $i<$count; $i++)
        {
            if(!empty($product[$i]) && !empty($name[$i]))
            {
                $quotationItem = new CustomQuotationItem;
                $quotationItem->custom_quotation_id = $quotation_id;
                $quotationItem->ItemCode = $product[$i];
                $quotationItem->ItemName = $name[$i];
                $quotationItem->area = $area[$i];
                $quotationItem->DiscType = $discount_type[$i];
                $item = Product::where('productCode',$product[$i])->first(); //print_r($item);
                if(!empty($item))
                {
                    $quotationItem->Qty = $quotationItem->SqftQty = $sqft[$i];
                    $quotationItem->SqmtQty = $sqft[$i] * 0.093;
                    $quotationItem->UnitPrice = $quotationItem->SqftPrice = round(($sqftprice[$i] * 100)/(100+$item->taxRate),2);
                    $quotationItem->UOM = $item->invUOM;
                    if(!empty($quotationItem->SqftPrice) && !empty($quotationItem->SqftQty))
                    {
                        if($discount_type[$i] == 'Percentage')
                        {                            
                            $quotationItem->LineDiscPrcnt = $disc_perct[$i];
                            $quotationItem->PerSqftDisc = round($quotationItem->SqftPrice*($disc_perct[$i]/100),2);  
                            $quotationItem->LineDiscPrice = round($LineDiscPrice[$i]*100/($item->taxRate+100),2);
                        }                           
                        
                        else
                        {
                            $quotationItem->PerSqftDisc = round($disc_perct[$i]*100/($item->taxRate+100),2);  
                            $quotationItem->LineDiscPrice = round($LineDiscPrice[$i]*100/($item->taxRate+100),2);                      
                        }
                        $quotationItem->PriceAfterDisc = round(($quotationItem->SqftPrice * $quotationItem->SqftQty) - $quotationItem->LineDiscPrice,2);

                        if($item->taxRate)
                            $taxRate = $quotationItem->TaxRate = $item->taxRate;
                        $quotationItem->TaxAmount = round($quotationItem->PriceAfterDisc * $item->taxRate/100,2);
                        $quotationItem->LineTotal = round($quotationItem->PriceAfterDisc,2);
                        $quotationItem->PriceAfterDisc = round($quotationItem->PriceAfterDisc/$quotationItem->SqftQty,2);
                        $quotationItem->LineNo = $lineNo;
                        $quotationItem->LineTotal = round($LineTotal[$i] * 100/($item->taxRate+100),2);
                        $grand_total = $grand_total + $quotationItem->LineTotal;
                        $quotationItem->save();
                        $lineNo++;
                    }
                }
            }
        }
        if(!empty($taxRate))
            $quotation->DiscAmount = round($request->discount_amount*100/($taxRate+100),2);        
        else
            $quotation->DiscAmount = round($request->discount_amount,2);
        /*if(!empty($grandTotal) && !empty($taxRate))
        {
            $quotation->DocTotal = round($grandTotal * 100/($taxRate+100),2);
        }
        else
        {*/
            $DocTotal = $grand_total+$quotation->FreightCharge+$quotation->LoadingCharge+$quotation->UnloadingCharge;
            $quotation->DocTotal = round($DocTotal,2);
        //}
        $quotation->save(); 
        return redirect('admin/custom_quotations/'.$quotation_id)->with('success','Quotation added successfully');
    }

    public function close(Request $request,$id)
    {
        $quotation = CustomQuotation::find($id); $data = '';
        if($quotation->status == 'Confirm')
        {
            $data = "Quotation is already confirmed!";
        }
        else
        { 
            $quotation->status = 'Cancel';
            $quotation->cancelReason = $request->cancel_reason;
            $quotation->save();
            $data = "Quotation is cancelled!";
        }
        echo json_encode($data);
    }

    public function confirm(Request $request,$id)
    {
        $quotation = CustomQuotation::with('Items')->find($id);
        //print_r(json_encode($quotation)); exit;
        $data = '';
        if($quotation->status == 'Confirm')
        {
            $data = "Quotation is already confirmed!";
        }
        elseif($quotation->status == 'Approve')
        {
            $customer = Customer::where('customer_code',$quotation->CustomerCode)->first();
            $quotation->CustomerName = $customer->name;
            //echo json_encode($quotation); exit;
            $url = 'http://178.33.58.18:5002/MG/Quotation';

            // Create a new cURL resource
            $ch = curl_init($url);

            // Setup request to send json via POST
            $payload = json_encode(array($quotation)); 
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
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//exit;

            // Execute the POST request
            $result = curl_exec($ch); //exit;

            $res = json_decode($result);
            if($res)
            {
                if($res->status =="Success")
                {
                    $quot = CustomQuotation::find($id);
                    $quot->status = 'Confirm';
                    $quot->save();
                    $data = "CustomQuotation confirmed successfully!";
                }
                else{
                    $data = "Something went wrong. Please try later!";
                }
            }
            else{
                $data = "Something went wrong. Please try later!";
            }
            // Close cURL resource
            curl_close($ch);
        }
        else
        {
            $data = "Please approve the quotation before cofirming!";
        }
        if ($request->ajax()) {  
            echo json_encode($data);
        }
        else{
            return redirect('admin/custom_quotations/'.$id)->with('success',$data);
        }
        
    }    

    public function approve(Request $request,$id)
    {  
        $error = '';    
        $quot = CustomQuotation::find($id); $data = '';
        if($quot->status == 'Cancel')
        {
            $data = "Quotation is already cancelled!";
        }
        elseif($quot->status == 'Approve')
        {
            $data = "Quotation is already approved!";
        }
        elseif($quot->status != 'Approve')
        {
            $quot->status = 'Approve';
            $quot->approvedBy = Auth::user()->id;
            $quot->save();
            $data = "Quotation is approved successfully!";
            $error = 0;
        }
        else
        {
            $data = "Please check Quotation status!";
        }
        if ($request->ajax()) {  
            echo json_encode($data);
        }
        else{
            return redirect('admin/custom_quotations/'.$id)->with('success',$data);
        }
    }    

    public function send_for_approval(Request $request,$id)
    {        
        $quot = CustomQuotation::find($id);
        $quot->status = 'Open';
        $quot->save();
        return redirect('admin/custom_quotations/'.$id)->with('success',"Quotation is ready for approval");
        
    }
}
