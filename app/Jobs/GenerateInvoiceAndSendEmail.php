<?php
namespace App\Jobs;

use App\Models\SalesInvoiceMaster;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\InvoiceMail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateInvoiceAndSendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $salesinvoice_id;

    public function __construct($salesinvoice_id)
    {
        $this->salesinvoice_id = $salesinvoice_id;
    }

    public function handle()
    {
        $data = SalesInvoiceMaster::find($this->salesinvoice_id);
        $cinfo = DB::table('company_infos')->first();
        $customer = $data->customer; // or however you retrieve customer

        $html = view('admin.pdf_invoice', compact('data', 'cinfo'))->render();

        $pdf = Pdf::loadHTML($html)
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        $path = public_path('pdf/');
        $filename = 'invoice_' . $this->salesinvoice_id . '.pdf';

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        file_put_contents($path . $filename, $pdf->output());

        $pdfPath = $path . $filename;
        $customeremail = $customer->email ?? 'mmdjfoodsupplies@gmail.com';

        Mail::to($customeremail)->send(new InvoiceMail($customer, $cinfo, $pdfPath));
    }
}

