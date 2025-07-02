<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Invoice</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 20px;
      background: #f9f9f9;
      font-size: 14px;
      color: #333;
    }
    .container {
      max-width: 800px;
      margin: auto;
      background: #fff;
      border: 1px solid #ccc;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .header, .section {
      margin-bottom: 25px;
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
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
      vertical-align: top;
    }
    th {
      /* background: #f0f0f0; */
      font-weight: 600;
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
      margin-top: 40px;
    }

    th, td {
    border: 1px solid rgb(0, 0, 0);
  }

  </style>
</head>
<body style="margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;">
<div class="button-row" style="
    width: 100%;
    max-width: 720px;
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 15px;
">
<style>
 .print_button {
    /* margin-left: 3%; */
    margin-top: 20px;
    color: #fff;
    background-color: #6658dd;
    border-color: #6658dd;
    display: inline-block;
    font-weight: 400;
    line-height: 1.5;
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.45rem 0.9rem;
    font-size: 0.875rem;
    border-radius: 0.15rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    text-decoration: none;
}
.print-margin {
    margin-left: 81.5% !important;
}
</style>
    <a class="print_button btn btn-primary" style="margin-left: -10%;" href="{{ url('admin/sales-invoice/' . $data->id) }}">
        Back
    </a>

    <a class="print_button btn print-margin  btn-primary" href="{{ url('admin/invoice/share/' . $data->id) }}">
        Download PDF
    </a>

    <!-- Optional manual download button -->
    <!--
    <button class="print_button btn btn-success" onclick="downloadAsPDF()">
        Download PDF
    </button>
    -->

    <button class="print_button btn btn-primary" style="margin-right: -70px;" onclick="window.print()">
        Print
    </button>
</div>
  <div class="container DivIdToPrint" style="font-family: sans-serif;">
    <!-- Header -->
 <!-- <div class="header">
      <img src="{{ asset('assets/images/logo-light.png') }}" alt="Logo">
      <h1>Invoice</h1>
    </div>
    			<div class="hdname" style="    float: right;
    margin-top: 1px;
    font-size: smaller;
    font-weight: 700;">
			<p>MMDJ FOOD SUPPLIES LTD <br>
			59 Lily Road,Yardley <br>
			Birmingham  <span style="margin-left: 50px;">Tel: 07516 246 795</span><br>
			B26 1TE <span style="margin-left: 100px;">07565 464 101</span><br>
			e:mmdjfoodsupplies@gmail.com
			</p>
			</div>

    <div class="section">
      <p><strong>Invoice No:</strong> {{ $data->doc_num }}</p>
      <p><strong>Date:</strong> {{ date('d-m-Y', strtotime($data->doc_date)) }}</p>
    </div>


 -->








<!--  -->
<h1 style="width:98%; text-align:center; padding:1%; background:#FFF; margin-bottom: 23px; border:1px solid #000;
		margin-top: -23px; font-size:18px; margin-top:10px;"> Invoice</h1>


<table class="table table-borderless" style="margin-bottom: 13px;">
                        <tbody>

                            <tr class="content">
                                <td class="font-weight-bold" style="border:none; width:0px;">
                                  <div class="logo"><img src="{{ asset('assets/images/logo-light.png') }}" style="height: 81px;"></div>
                                </td>
<td class="font-weight-bold" style="border:none;">
<ul style="display:flex;">
  <li style="padding: 4px; display:block; max-width:180px;">{{ $cinfo->c_address }} <br> {{$cinfo->c_email}} <br> Tel: {{ $cinfo->c_phone }} <br>
    {{ $cinfo->c_phone1 }}</li>
  <!-- <li style="padding: 4px; display:block; padding-left:40px!important;">
    Tel: {{ $cinfo->c_phone }} <br>
    {{ $cinfo->c_phone1 }}
   
  </li> -->
</ul>
</td>




<td class="font-weight-bold" style="border:none;">
<p style="font-size:13px;">
         <b style="text-transform: uppercase;">Account Details</b> <br>
					MMDJ FOOD SUPPLIES LTD<br>
					NatWest<br>
					Account number:	49272306<br>
					Sort code:	60-01-27<br>
				</p>
</td>



                            </tr>
                        </tbody>
                    </table>









    <!-- Customer Details -->
    <!-- <div class="section">
      <h3>Customer Details</h3>
      @if($data->customer)
        <p>
          {{ $data->customer->name }}<br>
          {{ $data->customer->addressID }}<br>
          {{ $data->customer->phone }}<br>
          @if($data->customer->email){{ $data->customer->email }}<br>@endif
          @if($data->customer->gstin)GSTIN: {{ $data->customer->gstin }}<br>@endif
        </p>
      @endif
    </div> -->


<style>
  .detail-table th, .detail-table td {
    border: 1px solid #ffffff;
  }
  .table .add td {
    border-bottom: 1px solid #ffffff;
  }
  .table .content td {
padding-top:0px!important;
  }
    </style>

<table class="table" style="margin-bottom: 13px; border:1px solid #000!important;">
                        <tbody>
                            <tr class="add">
                                <td style="font-weight: 600;text-transform: uppercase;">Customer Details</td>
                                <!-- <td style="background: #f0f0f0; font-weight: 600;">Account Details</td> -->
                                <td style="font-weight: 600;text-transform: uppercase;">Executive Details</td>
                                <td style="font-weight: 600;text-transform: uppercase;">Invoice Details</td>
                            </tr>
                            <tr class="content">
                                <td class="font-weight-bold">{{ $data->customer->name }}<br>
          {{ $data->customer->addressID }}<br>
          {{ $data->customer->phone }}<br>
          @if($data->customer->email){{ $data->customer->email }}<br>@endif
          @if($data->customer->gstin)GSTIN: {{ $data->customer->gstin }}<br>@endif</td>
                                <!-- <td class="font-weight-bold">
                                  @if($data->customer)
         	MMDJ FOOD SUPPLIES LTD</br>
					NatWest</br>
					Account number:	49272306</br>
					Sort code:	60-01-27</br>
      @endif-->
                                </td> 
                        <td class="font-weight-bold">
                        @if($data->user)
                                  {{ $data->user->name }}<br>
                                  {{ $data->user->phone }}<br>
                                  @if($data->user->alt_phone){{ $data->user->alt_phone }}<br>@endif
                                  @if($data->user->email){{ $data->user->email }}<br>@endif
                              @endif
                        </td>

                        <td class="font-weight-bold">
                        @if($data->doc_num)
                                  Invoice No : {{ $data->doc_num }}<br>
                                  Date : {{ \Carbon\Carbon::parse($data->docdue_date)->format('d-m-Y') }}<br>
                                  
                              @endif
                        </td>



                            </tr>
                        </tbody>
                    </table>








    <!-- Executive Details -->
    <!-- <div class="section">
      <h3>Executive Details</h3>
      @if($data->user)
        <p>
          {{ $data->user->name }}<br>
          {{ $data->user->phone }}<br>
          @if($data->user->alt_phone){{ $data->user->alt_phone }}<br>@endif
          @if($data->user->email){{ $data->user->email }}<br>@endif
        </p>
      @endif
    </div> -->
    <!-- @if($data->e_status == 'Yes')
        <img src="{{ asset('assets/images/paid.png') }}" style="width:25%; position:absolute; top:105%; left:50%; transform: translate(-50%, -50%); opacity:.1;">
    @endif -->
    <!-- Items Table -->
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
        <td class="text-right" style="font-weight: bold; border-top: 1px solid #ccc;">@if($data->e_status == 'Yes') <span style=" color: red;">Edited Grand Total :</span>@else Grand Total : @endif </td>
        <td class="text-right" style="font-weight: bold; border-top: 1px solid #ccc;">{{ $cinfo->c_crncy_code }} {{ $data->total }}</td>
      </tr>
    </table>

     <!-- <div class="section">
      <h3>Account Details</h3>
      @if($data->customer)
        <p>
         	MMDJ FOOD SUPPLIES LTD</br>
					NatWest</br>
					Account number:	49272306</br>
					Sort code:	60-01-27</br>

        </p>
      @endif
    </div> -->
    @if($data->e_status == 'Yes' && $data->remarks!='')
    <!-- Edited reason -->
        <div class="section">
          <h3>Reason for Editing</h3>
          <p>{{ $data->remarks }}</p>
        </div>
    @endif    
    <!-- Terms & Conditions -->
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

  <!-- PDF Download Script -->
  <script>
    function downloadAsPDF() {
      const element = document.querySelector(".DivIdToPrint");
      const opt = {
        margin:       [0.5, 0.5, 0.5, 0.5],
        filename:     'invoice.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
        pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }
      };
      html2pdf().set(opt).from(element).save();
    }
  </script>

</body>
</html>
