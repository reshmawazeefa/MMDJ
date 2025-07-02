<script>
    $(document).ready(function() {
        
        $('#sepBilling').change(function(){
            if($('#sepBilling').is(':checked'))
            {
                $('select[name=prefixBilling').val($('select[name=prefix').val());
                $('input[name=addressIDBilling').val($('input[name=addressID').val());
                $('input[name=addressBilling').val($('input[name=address').val());
                $('input[name=address2Billing').val($('input[name=address2').val());
                $('input[name=placeBilling').val($('input[name=place').val());
                $('input[name=zip_codeBilling').val($('input[name=zip_code').val());
                $('input[name=stateBilling').val($('input[name=state').val());
                $('input[name=countryBilling').val($('input[name=country').val());
            }
            else{                
            }
        });
        $('select[name=vehicle_type]').change(function(){
            if(this.value == 'N/A')
            {
                $('input[name=km]').attr('required', false);
                $('label[for=distance] span[class=text-danger]').html('');
            }
            else{
                $('input[name=km]').attr('required', true);
                $('label[for=distance] span[class=text-danger]').html('*');
            }
        });

        $.ajax({
           type:'POST',
           url:"{{ url('admin/code') }}",
           data:{_token: "{{ csrf_token() }}",type:'partner'},
           success:function(data){
              $('#partner_code').val(data);
           }
        });
        $.ajax({
           type:'POST',
           url:"{{ url('admin/code') }}",
           data:{_token: "{{ csrf_token() }}",type:'customer'},
           success:function(data){
              $('#customer_code').val(data);
           }
        });

        $.ajax({
           type:'POST',
           url:"{{ url('admin/code') }}",
           data:{_token: "{{ csrf_token() }}",type:'quotation'},
           success:function(data){
              $('input[name=docNumber]').val(data);
           }
        });

        $(".customerSelect").select2({
            ajax: {
            url: "{{ url('admin/ajax/customers') }}",
            type: 'POST',
                    dataType: 'json',
                    delay: 250,
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        q: params.term, // search term
                        page: params.page || 1
                    };
                    },
            processResults: function (data,params) {
                params.current_page = params.current_page || 1;
                return {
                results:  $.map(data.data, function (item) {
                        return {
                            text: item.name+'('+item.phone+')',
                            id: item.customer_code
                        }
                    }),
                        /*  pagination: {
                            more: (params.current_page * 30) < data.total
                        } */
                        pagination: data.pagination
                };
            },
                autoWidth: false,
            cache: true
            },
                dropdownAutoWidth: true,
                width: '100%',
                placeholder: "By searching name,phone",
                allowClear: false,
        });

        $(".engineerSelect").select2({
            ajax: {
            url: "{{ url('admin/ajax/partners/engineer') }}",
            type: 'POST',
                    dataType: 'json',
                    delay: 250,
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        q: params.term, // search term
                        page: params.page || 1
                    };
                    },
            processResults: function (data,params) {
                params.current_page = params.current_page || 1;
                return {
                results:  $.map(data.data, function (item) {
                        return {
                            text: item.name+'('+item.phone+')',
                            id: item.partner_code,
                        }
                    }),
                        /*  pagination: {
                            more: (params.current_page * 30) < data.total
                        } */
                        pagination: data.pagination
                };
            },
                autoWidth: false,
            cache: true
            },
                dropdownAutoWidth: true,
                width: '100%',
                placeholder: "By searching name,phone",
                allowClear: false,
        });

        $(".contractorSelect").select2({
            ajax: {
            url: "{{ url('admin/ajax/partners/contractor') }}",
            type: 'POST',
                    dataType: 'json',
                    delay: 250,
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        q: params.term, // search term
                        page: params.page || 1
                    };
                    },
            processResults: function (data,params) {
                params.current_page = params.current_page || 1;
                return {
                results:  $.map(data.data, function (item) {
                        return {
                            text: item.name+'('+item.phone+')',
                            id: item.partner_code,
                        }
                    }),
                        /*  pagination: {
                            more: (params.current_page * 30) < data.total
                        } */
                        pagination: data.pagination
                };
            },
                autoWidth: false,
            cache: true
            },
                dropdownAutoWidth: true,
                width: '100%',
                placeholder: "By searching name,phone",
                allowClear: false,
        });

        $(".agentSelect").select2({
            ajax: {
            url: "{{ url('admin/ajax/partners/Sales Executive') }}",
            type: 'POST',
                    dataType: 'json',
                    delay: 250,
                data: function(params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        q: params.term, // search term
                        page: params.page || 1
                    };
                    },
            processResults: function (data,params) {
                params.current_page = params.current_page || 1;
                return {
                results:  $.map(data.data, function (item) {
                        return {
                            text: item.name+'('+item.phone+')',
                            id: item.partner_code,
                        }
                    }),
                        /*  pagination: {
                            more: (params.current_page * 30) < data.total
                        } */
                        pagination: data.pagination
                };
            },
                autoWidth: false,
            cache: true
            },
                dropdownAutoWidth: true,
                width: '100%',
                placeholder: "By searching name,phone",
                allowClear: false,
        });
    });
    
    $(document ).on("click",".add-item",function()
    {
        var val = parseInt($("#count").val())+1;
        $("#count").val(val);
        var html = '';
        //$('.new-table .ech-tr:last').after(html);
        //load_product();
    });

    $(document ).on("click",".delete-item",function() {
        if($('div .ech-tr').length == 1)
        {
            var val = parseInt($("#count").val())+1;
            $("#count").val(val);
            $(".add-item").click();
        }
        $(this).closest('.ech-tr').remove();
        calculate_footer();
    });

    function set_data(r)
    {
        var product_id = '#product_'+r;
        var warehouse_id = '.warehouse_'+r;
        var stock_det = '#stockdet_'+r;
        var uom_id = '.uom_'+r;
        var onhand_id = '.onhand_'+r;
        var tax_id = '.tax_'+r;
        var discount_id = '.discount_'+r;
        var netunitprice_id = '.netunitprice_'+r;
        var sqftprice_id = '.sqftprice_'+r;
        var productname_id = '#productname_'+r;
        var whsCode = "VNGW0002";
        var productCode = $(product_id+' option:selected').val();
        var price_list = $('#price_list option:selected').val();
        $.ajax({
            url: "{{ url('admin/ajax/product_stock') }}",
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}",
                whsCode: whsCode,
                productCode: productCode,
                price_list: price_list,
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                //var sqft_price = (data.price_list.price*((100+parseFloat(data.product.taxRate))/100)/data.product.sqft_Conv).toFixed(2);
                $(stock_det).val(JSON.stringify(data));
                $(onhand_id).html(data.itemwarehouse.OnHand);                
                $(uom_id).html(data.product.invUOM);
                $(discount_id).html(0);
                $(tax_id).html(data.product.taxRate);
                $(productname_id).html(data.product.productName);
                price_calc(r);
            }
        });
    }

    function price_calc(r)
    {
        var stock_det = '#stockdet_'+r;
        var discvalue_id = '#discvalue_'+r;
        var taxable_id = '.taxable_'+r;
        var taxamount_id = '.taxamount_'+r;
        var linetotal_id = '.linetotal_'+r;
        var uom_id = '.uom_'+r;
        var netprice_id = '.netprice_'+r;
        var sqft_id = '.sqft_'+r;
        var discount_id = '.discount_'+r;
        var discounttype_id = '#discounttype_'+r;
        var LineDiscPrice_id = '#LineDiscPrice_'+r;
        var sqftprice_id = '.sqftprice_'+r;
        var sqft = parseFloat($(sqft_id).val()); 
        var persqftprice = parseFloat($(sqftprice_id).val());
        var netprice =  sqft * persqftprice;//parseFloat($(sqftprice_id).html()) * sqft;
        $(netprice_id).html(netprice.toFixed(2));
        var disc = parseFloat($(discvalue_id).val());
        var stock_array = JSON.parse($(stock_det).val());
        var taxRate = stock_array.product.taxRate;
        var discount = 0; 
        if(disc)
        {
            if($(discounttype_id).val() == 'Percentage')
            {
                discount = netprice * disc/100;
            }
            else
            {
                discount = disc * sqft;
            }
            netprice = netprice - discount;
        }
        var sqftamtafterdisc = netprice/sqft;
        var sqftamtafterdisc_id = '.sqftamtafterdisc_'+r;
        $(sqftamtafterdisc_id).html(sqftamtafterdisc.toFixed(4));
        //$(netprice_id).html(price_without_tax.toFixed(2));     
        $(discount_id).html(discount.toFixed(2));
        $(LineDiscPrice_id).val(discount.toFixed(2));
        //netprice = price_without_tax * ((100+taxRate)/100);
        var price_without_tax = (netprice * 100)/(100+parseFloat(taxRate));
        var taxamount = netprice - price_without_tax;
        $(taxamount_id).html(taxamount.toFixed(2));
        var linetotal = netprice;
        $(linetotal_id).html(linetotal.toFixed(2));
        $(linetotal_id).val(linetotal.toFixed(2));
        calculate_footer();
    }

    function calculate_footer()
    {
        var count = $('#count').val();
        let total = 0; let tot_qty = 0; let tot_sqm = 0; let tot_sqft = 0; let tot_disc = 0;let tax_amount = 0;
        let freight_charge = 0; let loading_charge = 0; let unloading_charge = 0;
        for(var i = 0; i <= count; i++)
        {
            var netprice_id = '.netprice_'+i;
            if($(netprice_id).html())
                total = total+parseFloat($(netprice_id).html());

            var quantity_id = '#quantity_'+i;
            if($(quantity_id).val())
                tot_qty = tot_qty + parseInt($(quantity_id).val());

            var sqm_id = '.sqm_'+i;
            if($(sqm_id).html())
                tot_sqm = tot_sqm + parseFloat($(sqm_id).html());

            var sqft_id = '.sqft_'+i;
            if($(sqft_id).html())
                tot_sqft = tot_sqft + parseFloat($(sqft_id).html()); 

            var discount_id = '.discount_'+i;
            if($(discount_id).html())
                tot_disc = tot_disc + parseFloat($(discount_id).html());

            var taxamount_id = '.taxamount_'+i;
            if($(taxamount_id).html())
            {
                tax_amount = tax_amount + parseFloat($(taxamount_id).html());
            }

        }

        $('#tot_qty').html(tot_qty.toFixed(2));

        $('#tot_sqm').html(tot_sqm.toFixed(2));

        $('#tot_sqft').html(tot_sqft.toFixed(2));

        $('#total_amount').html(total.toFixed(2));

        $('#discount_amount').html(tot_disc.toFixed(2));

        $('input[name=discount_amount]').val(tot_disc.toFixed(2));

        $('#tax_amount').html(tax_amount.toFixed(2));

        if($('#freight_charge').val())
            freight_charge = parseFloat($('#freight_charge').val());

        if($('#loading_charge').val())
            loading_charge = parseFloat($('#loading_charge').val());

        if($('#unloading_charge').val())
            unloading_charge = parseFloat($('#unloading_charge').val());

        var grand_total = total-tot_disc+freight_charge+loading_charge+unloading_charge;
        $('#grand_total').html(grand_total.toFixed(0));
        $('input[name=tax_amount]').val(tax_amount.toFixed(2));
        $('input[name=grand_total]').val(grand_total.toFixed(2));

        //applydiscount(0);
    }

    function applydiscount(val=0)
    {
        var discount_amount = $('#total_amount').html() * val/100;
        //$('#discount_amount').html(discount_amount);
        var count = $('#count').val();
        var tax_amount = 0;
        for (let i = 0; i <= count; i++) 
        {
            var taxable_id = '.taxable_'+i;
            var netprice_id = '.netprice_'+i;
            var tax_id = '.tax_'+i;
            var taxable = 0; var netprice = 0;
            if($(taxable_id).html())
            {
                taxable = parseFloat($(taxable_id).html());
                netprice = taxable - taxable * val/100;
            }
            if($(tax_id).html())
            {
                var taxpercent = parseFloat($(tax_id).html());
                tax_amount = tax_amount + netprice * taxpercent/100;
            }
            $(netprice_id).html(netprice);
        }
        //$('#discount_amount').html(discount_amount.toFixed(2));
        $('#tax_amount').html(tax_amount.toFixed(2));
        var grand_total = $('#total_amount').html()-discount_amount+tax_amount;
        $('#grand_total').html(grand_total.toFixed(2));
        $('input[name=tax_amount]').val(tax_amount.toFixed(2));
        $('input[name=grand_total]').val(grand_total.toFixed(2));
    }

    $("#customer-form").submit(function(e){
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            url: url,
            type:'POST',
            data: form.serialize(),
            success: function(data) {
                $('.alert').html('');
                $(".alert").css('display','block');
                if($.isEmptyObject(data.error)){
                    $('.alert').html(data.success);
                    $('#customer-form').trigger("reset");
                    $.ajax({
                        type:'POST',
                        url:"{{ url('admin/code') }}",
                        data:{_token: "{{ csrf_token() }}",type:'customer'},
                        success:function(data){
                            $('#customer_code').val(data);
                        }
                    });
                    setTimeout(function() {$('#addCustModal').modal('hide');}, 2000);
                }else{
                    $('.alert').html(data.error);
                }
            }
        });
    
    });

    $("#partner-form").submit(function(e){
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        $.ajax({
            url: url,
            type:'POST',
            data: form.serialize(),
            success: function(data) {
                $('.alert-part').html('');
                $(".alert-part").css('display','block');
                if($.isEmptyObject(data.error)){
                    $('.alert-part').html(data.success);
                    $('#partner-form').trigger("reset");
                    $.ajax({
                        type:'POST',
                        url:"{{ url('admin/code') }}",
                        data:{_token: "{{ csrf_token() }}",type:'partner'},
                        success:function(data){
                            $('#partner_code').val(data);
                        }
                    });
                    setTimeout(function() {$('#addPartModal').modal('hide');}, 2000);
                }else{
                    $('.alert-part').html(data.error);
                }
            }
        });
    
    });

    $(document).on("click",".opentr-btn",function(){

        if($(this).closest('.ech-tr').hasClass('open-tr'))
        {         
            $(this).closest('.ech-tr').removeClass('open-tr');
        }
        else{
            $(this).closest('.ech-tr').addClass('open-tr');
        }           
    });
    
    $(document ).on("click",".add-item",function()
    {
        var val = parseInt($("#count").val())+1;
        $("#count").val(val);
        var html = '<div class="ech-tr" id="tr_'+val+'">'
                        +'<div style="display:none">'
                            +'<span class="taxable_'+val+'"></span>'
                            +'<span class="tax_'+val+'"></span>'
                            +'<span class="taxamount_'+val+'"></span>'
                            +'<span class="netprice_'+val+'"></span>'
                            +'<input type="hidden" name="LineTotal[]" class="linetotal_'+val+'">'
                            +'<input type="hidden" name="line_id[]" value="-1">'
                        +'</div>'
                        +'<div class="echtr-inn">'
                            +'<div class="row">'
                            +'<div class="colbor col-xl-1 col-lg-1 col-md-1 col-sm-2 col-2">'
                            +'<div class="ech-td">'
                            +'<span class="btn opentr-btn"></span>'
                            +'</div>'
                            +'</div>'
                            +'<div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-10">'
                            +'<div class="ech-td">'
                            +'<label class="td-label">Item Type'
                            +'<span id="productname_'+val+'" class="product-name"></span>'
                            +'</label>'
                            +'<div class="td-value">'
                            +'<select id="product_'+val+'" required onChange="set_data('+val+')" name="product[]" class="product_'+val+' form-control">'
                            +'<option value="">Select</option>'
                            +'<option value="NS10117">MARBLE SLAB</option>'
                            +'<option value="NS10118">GRANITE SLAB</option>'
                            +'<option value="OT90126">STEEL STAND</option>'
                            +'<option value="NS10009">COMPOSITE QUARTZ BIANCO CLASSIC - KALINGA</option>'
                            +'<option value="NS10010">COMPOSITE QUARTZ BIANCO NEVE</option>'
                            +'<option value="NS10015">COMPOSITE QUARTZ FONDENTE BROWN</option>'
                            +'<option value="NS10017">COMPOSITE  QUARTZ GRIGIO DIAMANTE - KALINGA</option>'
                            +'<option value="NS10018">COMPOSITE QUARTZ GRIGIO LONDRA - KALINGA</option>'
                            +'<option value="NS10021">COMPOSITE QUARTZ MARRONE DIAMANTE - KALINGA</option>'
                            +'<option value="NS10024">COMPOSITE QUARTZ NERO DIAMANTE - KALINGA</option>'
                            +'<option value="NS10004">COMPOSITE QUARTS BIANCO DIAMANTE - KALINGA</option>'
                            +'<option value="NS10023">COMPOSITE QUARTZ NERO CLASSIC</option>'
                            +'<option value="NS10030">COMPOSTE QUARTS SANDY DIAMANTE - KALINGA</option>'
                            +'<option value="NS10016">COMPOSITE QUARTZ GIALLO DIAMANTE - KALINGA</option>'
                            +'<option value="NS10011">COMPOSITE QUARTZ BLUE DIAMANTE-KALINGA</option>'
                            +'<option value="NS10000">ANTICO BROWN (KALINGA) TERRAZZO</option>'
                            +'<option value="NS10001">ARTIFICAL MARBLE SLABS MARCELLO-18 MM KALINGA</option>'
                            +'<option value="NS10002">ARTIFICAL MARBLE SLABS TIBERIO -15 MM</option>'
                            +'<option value="NS10003">COMPOSITE QUAETZ ROSSO DIAMANTE - KALINGA</option>'
                            +'<option value="NS10005">COMPOSITE QUARTS - CEMENT QUARTZ</option>'
                            +'<option value="NS10006">COMPOSITE QUARTS CLASSIC BEIGE</option>'
                            +'<option value="NS10007">COMPOSITE QUARTS VETRO BIANCO - KALINGA</option>'
                            +'<option value="NS10008">COMPOSITE QUARTZ BEIGE DIAMANTE</option>'
                            +'<option value="NS10012">COMPOSITE QUARTZ CONCRETE 15 MM</option>'
                            +'<option value="NS10013">COMPOSITE QUARTZ CONCRETE 20MM</option>'
                            +'<option value="NS10014">COMPOSITE QUARTZ CREMA SCURO - KALINGA</option>'
                            +'<option value="NS10019">COMPOSITE QUARTZ JERUSALAM GRAY DIAMANTE</option>'
                            +'<option value="NS10020">COMPOSITE QUARTZ JERUSALEM DIAMANTE</option>'
                            +'<option value="NS10022">COMPOSITE QUARTZ MOCCA DIAMANTE  - KALINGA</option>'
                            +'<option value="NS10025">COMPOSITE QUARTZ - NISLEY 15MM</option>'
                            +'<option value="NS10026">COMPOSITE QUARTZ - NISLEY 20MM</option>'
                            +'<option value="NS10027">COMPOSITE QUARTZ PAQS  CREMA VERONA</option>'
                            +'<option value="NS10028">COMPOSIT QUARTS CREMA VERONA 20MM</option>'
                            +'<option value="NS10029">COMPOSIT QUARTZ CHOCOLATE BROWN</option>'
                            +'<option value="NS10151">ARTIFICIAL QUARTZ SLABS USH 20 MM (KALINGA)</option>'
                            +'<option value="NS10031">CRISTALISED GLASS PANEL</option>'
                            +'</select>'
                            +'</div>'
                            +'</div>'
                            +'</div>'                                  
                            +'<div class="colbor col-xl-3 col-lg-3 col-md-3 col-sm-4 col-6">'
                            +'<div class="ech-td">'
                            +'<label class="td-label">Item name</label>'
                            +'<div class="td-value">'
                            +'<input required type="text" name="name[]" class="form-control">'
                            +'</div>'
                            +'</div>'
                            +'</div>'
                            +'<div class="colbor col-xl-3 col-lg-4 col-md-4 col-sm-5 col-6">'
                            +'          <div class="ech-td">'
                            +'              <label class="td-label">Price(per Sqft)</label>'
                            +'              <div class="td-value">'
                            +'                  <input type="number" id="sqftprice_'+val+'" required class ="form-control sqftprice_'+val+'" onkeyup="price_calc('+val+')" name="sqftprice[]">'
                            +'              </div>'
                            +'          </div>'
                            +'      </div>'
                            +'      <div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">'
                            +'          <div class="ech-td">'
                            +'              <label class="td-label">Sqft</label>'
                            +'              <div class="td-value">'
                            +'                  <input min="0.01" step="0.01" type="number" id="sqft_'+val+'" required class="sqft_'+val+' form-control" onkeyup="price_calc('+val+')" name="sqft[]">' 
                            +'                  <input type="hidden" id="stockdet_'+val+'" value="">'                                 
                            +'              </div>'
                            +'          </div>'
                            +'      </div>'                                
                                    
                            +'      <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">'
                            +'          <div class="ech-td"><label class="td-label">Disc Type</label>'
                            +'              <div class="td-value">'
                            +'              <select id="discounttype_'+val+'" onChange="price_calc('+val+')" name="discount_type[]" class="form-control">'
                            +'                  <option value="Amount">Amount</option>'
                            +'                  <option value="Percentage">Percentage</option>'
                            +'              </select>'
                            +'              </div>'
                            +'          </div>'
                            +'      </div>'
                            +'      <div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">'
                            +'          <div class="ech-td">'
                            +'              <label class="td-label">Disc Value</label>'
                            +'              <div class="td-value">'
                            +'                  <input type="number" id="discvalue_'+val+'" step="0.0001" value="0" class="form-control" onkeyup="price_calc('+val+')" name="disc_perct[]">'
                            +'                  <input type="hidden" id="LineDiscPrice_'+val+'" name="LineDiscPrice[]" value="0">'
                            +'              </div>'
                            +'          </div>'
                            +'      </div>'
                            +'      <div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">'
                            +'          <div class="ech-td">'
                            +'              <label class="td-label">Area</label>'
                            +'              <div class="td-value">'
                            +'              <input type="text" name="area[]" class="form-control" value="">'
                            +'              </div>'
                            +'          </div>'
                            +'      </div>'
                            +'      <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">'
                            +'          <div class="ech-td">'
                            
                            +'              <label class="td-label">UOM</label>'
                            +'          <div class="td-value">'
                            +'              <span class="uom_'+val+'"></span>'
                            +'              </div>'
                            +'          </div>'
                            +'      </div>'
                            +'    <div class="colbor col-xl-2 col-lg-2 col-md-3 col-sm-4 col-6">'
                            +'         <div class="ech-td">'
                            +'             <label class="td-label">After Disc Price/Sqft</label>'
                            +'              <div class="td-value">'
                            +'              <span style="display:none;" class="discount_'+val+'"></span>'
                            +'              <span class="sqftamtafterdisc_'+val+'"></span>'
                            +'              </div>'
                            +'         </div>'
                            +'     </div>'
                            +'       <div class="colbor col-xl-2 col-lg-2 col-md-2 col-sm-4 col-6">'
                            +'           <div class="ech-td">'
                            +'               <label class="td-label">Line Total</label>'
                            +'               <div class="td-value">'
                            +'               <span class="linetotal_'+val+'"></span>'
                            +'               </div>'
                            +'           </div>'
                            +'       </div>'
                            +'   </div>'
                            +'</div>'                        
                            +'<div class="actn-td">'
                            +'    <a href="javascript:void(0);" class="action-icon add-item"></a>'
                            +'    <a href="javascript:void(0);" class="action-icon delete-item"></a>'
                            +'</div>'
                            +'</div>';
        $('.new-table .ech-tr:last').after(html);
    });
</script>