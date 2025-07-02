<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesOrderMaster;
use App\Models\SalesOrderItem;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\User;
use Auth;
use Yajra\DataTables\DataTables;
use Rap2hpoutre\FastExcel\FastExcel;

class SalesOrderListController extends Controller
{
    public function approval_list(Request $request, $status = 'open')
    {
        //echo $status;
        if ($request->ajax()) {
            //echo "here";
            if (Auth::user()->hasRole('Admin')) {
                $data = SalesOrder::select('quotations.*')->with(array('customer', 'referral1', 'referral2', 'referral3'));
            } else {
                $data = SalesOrder::select('quotations.*')->with(array('customer', 'referral1', 'referral2', 'referral3'))
                    ->where(function ($query) {
                        $query->where('manager1', Auth::user()->id)
                            ->orWhere('manager2', Auth::user()->id);
                    });
            }

            if (!empty($request->from_date)) {
                //echo "here";
                $data->where('DocDate', '>=', $request->from_date);
            }
            if (!empty($request->to_date)) {
                //echo "here";
                $data->where('DocDate', '<=', $request->to_date);
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
                //echo "here";
                $data->where('quotations.status', $request->status);
            } else {
                $data->where('quotations.status', 'Open');
            }
            $data->orderBy('id', 'desc');
            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    $url = url('admin/quotations/' . $row->id);
                    $url_edit = url('admin/quotations/' . $row->id . '/edit');
                    $btn = '<a href=' . $url . ' class="btn btn-primary"><i class="mdi mdi-eye"></i>View</a>';
                    if ($row->status == 'Open' || 'Approve') {
                        $btn .= '&nbsp;<a href=' . $url_edit . ' class="btn btn-info"><i class="mdi mdi-square-edit-outline"></i>Edit</a>';
                    }
                    if ($row->status == 'Open') {
                        $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_approvemodal(' . $row->id . ')" class="btn btn-primary"><i class="mdi mdi-plus-circle me-1"></i>Approve</a>';
                    }
                    return $btn;
                })
                ->addColumn('customer', function ($row) {
                    if ($row->customer) {
                        $n = $row->customer->name;
                        return substr($n, 0, 27);
                    } else
                        return null;

                })
                ->addColumn('referral1', function ($row) {
                    if ($row->referral1)
                        return $row->referral1->name;
                    else
                        return null;

                })
                ->addColumn('referral2', function ($row) {
                    if ($row->referral2)
                        return $row->referral2->name;
                    else
                        return null;

                })
                ->addColumn('referral3', function ($row) {
                    if ($row->referral3)
                        return $row->referral3->name;
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

        return view('admin.approvals', compact('status'));
    }

    public function index(Request $request)
    {

// dd($request);
        if ($request->ajax()) {
            if (Auth::user()->hasRole('Admin')) {
                $data = SalesOrderMaster::select('sales_order_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3','user'));
            } else {
                $data = SalesOrderMaster::select('sales_order_masters.*')->with(array('customer', 'referral1', 'referral2', 'referral3','user'))
                    ->where(function ($query) {
                        $query->Where('createdBy', Auth::user()->id);
                    });
            }
            if (!empty($request->from_date)) {
                //echo "here";
                $data->where('delivery_date', '>=', $request->from_date);
            }
            if (!empty($request->to_date)) {
                //echo "here";
                $data->where('delivery_date', '<=', $request->to_date);
            }
            if (!empty($request->customer)) {
                //echo "here";
                $data->where('sales_order_masters.cid', $request->customer);
            }
            if (!empty($request->sodoc_num)) {
                //echo "here";
                $data->where('sales_order_masters.id', '=', $request->sodoc_num);
            }
            if (!empty($request->user)) {
                //echo "here";
                $data->where('sales_order_masters.sales_emp_id', $request->user);
            }
            if (!empty($request->status)) {
                if ($request->status == "All") {
                    $data->where('sales_order_masters.status', '!=', 'Cancel');
                } else {
                    $data->where('sales_order_masters.status', $request->status);
                }
            } else {
                $data->where('sales_order_masters.status', 'Open');
            }

                $data->where('sales_order_masters.branch', session('branch_code'));

                $data->orderBy('id', 'desc');
//                 dd(
//     $data->toSql(),
//     $data->getBindings()
// );
                // dd($data);

                // dd($data);
                return Datatables::of($data)
                ->addColumn('DocNo', function ($row) {
                    if ($row->doc_num)
                        return $row->doc_num;
                    else
                        return null;

                })
                ->addColumn('action', function ($row) {
                    $url = url('admin/sales-order/' . $row->id);
                    $url_edit = url('admin/sales-order/' . $row->id . '/edit');
                    $url_invoice = url('admin/salesinvoice');
                    $btn = '<a href=' . $url . ' class="btn btn-primary"><i class="mdi mdi-eye"></i>View</a>';
                        /*
                        <a href="javascript:void(0);" onclick="open_closemodal('.$row->id.')" class="btn btn-danger close-icon"><i class="mdi mdi-delete"></i>Close</a>
                        */
                    // if ((($row->status == 'Approve' || $row->status == 'Open') && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) || $row->status == 'Send for Approval')
                    if ($row->status == 'Open') {
                        $btn .= '&nbsp;<a href=' . $url_edit . ' class="btn btn-info"><i class="mdi mdi-square-edit-outline"></i>Edit</a>&nbsp;';
                         $btn .= '&nbsp;<a href=' . $url_invoice . ' class="btn btn-primary"><i class="mdi mdi-file-cog-outline"></i>Generate Invoice</a>&nbsp;';
                    }

                    if ($row->status == 'Approve' && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) {
                        $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_approvemodal(' . $row->id . ')" class="btn btn-primary"><i class="mdi mdi-plus-circle me-1"></i>Confirm</a>';
                    }

                    // if (($row->status == 'Open' || $row->status == 'Send for Approval') && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) {

                        if ($row->status == 'Open') {
                        $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_closemodal(' . $row->id . ')" class="btn btn-danger close-icon"><i class="mdi mdi-delete"></i>Delete</a>';
                    }
                    return $btn;
                })
                ->addColumn('customer', function ($row) {
                    if ($row->customer) {
                        $n = $row->customer->name;
                        return substr($n, 0, 27);
                    } else
                        return null;
                })
                ->addColumn('doc_date', function ($row) {
                    if ($row->cid)
                        return \Carbon\Carbon::parse($row->doc_date)->format('d-m-Y');
                    else
                        return null;

                })
                ->addColumn('delivery_date', function ($row) {
                    if ($row->cid)
                        return \Carbon\Carbon::parse($row->delivery_date)->format('d-m-Y');
                    else
                        return null;
                })
                ->addColumn('sales_emp_id', function ($row) {
                    if ($row->user)
                    return $row->user->name;
                    else
                    return null;

                })
                ->addColumn('PriceList', function ($row) {
                    if ($row->total)
                        return $row->total;
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

        return view('admin.salesorders');
    }

    public function show($id)
    {
        $details = SalesOrderMaster::select('sales_order_masters.*')->with(array('Item_details.products.stock.warehouse', 'customer', 'referral1', 'referral2','user'))->find($id); //print_r($details);
          //dd($details);
        return view('admin.salesorder_details', compact('details'));
    }

    public function close(Request $request, $id)
    {
        $salesorder = SalesOrderMaster::find($id);
        $data = '';
        if ($salesorder->status == 'Confirm') {
            $data = "Sales order is already confirmed!";
        } else {
            $salesorder->status = 'Cancel';
            $salesorder->cancelReason = $request->cancel_reason;
            $salesorder->save();
            $data = "Sales order is cancelled!";
        }
        echo json_encode($data);
    }

    public function confirm(Request $request, $id)
    {
        $quotation = SalesOrder::with('Items')->find($id);
        $data = '';
        if ($quotation->status == 'Confirm') {
            $data = "Quotation is already confirmed!";
        } elseif ($quotation->status == 'Approve') {
            $customer = Customer::where('customer_code', $quotation->CustomerCode)->first();
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
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //exit;

            // Execute the POST request
            $result = curl_exec($ch); //exit;

            $res = json_decode($result);
            if ($res) {
                if ($res->status == "Success") {
                    $quot = SalesOrder::find($id);
                    $quot->status = 'Confirm';
                    $quot->save();
                    $data = "Quotation confirmed successfully!";
                } else {
                    $data = "Something went wrong. Please try later!";
                }
            } else {
                $data = "Something went wrong. Please try later!";
            }
            // Close cURL resource
            curl_close($ch);
        } else {
            $data = "Please approve the quotation before cofirming!";
        }
        if ($request->ajax()) {
            echo json_encode($data);
        } else {
            return redirect('admin/quotations/' . $id)->with('success', $data);
        }

    }

    public function approve(Request $request, $id)
    {
        $error = '';
        $quot = SalesOrder::find($id);
        $data = '';
        if ($quot->status == 'Cancel') {
            $data = "Quotation is already cancelled!";
        } elseif ($quot->status == 'Approve') {
            $data = "Quotation is already approved!";
        } elseif ($quot->status != 'Approve') {
            $quot->status = 'Approve';
            $quot->approvedBy = Auth::user()->id;
            $quot->save();
            $data = "Quotation is approved successfully!";
            $error = 0;
        } else {
            $data = "Please check Quotation status!";
        }
        if ($request->ajax()) {
            echo json_encode($data);
        } else {
            return redirect('admin/quotations/' . $id)->with('success', $data);
        }
    }

    public function send_for_approval(Request $request, $id)
    {
        $quot = SalesOrder::find($id);
        $quot->status = 'Open';
        $quot->save();
        return redirect('admin/quotations/' . $id)->with('success', "Quotation is ready for approval");

    }

    public function download_excel(Request $request)
    {
        // dd($request);
        try 
        {
            // dd(Auth::user()->id);
            //$data = QuotationItem::query();
            $data = SalesOrderItem::join('sales_order_masters', 'sales_order_items.sm_id', '=', 'sales_order_masters.id')
            ->join('products', 'sales_order_items.item_id', '=', 'products.productCode')
            ->join('customers', 'sales_order_masters.cid', '=', 'customers.customer_code')
            ->join('partners', 'sales_order_masters.sales_emp_id', '=', 'partners.partner_code')
            ->select('sales_order_masters.doc_num',
            'sales_order_masters.status',
            'sales_order_masters.doc_date',
            'sales_order_items.item_id',
            'products.productName',
            'products.brand',
            'sales_order_items.qty',
            'sales_order_items.line_total',
            'partners.name as partner_name',
            'customers.customer_code',
            'customers.name as customer_name');
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
                $data->where('sales_order_masters.delivery_date', '>=', $request->from_date);
            }
            if (!empty($request->to_date)) {
                //echo "here2";
                $data->where('sales_order_masters.delivery_date', '<=', $request->to_date);
            }
            if (!empty($request->customer)) {
                //echo "here";
                $data->where('sales_order_masters.cid', $request->customer);
            }
            if (!empty($request->user)) {
                //echo "here";
                $data->where('sales_order_masters.sales_emp_id', $request->user);
            }
            if (!empty($request->status)) {
                if ($request->status == "All") {
                    // $request->status= 'Cancel';
                    // $data->where('quotations.status', '!=', $request->status);
                    //$data->whereIn('sales_order_masters.status','Open');
                    $data->whereIn('sales_order_masters.status',$request->stsval);
                } else {
                    $data->where('sales_order_masters.status', $request->status);
                }
            } else {
                $data->where('sales_order_masters.status', '!=', 'Cancel');
            }
            //dd($data->toSql(), $data->getBindings()) ;
            $data->where('sales_order_masters.branch', session('branch_code'));
            $data->orderBy('doc_date',"desc");
            //dd($data);
            $file_name = 'sales_order_'.time().'.xlsx';
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

           function get_sodoc(Request $request)
    {
        $data = [];
        $page = $request->page;
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;
        /** search the users by name,phone and email**/
        
        if ($request->has('q') && $request->q!= '') {
            $search = $request->q;
            // ->where('id',auth()->user()->id)
            $data = SalesOrderMaster::select("*")
            ->where(function ($query) use ($search) {
                $query->where('doc_num','LIKE',"%$search%");
            })->skip($offset)->take($resultCount)->get();
        // ->where('id',auth()->user()->id)
            $count = SalesOrderMaster::select("id","doc_num")
            ->where(function ($query) use ($search) {
                $query->where('doc_num','LIKE',"%$search%");
            })->count();
        
        }
        else{
        /** get the users**/
        // $data = User::select("*")->where('id',auth()->user()->id)->skip($offset)->take($resultCount)->get();
        $data = SalesOrderMaster::select("*")->skip($offset)->take($resultCount)->get();
        
        $count =SalesOrderMaster::select("id","doc_num")->count();
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
