@component('mail::message')
# Hello {{ $data->name }},

Thank you for your business. Please find your invoice attached for reference.

<!-- @component('mail::button', ['url' => asset('pdf/invoice_' . $data->id . '.pdf')])
View Invoice
@endcomponent -->

Thanks,<br>
MMDJ
@endcomponent
