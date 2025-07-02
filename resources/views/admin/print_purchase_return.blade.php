<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="{{asset('assets/css/printin.css')}}" rel="stylesheet" type="text/css" />
</head>

<body style="margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;">

		<div class="button-row" 
		style="width: 100%;
        max-width: 720px;
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;">
			<a class="print_button btn btn-primary" href="{{url('admin/purchase-return/'.$data->id)}}">Back</a>
			<button class="print_button print-margin btn btn-primary" onclick="window.print()">Print</button>
		</div>



	<div class="DivIdToPrint">
	<div class="prninside">
      <!-- <div class="cmpnyhed">
      	<p>{{$cinfo->c_name}}</p>
      </div> -->
      <div class="main">
      	<div class="header">
      		<div class="logo"><img src="{{asset('assets/images/logo-light.png')}}"></div>
      		<div class="hdname">
      			<h1>Purchase Return</h1>
      		</div>
      	</div>

      	<div class="esti-dtls">
      		<div class="estidtls-hed">
      			<div class="estino">
      				<p>Purchase Return No:<span>{{$data->doc_num}}</span></p>
      			</div>
      			<div class="estidt">
      				<p>Date:<span>{{date('d-m-Y',strtotime($data->doc_date))}}</span></p>
      				<!-- <p>Quotation Validity:<span>{{date('d-m-Y',strtotime($data->DueDate))}}</span></p> -->
      			</div>
      		</div>
      		<div class="custdtls">
      			<label>Supplier Details</label>
				@if($data->customer)
      				<p>
      				{{$data->customer->name}}</br>
      				{{$data->customer->addressID}}</br>
      				{{$data->customer->phone}}</br>
      				@if($data->customer->email){{$data->customer->email}}</br>@endif
      				@if($data->customer->gstin)GSTIN : {{$data->customer->gstin}}</br>@endif</p>
      				@if($data->customer->address){{$data->customer->address}}</br>@endif
      				@if($data->customer->place){{$data->customer->place}},@endif
					@if($data->customer->state){{$data->customer->state}}@endif
				@endif
      		</div>
      		<div class="exedtls">
      			<label>Executive Details</label>
      			@if($data->user) 
				    <p>
					    {{$data->user->name}}</br>
						{{$data->user->phone}}</br>
						@if($data->user->alt_phone){{$data->user->alt_phone}},@endif
						@if($data->user->email){{$data->user->email}}</br>@endif
						@if($data->user->designation){{$data->user->designation}}</br>@endif
						@if($data->user->address){{$data->user->address}}@endif
					</p>
				@endif
      		</div>
      	</div>

      	<div class="cntnt">
      		<p>Dear Sir/Madam,<br>
				Thank you for choosing {{$cinfo->c_name}}. In response to your enquiry, we take pleasure in furnishing
				our lowest rate for your kind consideration. </p>
      	</div>
      	<!--  -->
      	<div class="estable">
      		<div class="table-hd">
      			<div class="table-th tone">No.</div>
      			<!-- <div class="table-th ttwo">Product</div> -->
				<!-- <div class="table-th ttwo">Image</div> -->
      			<div class="table-th tonefull">Remarks</div>
      			<div class="table-th tonefull">Total Amount</div>
      			<!-- <div class="table-th tthree">Unit Price</div>
      			<div class="table-th tthree">Total</div> -->
      			
      		</div>
      		<div class="table-bd">
			@php 
				$total_discount = $doc_total = 0;	
			@endphp
			@if(count($data->Item_details) > 0)
				@foreach ($data->Item_details as $key=>$val)
				
					
					<!-- $val->PerSqftDisc =	$val->PerSqftDisc * (100+$val->TaxRate)/100;

					if($val->products->sqft_Conv)
						$disc_per_no =  $val->PerSqftDisc * $val->products->sqft_Conv;
					
					else
						$disc_per_no =  $val->PerSqftDisc;

					$after_disc_no = $mrp_per_no - $disc_per_no;
					$after_disc_sqft = $mrp_per_sqft - $val->PerSqftDisc;			 -->
					<div class="table-tr">
						<div class="table-td tone">{{$key+1}}</div>
						
						<div class="table-td tonefull">{{$val->remarks}}</div>
						<div class="table-td tonefull">{{$val->line_total}}</div>
						<!-- <div class="table-td tthree">{{$cinfo->c_crncy_code}} {{$val->disc_price}}</div>
						<div class="table-td tthree">{{$cinfo->c_crncy_code}}  {{$val->line_total}}</div> -->
						

					</div>
				@endforeach
			@endif
			@php
				$total_amount = round($doc_total,2)+$data->FreightCharge+$data->UnloadingCharge+$data->LoadingCharge;
			@endphp
      		</div>
      		<div class="extra-ft">
      			<!-- <div class="table-tr">
	      			<div class="table-td tonefull"></div>
	      			<div class="table-td tsixseven mrptol">MRP Total</div>
	      			<div class="table-td tnine mrptolval">{{$cinfo->c_crncy_code}}  {{$data->total_bf_discount}}</div>
      			</div>
      			<div class="table-tr">
	      			<div class="table-td tonefull"></div>
	      			<div class="table-td tsixseven disctot">Discount</div>
	      			<div class="table-td tnine disctotval">{{$cinfo->c_crncy_code}}  {{$data->discount_amount}}</div>
      			</div>
      			<div class="table-tr">
	      			<div class="table-td tonefull"></div>
	      			<div class="table-td tsixseven subtot">Extra Expense</div>
	      			<div class="table-td tnine subtotval">{{$cinfo->c_crncy_code}}  {{$data->total_exp}}</div>
      			</div>
      			<div class="table-tr">
	      			<div class="table-td tonefull"></div>
	      			<div class="table-td tsixseven freight">Tax Amount</div>
	      			<div class="table-td tnine freightval">{{$cinfo->c_crncy_code}}  {{$data->tax_amount}}</div>
      			</div>
				  @if($val->rounding)
      			<div class="table-tr">
	      			<div class="table-td tonefull"></div>
	      			<div class="table-td tsixseven loading">Rounding</div>
	      			<div class="table-td tnine freightval">{{$cinfo->c_crncy_code}}  {{$data->rounding}}</div>
      			</div>
				@endif -->
      			
      			<div class="table-tr">
	      			<div class="table-td tonefull"></div>
	      			<div class="table-td tsixseven grand">Grand Total</div>
	      			<div class="table-td tnine grandval">{{$cinfo->c_crncy_code}}  {{$data->total}}</div>
      			</div>
      		</div>
      	</div><!-- estable -->

      	<!--  -->
      	<div class="termssec">
      		<h2>Terms & Conditions</h2>
      		<div class="termscntnt"><p>Return & Replacement Policy :</p>Materials delivered will have to be checked on site for damage while delivering and Sanitary & Fitting mandatorily will need to be open delivery, any other discrepancy other than sanitary & Fittings to be reported back in 5 days. Immediate Replacement against damaged goods will be done on availability or arrangements will be done after communicating a tentative date of delivery. All Return or replacement material should be immaculate & "Saleable" condition with original packaging.
				<ul>
					<li>Validity of the quotation is up to {{date('d-m-Y',strtotime($data->DueDate))}}.</li>
					<li>100% of the amount has to be paid in advance and no credit facility is available.</li>
					<li>Delivery of the items will be made within 15 days from the date of confirmation except against order</li>
					<li>Freight & Unloading will have to be borne by the customer and communicated before invoicing.</li>
					<li>All items received against order, strictly cannot be taken back</li>
					<li>Please check and verify the quantity before placing the order.</li>
					<li>Up to 2-3 % of transit damages has to be borne by the client, any damages more than that will be replaced.</li>
					<li>All delivery needs to be cross verified with invoice before driver leaves, and sign off to be done on invoice strictly by the person receiving the consignment. Delivery materials to be checked by customer or his representatives and no complaints will be accepted post this.</li>
					<li>Any terms mentioned in PI will be applicable</li>
                </ul>
			</div>
      	</div>
      	<!--  -->
      	<div class="signsec">
      		<h4>Signature of Customer </h4>
      	</div>

      	<!--  -->
      	<div class="footer">
      		<div class="footlft">
      			<p>{{$cinfo->c_address}}<br>e:{{$cinfo->c_email}} I t: {{$cinfo->c_phone}} </p>
      		</div>
      	</div>


      </div>
    </div>
</body>	

</html>

