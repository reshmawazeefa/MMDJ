<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\User;
use Auth;
use Rap2hpoutre\FastExcel\FastExcel;

class SalesReturnListController extends Controller
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
        if ($request->ajax()) {
            //echo "here";
            if (Auth::user()->hasRole('Admin')) {
                $data = SalesOrder::select('quotations.*')->with(array('customer', 'referral1', 'referral2', 'referral3'));
            } else {
                $data = SalesOrder::select('quotations.*')->with(array('customer', 'referral1', 'referral2', 'referral3'))
                    ->where(function ($query) {
                        $query->where('manager1', Auth::user()->id)
                            ->orWhere('manager2', Auth::user()->id)
                            ->orWhere('createdBy', Auth::user()->id);
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
                if ($request->status == "All") {
                    $data->where('quotations.status', '!=', 'Cancel');
                } else {
                    $data->where('quotations.status', $request->status);
                }
            } else {
                $data->where('quotations.status', 'Open');
            }
                $data->orderBy('id', 'desc');
                return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    $url = url('admin/quotations/' . $row->id);
                    $url_edit = url('admin/quotations/' . $row->id . '/edit');
                    $btn = '<a href=' . $url . ' class="btn btn-primary"><i class="mdi mdi-eye"></i>View</a>';
                        /*
                        <a href="javascript:void(0);" onclick="open_closemodal('.$row->id.')" class="btn btn-danger close-icon"><i class="mdi mdi-delete"></i>Close</a>
                        */
                    if ((($row->status == 'Approve' || $row->status == 'Open') && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) || $row->status == 'Send for Approval') {
                        $btn .= '&nbsp;<a href=' . $url_edit . ' class="btn btn-info"><i class="mdi mdi-square-edit-outline"></i>Edit</a>&nbsp;';
                    }

                    if ($row->status == 'Approve' && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) {
                        $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_approvemodal(' . $row->id . ')" class="btn btn-primary"><i class="mdi mdi-plus-circle me-1"></i>Confirm</a>';
                    }

                    if (($row->status == 'Open' || $row->status == 'Send for Approval') && (Auth::user()->hasRole('Admin') || $row->manager1 == Auth::user()->id || $row->manager2 == Auth::user()->id)) {
                        $btn .= '&nbsp;<a href="javascript:void(0);" onclick="open_closemodal(' . $row->id . ')" class="btn btn-danger close-icon"><i class="mdi mdi-delete"></i>Close</a>';
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
                ->addColumn('DocDate', function ($row) {
                    if ($row->customer)
                        return date('d-m-Y', strtotime($row->DocDate));
                    else
                        return null;

                })
                ->addColumn('DueDate', function ($row) {
                    if ($row->customer)
                        return date('d-m-Y', strtotime($row->DueDate));
                    else
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

        return view('admin.salesreturn');
    }

    public function show($id)
    {
        $details = SalesOrder::select('quotations.*')->with(array('Items.products.stock.warehouse', 'customer', 'referral1', 'referral2'))->find($id); //print_r($details);
        return view('admin.salesorder_details', compact('details'));
    }

    public function close(Request $request, $id)
    {
        $quotation = SalesOrder::find($id);
        $data = '';
        if ($quotation->status == 'Confirm') {
            $data = "Quotation is already confirmed!";
        } else {
            $quotation->status = 'Cancel';
            $quotation->cancelReason = $request->cancel_reason;
            $quotation->save();
            $data = "Quotation is cancelled!";
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
        try 
        {
            //$data = QuotationItem::query();
            $data = SalesOrderItem::join('quotations', 'quotation_items.quotation_id', '=', 'quotations.id')->join('products', 'quotation_items.itemCode', '=', 'products.productCode')->join('customers', 'quotations.CustomerCode', '=', 'customers.customer_code')->join('partners', 'quotations.Ref3', '=', 'partners.partner_code')->select('DocNo','status','DocDate','quotation_items.ItemCode','products.productName','products.brand','quotation_items.Qty','quotation_items.LineTotal','partners.name as partner_name','customers.customer_code','customers.name as customer_name');
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

        // (new FastExcel($res))->export($file_name, function ($val) {
        //     return [
        //         'DOC NO' => $val->DocNo,
        //         'STATUS' => $val->status,
        //         'DATE' => date('d-m-Y', strtotime($val->DocDate)),
        //         'ITEM CODE' => $val->ItemCode,
        //         'ITEM NAME' => $val->productName ? $val->productName:"",
        //         'ITEM QUANTITY' => $val->Qty,
        //         'BRAND' => $val->brand ? $val->brand:"",
        //         'AMOUNT' => $val->LineTotal,
        //         'SALES EXECUTIVE' => $val->partner_name ? $val->partner_name:"",
        //         'CUSTOMER CODE' => $val->customer_code ? $val->customer_code:"",
        //         'CUSTOMER NAME' => $val->customer_name ? $val->customer_name:"",
        //     ];
        // });
    }
}
