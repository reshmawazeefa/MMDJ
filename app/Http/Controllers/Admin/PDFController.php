<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\SalesInvoiceMaster;
use App\Models\SalesOrderMaster;
use App\Models\PurchaseInvoiceMaster;
use App\Models\PurchaseReturnMaster;
use App\Models\IncomingPaymentMaster;
use App\Models\CustomQuotation;
use Illuminate\Support\Facades\DB;
use PDF;

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        $pdf = \PDF::loadView('admin/graphs-pdf');
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('javascript-delay', 5000);
        $pdf->setOption('enable-smart-shrinking', true);
        $pdf->setOption('no-stop-slow-scripts', true);
        return $pdf->download('graph.pdf');
    }
    public function pdfview($id)
    {
        $data = Quotation::find($id);

        return view('admin.print_quotation',compact('data'));
    }

    public function invoicepdfview($id)
    {
        $data = SalesInvoiceMaster::find($id);
        //  dd($data);
        $cinfo = DB::table('company_infos')->first();
         return view('admin.print_invoice',compact('data', 'cinfo'));
        //return view('admin.pdf_invoice',compact('data', 'cinfo'));
    }

public function downloadAndSharePdf($id)
{


   $data = SalesInvoiceMaster::findOrFail($id);
    $cinfo = DB::table('company_infos')->first();

    $pdf = Pdf::loadView('admin.download_invoice', [
        'data' => $data,
        'cinfo' => $cinfo,
    ]);

    return $pdf->download('in_' . $data->doc_num . '.pdf');


    // Get invoice by ID
    // $data = SalesInvoiceMaster::findOrFail($id);

    // // Company info
    // $cinfo = DB::table('company_infos')->first();

    // // Generate PDF from the existing view
    //     $pdf = PDF::loadView('admin.download_invoice', [
    //         'data' => $data,
    //         'cinfo' => $cinfo,
    //     ])->setPaper('A4', 'portrait')->setOption('margin-top', 10)->setOption('margin-bottom', 10);


    // // Filename & save location
    // $filename = 'invoice_' . $id . '_' . time() . '.pdf';
    // $directory = public_path('invoices');

    // // Ensure 'invoices/' directory exists
    // if (!file_exists($directory)) {
    //     mkdir($directory, 0755, true);
    // }

    // $path = $directory . '/' . $filename;
    // $pdf->save($path); // Save PDF

    // // Publicly accessible URL
    // $publicUrl = url('invoices/' . $filename);

    // // Build WhatsApp message
    // $message = urlencode("Hi {$data->customer->name}, please check your invoice: $publicUrl");
    // $whatsAppUrl = "https://wa.me/?text=$message";

    // // Redirect to WhatsApp
    // return redirect($whatsAppUrl);
}



public function orderpdfview($id)
    {
        $data = SalesOrderMaster::find($id);
        //  dd($data);
        $cinfo = DB::table('company_infos')->first();
        return view('admin.print_order',compact('data', 'cinfo'));
        // return view('admin.download_invoice',compact('data', 'cinfo'));
    }

    public function purchaseinvoicepdfview($id)
    {
        $data = PurchaseInvoiceMaster::find($id);
        // dd($data);
        $cinfo = DB::table('company_infos')->first();
        return view('admin.print_purchase_invoice',compact('data', 'cinfo'));
    }

        public function purchasereturnpdfview($id)
    {
        $data = PurchaseReturnMaster::find($id);
        //  dd($data['Item_details']);
        $cinfo = DB::table('company_infos')->first();
        return view('admin.print_purchase_return',compact('data', 'cinfo'));
    }


    public function incomingpdfview($id)
    {
        $data = IncomingPaymentMaster::with('Item_details.salesInvoiceMaster')->find($id);
        // dd($data->Item_details);
        $cinfo = DB::table('company_infos')->first();
        return view('admin.print_incoming',compact('data','cinfo'));
    }
    public function custom_pdfview($id)
    {
        $data = CustomQuotation::find($id);

        return view('admin.print_custom_quotation',compact('data'));
    }
}
