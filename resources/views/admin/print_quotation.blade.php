<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="{{asset('assets/css/printin.css')}}" rel="stylesheet" type="text/css" />
</head>

<body>
<a class="print_button btn btn-primary" href="{{url('admin/quotations/'.$data->id)}}">Back</a>
		<button class="print_button print-margin btn btn-primary" onclick="window.print()">Print</button>
	<div class="DivIdToPrint">
	<div class="prninside">
      <div class="cmpnyhed">
      	<p>LE MARBLE GALLERY PVT. LTD.</p>
      </div>
      <div class="main">
      	<div class="header">
      		<div class="logo"><img src="{{asset('assets/images/logo-light.png')}}"></div>
      		<div class="hdname">
      			<h1>Estimate</h1>
      		</div>
      	</div>

      	<div class="esti-dtls">
      		<div class="estidtls-hed">
      			<div class="estino">
      				<p>Estimate No:<span>{{$data->DocNo}}</span></p>
      			</div>
      			<div class="estidt">
      				<p>Date:<span>{{date('d-m-Y',strtotime($data->DocDate))}}</span></p>
      				<p>Quotation Validity:<span>{{date('d-m-Y',strtotime($data->DueDate))}}</span></p>
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
      			@if($data->referral3) 
				    <p>
					    {{$data->referral3->name}}</br>
						{{$data->referral3->phone}}</br>
						@if($data->referral3->alt_phone){{$data->referral3->alt_phone}},@endif
						@if($data->referral3->email){{$data->referral3->email}}</br>@endif
						@if($data->referral3->designation){{$data->referral3->designation}}</br>@endif
						@if($data->referral3->address){{$data->referral3->address}}@endif
					</p>
				@endif
      		</div>
      	</div>

      	<div class="cntnt">
      		<p>Dear Sir/Madam,<br>
				Thank you for choosing Le Marble Gallery. In response to your enquiry, we take pleasure in furnishing
				our lowest rate for your kind consideration. </p>
      	</div>
      	<!--  -->
      	<div class="estable">
      		<div class="table-hd">
      			<div class="table-th tone">No.</div>
      			<div class="table-th ttwo">Description</div>
      			<div class="table-th tthree">Areas</div>
      			<div class="table-th tten">Qnty / Sqft</div>
      			<div class="table-th tfour">Qnty / No</div>
      			<div class="table-th tfive">Mrp / <span class="prod-class">(Sqft/No)</span></div>
      			<div class="table-th tseven">Disc / <span class="prod-class">(Sqft/No)</span></div>
      			<div class="table-th tnine">Total</div>
      			<div class="table-th tsix">Image</div>
      		</div>
      		<div class="table-bd">
			@php 
				$total_discount = $doc_total = 0;	
			@endphp
			@if(count($data->items) > 0)
				@foreach ($data->items as $key=>$val)
				@php
					$code = $val->ItemCode;
					$TLarr = explode('TL',$code);
					$NSarr = explode('NS',$code);				
					
					$mrp_per_no = $val->UnitPrice * (100+$val->TaxRate)/100;
					if(!$val->products->sqft_Conv)
						$val->products->sqft_Conv = 1;
					$mrp_per_sqft = round($mrp_per_no/$val->products->sqft_Conv,2);

					$total = round($val->LineTotal * (100+$val->TaxRate)/100,2);
					$after_disc_no = $total/$val->Qty;
					$after_disc_sqft = $total/$val->SqftQty;

					$discount = $val->LineDiscPrice * (100+$val->TaxRate)/100; 
					$total_discount = $total_discount + $discount;

					$line_total = round($val->LineTotal * (100+$val->TaxRate)/100,2);
					$doc_total = $doc_total + $line_total;
				@endphp
					
					<!-- $val->PerSqftDisc =	$val->PerSqftDisc * (100+$val->TaxRate)/100;

					if($val->products->sqft_Conv)
						$disc_per_no =  $val->PerSqftDisc * $val->products->sqft_Conv;
					
					else
						$disc_per_no =  $val->PerSqftDisc;

					$after_disc_no = $mrp_per_no - $disc_per_no;
					$after_disc_sqft = $mrp_per_sqft - $val->PerSqftDisc;			 -->
					<div class="table-tr">
						<div class="table-td tone">{{$key+1}}</div>
						<div class="table-td ttwo wrap" style="display:flex;word-break: break-all;">
										<p>{{$val->products->productName}}</p>
									</div>
						<div class="table-td tthree wrap">{{$val->area}}</div>
						<div class="table-td tten">{{$val->SqftQty}}</div>
						<div class="table-td tfour">{{$val->Qty}}</div>
						<div class="table-td tfive">
							@if(count($TLarr) > 1 || count($NSarr) > 1) 
								{{round($mrp_per_sqft,2)}}
							
							@else
								{{round($mrp_per_no,2)}}
							@endif
						</div>
						<div class="table-td tseven">
						@if(count($TLarr) > 1 || count($NSarr) > 1) 
							{{round($after_disc_sqft,2)}}
						@else
							{{round($after_disc_no,2)}}
						@endif
						</div>
						<div class="table-td tnine">{{round($total,2)}}</div>
						<div class="table-td tsix">
							@if($val->products->image)<figure><img src="{{request()->getSchemeAndHttpHost()}}/assets/images/products/{{$val->products->image}}"></figure>@endif
						</div>
					</div>
				@endforeach
			@endif
			@php
				$total_amount = round($doc_total,2)+$data->FreightCharge+$data->UnloadingCharge+$data->LoadingCharge;
			@endphp
      		</div>
      		<div class="extra-ft">
      			<div class="table-tr">
	      			<div class="table-td tonefull"></div>
	      			<div class="table-td tsixseven mrptol">MRP Total</div>
	      			<div class="table-td tnine mrptolval">{{round($total_amount + $total_discount,2) - ($data->FreightCharge + $data->UnloadingCharge + $data->LoadingCharge)}}</div>
      			</div>
      			<div class="table-tr">
	      			<div class="table-td tonefull"></div>
	      			<div class="table-td tsixseven disctot">Discount</div>
	      			<div class="table-td tnine disctotval">{{round($total_discount,2)}}</div>
      			</div>
      			<div class="table-tr">
	      			<div class="table-td tonefull"></div>
	      			<div class="table-td tsixseven subtot">Sub Total</div>
	      			<div class="table-td tnine subtotval">{{round($total_amount,2)- ($data->FreightCharge + $data->UnloadingCharge + $data->LoadingCharge)}}</div>
      			</div>
      			<div class="table-tr">
	      			<div class="table-td tonefull"></div>
	      			<div class="table-td tsixseven freight">Freight Charges</div>
	      			<div class="table-td tnine freightval">{{round($data->FreightCharge,2)}}</div>
      			</div>
      			<div class="table-tr">
	      			<div class="table-td tonefull"></div>
	      			<div class="table-td tsixseven loading">Loading Charges</div>
	      			<div class="table-td tnine freightval">{{round($data->LoadingCharge,2)}}</div>
      			</div>
      			<div class="table-tr">
	      			<div class="table-td tonefull"></div>
	      			<div class="table-td tsixseven loading">Unloading Charges</div>
	      			<div class="table-td tnine freightval">{{round($data->UnloadingCharge,2)}}</div>
      			</div>
      			<div class="table-tr">
	      			<div class="table-td tonefull"></div>
	      			<div class="table-td tsixseven grand">Grand Total</div>
	      			<div class="table-td tnine grandval">{{round($total_amount)}}</div>
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
      			<p>Le Marble Gallery I Opposite Civil Station I Eranhipalam I Calicut-20<br>e:hello@mggroupin.com I t: +914952373512 I www.mggroupin.com</p>
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

