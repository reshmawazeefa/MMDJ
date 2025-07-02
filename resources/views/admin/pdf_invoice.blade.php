<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <style>
    /* Minimal margin and padding */
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background: #fff;
      font-size: 14px;
      color: #333;
    }

    .container {
      max-width: 770px; /* Slightly less than A4 width */
      margin: 5px auto;
      background: #fff;
      border: none;
      padding: 15px;
      box-shadow: none;
    }

    .header, .section {
      margin-bottom: 20px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header img {
      height: 60px;
    }

    .header h1 {
      margin: 0;
      font-size: 28px;
      color: #444;
    }

    h3 {
      border-bottom: 1px solid #000;
      padding-bottom: 6px;
      margin-bottom: 10px;
      font-size: 16px;
    }

    p, ul {
      margin: 5px 0;
      line-height: 1.5;
    }

    ul {
      padding-left: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }

    th, td {
      border: 1px solid #000;
      padding: 10px;
      text-align: left;
      vertical-align: top;
    }

    td.text-right {
      text-align: right;
    }

    .product-img {
      max-height: 60px;
      max-width: 80px;
      object-fit: contain;
    }

    .footer {
      text-align: center;
      font-size: 13px;
      color: #555;
      margin-top: 30px;
    }

    .table .add td {
      border-bottom: 1px solid #ffffff;
    }

    .table .content td {
      padding-top: 0px !important;
    }

    @media print {
      body {
        margin: 0;
      }
      .container {
        margin: 0;
        padding: 0;
      }
    }
  </style>
</head>
<body>

  <div class="container DivIdToPrint">
    <!-- Title -->
    <h1 style="width:98%; text-align:center; padding:1%; margin-bottom: 20px; border:1px solid #000; font-size:18px;">Invoice</h1>

    <!-- Header Table -->
    <table class="table table-borderless" style="margin-bottom: 13px;">
      <tbody>
        <tr class="content">
          <td style="border:none; width:0px;">
            <div class="logo"><img src="{{ asset('assets/images/logo-light.png') }}" style="height: 81px;"></div>
          </td>
          <td style="border:none;">
            <ul style="display:flex;">
              <li style="padding: 4px; display:block; max-width:180px;">
                {{ $cinfo->c_address }} <br>
                {{$cinfo->c_email}} <br>
                Tel: {{ $cinfo->c_phone }} <br>
                {{ $cinfo->c_phone1 }}
              </li>
            </ul>
          </td>
          <td style="border:none;">
            <p style="font-size:13px;">
              <b style="text-transform: uppercase;">Account Details</b> <br>
              MMDJ FOOD SUPPLIES LTD<br>
              NatWest<br>
              Account number: 49272306<br>
              Sort code: 60-01-27<br>
            </p>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Customer, Executive, Invoice Details -->
    <table class="table" style="margin-bottom: 13px; border:1px solid #000;">
      <tbody>
        <tr class="add">
          <td><b>Customer Details</b></td>
          <td><b>Executive Details</b></td>
          <td><b>Invoice Details</b></td>
        </tr>
        <tr class="content">
          <td>
            {{ $data->customer->name }}<br>
            {{ $data->customer->addressID }}<br>
            {{ $data->customer->phone }}<br>
            @if($data->customer->email){{ $data->customer->email }}<br>@endif
            @if($data->customer->gstin)GSTIN: {{ $data->customer->gstin }}<br>@endif
          </td>
          <td>
            @if($data->user)
              {{ $data->user->name }}<br>
              {{ $data->user->phone }}<br>
              @if($data->user->alt_phone){{ $data->user->alt_phone }}<br>@endif
              @if($data->user->email){{ $data->user->email }}<br>@endif
            @endif
          </td>
          <td>
            Invoice No: {{ $data->doc_num }}<br>
            Date: {{ \Carbon\Carbon::parse($data->docdue_date)->format('d-m-Y') }}
          </td>
        </tr>
      </tbody>
    </table>
      <p style="margin-top: 15px;">Dear Sir/Madam,<br>
        Thank you for choosing {{$cinfo->c_name}}. In response to your enquiry, we take pleasure in furnishing
        our lowest rate for your kind consideration.
      </p>
    <!-- Product Table -->
    <table class="section product-details">
      <thead>
        <tr>
          <th>No.</th>
          <th>Product</th>
          <th>Image</th>
          <th>Unit</th>
          <th class="text-right">Qty</th>
          <th class="text-right">Price</th>
          <th class="text-right">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data->Item_details as $key => $val)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $val->products->productName }}</td>
            <td>
              @if($val->products->image)
                <img src="{{ asset('assets/images/products/' . $val->products->image) }}" alt="Product" class="product-img">
              @endif
            </td>
            <td>{{ $val->unit }}</td>
            <td class="text-right">{{ $val->qty }}</td>
            <td class="text-right">{{ $cinfo->c_crncy_code }} {{ $val->disc_price }}</td>
            <td class="text-right">{{ $cinfo->c_crncy_code }} {{ $val->line_total }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <!-- Summary -->
    <table class="section amount-details">
      <tr><td class="text-right">MRP Total:</td><td class="text-right">{{ $cinfo->c_crncy_code }} {{ $data->total_bf_discount }}</td></tr>
      <tr><td class="text-right">Discount:</td><td class="text-right">{{ $cinfo->c_crncy_code }} {{ $data->discount_amount }}</td></tr>
      <tr><td class="text-right">Extra Expense:</td><td class="text-right">{{ $cinfo->c_crncy_code }} {{ $data->total_exp }}</td></tr>
      <tr><td class="text-right">Tax Amount:</td><td class="text-right">{{ $cinfo->c_crncy_code }} {{ $data->tax_amount }}</td></tr>
      @if($data->rounding)
        <tr><td class="text-right">Rounding:</td><td class="text-right">{{ $cinfo->c_crncy_code }} {{ $data->rounding }}</td></tr>
      @endif
      <tr>
        <td class="text-right" style="font-weight: bold;">Grand Total:</td>
        <td class="text-right" style="font-weight: bold;">{{ $cinfo->c_crncy_code }} {{ $data->total }}</td>
      </tr>
    </table>

    <!-- Terms -->
    <div class="section">
      <h3>Terms & Conditions</h3>
      <p><strong>Return & Replacement Policy:</strong> All grocery and perishable items must be checked upon delivery. Any discrepancies or damages must be reported immediately. Returns will only be accepted for non-perishable goods and only if reported within 24 hours.</p>
      <ul>
          <li>Validity of the quotation is up to {{ \Carbon\Carbon::parse($data->docdue_date)->format('d-m-Y') }}.</li>
          <li>100% advance payment is required. No credit facility is available.</li>
          <li>Delivery of items will be made within 2–3 working days from order confirmation, depending on stock availability.</li>
          <li>Freight and unloading charges are to be borne by the customer unless otherwise specified.</li>
          <li>Perishable goods once delivered cannot be returned or exchanged.</li>
          <li>Please verify the quantity and condition of items at the time of delivery.</li>
          <li>Temperature-sensitive items must be stored immediately upon receipt. Seller is not responsible for spoilage due to delayed storage.</li>
          <li>For bulk orders, a 2–3% variation in weight/quantity may occur due to packing and transit handling.</li>
          <li>Delivery must be acknowledged and signed by the customer or authorized personnel.</li>
          <li>All terms mentioned in the Proforma Invoice (PI) will apply.</li>
      </ul>
    </div>

    <!-- Footer -->
    <div class="footer">
      {{ $cinfo->c_address }} | Email: {{ $cinfo->c_email }} | Phone: {{ $cinfo->c_phone }}
    </div>
  </div>

  <!-- PDF Script -->
  <script>
    function downloadAsPDF() {
      const element = document.querySelector(".DivIdToPrint");
      const opt = {
        margin:       [0.1, 0.1, 0.1, 0.1],
        filename:     'invoice.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
        pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
      };
      html2pdf().set(opt).from(element).save();
    }

    // Optional: Auto-trigger PDF download on page load
    // window.onload = downloadAsPDF;
  </script>

</body>
</html>
