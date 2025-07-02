<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $company;
    public $pdfPath;

    public function __construct($data, $company, $pdfPath)
    {
        $this->data = $data;
        $this->company = $company;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Your Invoice from MMDJ')
                    ->markdown('emails.invoice')
                    ->attach($this->pdfPath, [
                        'as' => 'invoice.pdf',
                        'mime' => 'application/pdf',
                    ])
                    ->with([
                        'data' => $this->data,
                        'company' => $this->company,
                    ]);
    }
}
