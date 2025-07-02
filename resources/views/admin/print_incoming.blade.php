<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="{{asset('assets/css/printin.css')}}" rel="stylesheet" type="text/css" />
</head>

<body>
<a class="print_button btn btn-primary" href="{{url('admin/incoming-payment/'.$data->DocEntry)}}">Back</a>
		<button class="print_button print-margin btn btn-primary" onclick="window.print()">Print</button>
	<div class="DivIdToPrint">
	<div class="prninside">
      <div class="cmpnyhed">
      	<p>{{$cinfo->c_name}}</p>
      </div>
      <div class="main">
      	<div class="header">
      		<div class="logo"><img src="{{asset('assets/images/logo-light.png')}}"></div>
      		<div class="hdname">
      			<h1>Invoice</h1>
      		</div>
      	</div>

      	<div class="esti-dtls">
      		<div class="estidtls-hed">
      			<div class="estino">
      				<p>Invoice No:<span>{{$data->DocNum}}</span></p>
      			</div>
      			<div class="estidt">
      				<p>Date:<span>{{date('d-m-Y',strtotime($data->DocDate))}}</span></p>
      				<!-- <p>Quotation Validity:<span>{{date('d-m-Y',strtotime($data->DueDate))}}</span></p> -->
      			</div>
      		</div>
      		<div class="custdtls">
      			<label>Customer Details</label>
				@if($data->customer)
      				<p>
      				{{$data->customer->customer_code}}</br>
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
      			<div class="table-th ttwo wrap">Invoice No</div>
				<div class="table-th ttwo">Doc Date</div>
      			<div class="table-th ttwo">Doc Total</div>
      			<div class="table-th ttwo">Paied Amount</div>
      			<div class="table-th ttwo">Balance Amount</div>
      			<div class="table-th ttwo">CostCenter</div>
      			
      		</div>
      		<div class="table-bd">
					@php 
						$total_doc_total = 0;
						$total_paid_amount = 0;
						$total_balance_amount = 0;
					@endphp

					@if(count($data->Item_details) > 0)
						@foreach ($data->Item_details as $key => $val)
							@php
								$balance_amount = $val->salesInvoiceMaster->total - $val->salesInvoiceMaster->applied_amount;
								$total_doc_total += $val->InvDocTotal;
								$total_paid_amount += $val->SumApplied;
								$total_balance_amount += $balance_amount;
							@endphp

							<div class="table-tr">
								<div class="table-td tone">{{$key+1}}</div>
								<div class="table-td ttwo wrap" style="display:flex;word-break: break-all;">
									<p>{{$val->InvDocNum}}</p>
								</div>
								<div class="table-td ttwo ">{{$val->InvDocDate}}</div>
								<div class="table-td ttwo">{{$cinfo->c_crncy_code}} {{$val->InvDocTotal}}</div>
								<div class="table-td ttwo">{{$cinfo->c_crncy_code}} {{$val->SumApplied}}</div>
								<div class="table-td ttwo">{{$cinfo->c_crncy_code}} {{$balance_amount}}</div>
								<div class="table-td ttwo">{{$val->CostCenter1}}</div>
							</div>
						@endforeach
					@endif
			</div>

				<div class="extra-ft">
					<div class="table-tr">
						<div class="table-td tonefull"></div>
						<div class="table-td tsixseven mrptol">Total Doc Total</div>
						<div class="table-td tnine mrptolval">{{$cinfo->c_crncy_code}} {{$total_doc_total}}</div>
					</div>
					<div class="table-tr">
						<div class="table-td tonefull"></div>
						<div class="table-td tsixseven disctot">Total Paid Amount</div>
						<div class="table-td tnine disctotval">{{$cinfo->c_crncy_code}} {{$total_paid_amount}}</div>
					</div>
					@if($total_balance_amount > 0)
					<div class="table-tr">
						<div class="table-td tonefull"></div>
						<div class="table-td tsixseven subtot">Total Balance to Pay</div>
						<div class="table-td tnine subtotval">{{$cinfo->c_crncy_code}} {{$total_balance_amount}}</div>
					</div>
					@else
					<div class="table-tr">
						<div class="table-td tonefull"></div>
						<div class="table-td tsixseven subtot">The full amount has been paid.</div>
						<div class="table-td tnine subtotval"></div>
					</div>
					@endif
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
      		<!-- <div class="footrgt">
      			<div class="socialogo facelogo" style="background-image: url({{asset('assets/images/facebook-icon.png')}});"></div>
      			<div class="socialogo instaogo" style="background-image: url({{asset('assets/images/instagram-icon.png')}});"></div>
      			<div class="socialogo youtlogo" style="background-image: url({{asset('assets/images/youtube-icon.png')}});"></div>
      			<div class="textname">mgcalicut</div>
      		</div> -->
      	</div>


      </div><!-- main -->
    </div>
</body>	

</html>

