<link rel="stylesheet" href="{{url('vendor/bootstrap/scss/bootstrap.css')}}">

<form class="form-horizontal form-label-left input_mask" id="update-order"
      action="{{route('order-update-post')}}" method="post"
      enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="hidden" name="id" id="id" value="{{$order['id']}}">
    <div class="form-group">
        <label class="text-black font-w500 w-100">Satıcı Site</label>
        <select class="form-control default-select w-100" id="provider_id" name="provider_id">
            <option value="0">Seçiniz...</option>
            @foreach($providers as $provider)
                <option value="{{$provider['id']}}" @if($order['provider_id'] == $provider['id']) selected @endif >{{$provider['name']}}</option>
            @endforeach
        </select>
        <div id="provider_id_error"></div>
    </div>

    <div class="form-group">
        <label class="text-black font-w500 w-100">Durum</label>
        <select class="form-control default-select w-100" id="status" name="status" onchange="checkStatus();">

            <option value="1" @if($order['status'] == 1) selected @endif>Hazırlanıyor</option>
            <option value="2" @if($order['status'] == 2) selected @endif>Tamamlandı</option>
            <option value="3" @if($order['status'] == 3) selected @endif>İptal Edildi</option>
        </select>
        <div id="status_error"></div>
    </div>



    <div class="form-group">

        <label class="text-black font-w500">Sipariş Tarihi</label>
        <input name="order_date" type="date" class="form-control" id="order_date"
               value="{{\Carbon\Carbon::parse($order['order_date'])->format('Y-m-d')}}">
        <div id="order_date_error"></div>
    </div>

    <div class="form-group">
        <label class="text-black font-w500">Sipariş No</label>
        <input name="order_id" id="order_id" value="{{$order['order_id']}}" type="text" class="form-control">
        <div id="order_id_error"></div>
    </div>

    <div id="invoice_div" @if(empty($order['invoice_date']))style="display: none"@endif>

        <div class="form-group">
            <label class="text-black font-w500">Fatura Tarihi</label>
            <input name="invoice_date" type="date" class="form-control" id="invoice_date"
            value="{{\Carbon\Carbon::parse($order['invoice_date'])->format('Y-m-d')}}">
            <div id="invoice_date_error"></div>
        </div>

        <div class="form-group">
            <label class="text-black font-w500">Fatura No</label>
            <input name="invoice_id" id="invoice_id" type="text" class="form-control"
                   @if(!empty($order['invoice_id'])) value="{{$order['invoice_id']}}" @endif>
            <div id="invoice_id_error"></div>
        </div>


    </div>

    <div class="form-group">
        <label class="text-black font-w500">Müşteri Adı</label>
        <input name="customer_name" id="customer_name" type="text" class="form-control" value="{{$order['customer_name']}}">
        <div id="customer_name_error"></div>
    </div>
    <div class="form-group">
        <label class="text-black font-w500">Müşteri Telefon</label>
        <input name="customer_phone" id="customer_phone" type="text" class="form-control" value="{{$order['customer_phone']}}">
        <div id="customer_phone_error"></div>
    </div>
    <div class="form-group">
        <label class="text-black font-w500">Müşteri Email</label>
        <input name="customer_email" id="customer_email" type="text" class="form-control" value="{{$order['customer_email']}}">
        <div id="customer_email_error"></div>
    </div>


    <input type="hidden" name="product_list" id="product_list" value="{{$order['product_list']}}">
    @php
    $co = 1;
    $v_array=[];
    $v_array[0]=13;

    @endphp
@foreach($order->order_products as $op)
        @php
          $v_array[$co] = $op['variant_id'];
        @endphp
    <div class="input-group sec">
        @if($co == 1)
        <label class="text-black font-w500 w-100">Ürün Seçimi</label>
        @endif
        <div id="radius" class="input-group-prepend">
            <span class="input-group-text">{{$co}}. Ürün</span>
        </div>
        <select name="product_id_{{$co}}" class="default-select form-control" id="product_id_{{$co}}" onchange="showVariant(this.value,{{$co}})">

            @foreach($products as $product)
                <option value="{{$product['id']}}" @if($op['product_id'] == $product['id']) selected @endif>{{$product['product_name']}}</option>
            @endforeach

        </select>
        <div id="product_error"></div>
        <select name="variant_id_{{$co}}" class="default-select form-control" id="variant_id_{{$co}}" onchange="variantSelected({{$co}})">
            <option value="0">Varyant</option>

        </select>
        <input type="number" class="form-control" name="qty_{{$co}}" id="qty_{{$co}}" value="{{$op['quantity']}}">
        <div class="input-group-append" style="height: 38px">
            <span class="input-group-text" id="basic-addon2">adet</span>
        </div>
        <div id="qty_error"></div>
    </div>
    @php
    $co++;
    @endphp
@endforeach
    @php
        $co--;
    @endphp
    <div id="additional"></div>
    <div id="select_error"></div>
    <button type="button" class="btn btn-rounded btn-outline-success w-100 mt-15"
            value="AND" id="and-button" onclick="addDiv()"><i class="fa fa-plus"></i> Yeni Ürün Ekle</button>

    <br><br>

    <div class="input-group">
        <label class="text-black font-w500 w-100">Sipariş Tutarı</label>
        <input type="text" class="form-control" id="amount" name="amount" value="{{$order['amount']}}">
        <div class="input-group-append">
            <span class="input-group-text ">TL</span>
        </div><br>
        <div id="amount_error" style="width: 100%"></div>
    </div>
    <br>
    <button type="submit" class="btn btn-primary right" onmouseover="calc()">Kaydet</button>
</form>

<script>
    $(document).ready(function() {
           @for($i=1;$i<$co+1;$i++)
               // console.log($('#product_id_'+{{$i}}).val());
             //   console.log({{$v_array[$i]}});
               showVariant($('#product_id_'+{{$i}}).val(),{{$i}},{{$v_array[$i]}});
            @endfor
     //  $('#order_date').val('2021.10.21');
    });
    var co ={{$co}} ;

    function showVariant(product_id,count,selected){
        $.get( "{{url('orders/get-variants/')}}/"+product_id+"/"+selected, function( data ) {
            // console.log(data);
            if(data == 'no'){
                $( "#variant_id_"+count ).hide();
                $( "#variant_id_"+count ).val();
                $("#qty_"+count).prop('disabled', false);
            }else{
                $( "#variant_id_"+count ).show();
                $( "#variant_id_"+count ).html( data );
                $("#variant_id_"+count).prop('disabled', false);
            }


            //  alert( "Load was performed." );
        });


    }

    function variantSelected(count){
        if($('#variant_id_'+count).val()==''){
            $("#qty_"+count).prop('disabled', true);
        }else{
            $("#qty_"+count).prop('disabled', false);
        }

    }

    function addDiv(){
        calc();
        $.get( "{{url('orders/additional-product/')}}/"+co, function( data ) {
            // console.log(data);
            $('#additional').append(data);

            //  alert( "Load was performed." );
        });


        co++;
    }

    function checkStatus(){
        if($('#status').val()==2){
            $('#invoice_div').show();
        }else{
            $('#invoice_div').hide();
        }
    }

    function calc(){ /// adds selected items to product_list
        var product_list ="";
        //  var variant_list ="";
        // var qty_list ="";
        var j = 0;
        for(i=1;i<co+1;i++){
            if($('#product_id_'+i).val()!='' && ($('#qty_'+i).val()!='')){
                if($('#variant_id_'+i).val()!=''){
                    product_list+=$('#product_id_'+i).val()+"x"+$('#variant_id_'+i).val()+"x"+$('#qty_'+i).val()+"@";
                }else{
                    product_list+=$('#product_id_'+i).val()+"x"+$('#variant_id_'+i).val()+"x"+$('#qty_'+i).val()+"@";
                }

            }

        }



        $('#product_list').val(product_list);
        //$('#variant_list').val(variant_list);
        // $('#qty_list').val(qty_list);
        //    console.log(qty_list)

        //  swal(""+co)
    }

    $('#update-order').submit(function (e) {
        e.preventDefault();
        calc();
        var formData = new FormData(this);
        var error = false;
        if ($('#provider_id').val() == '0') {
            $('#provider_id_error').html('<span style="color: red">Lütfen seçiniz</span>');
            error = true;
        } else {
            $('#provider_id_error').html('');
        }

        if ($('#status').val() == '0') {
            $('#status_error').html('<span style="color: red">Lütfen durum seçiniz</span>');
            error = true;
        } else {
            $('#status_error').html('');
        }

        if ($('#order_date').val() == '') {
            $('#order_date_error').html('<span style="color: red">Lütfen tarih seçiniz</span>');
            error = true;
        } else {
            $('#order_date_error').html('');
        }


        if ($('#order_id').val() == '') {
            $('#order_id_error').html('<span style="color: red">Lütfen sipariş no giriniz</span>');
            error = true;
        } else {
            $('#order_id_error').html('');
        }


        if($('#status').val()==2){
            if ($('#invoice_date').val() == '') {
                $('#invoice_date_error').html('<span style="color: red">Lütfen tarih seçiniz</span>');
                error = true;
            } else {
                $('#invoice_date_error').html('');
            }


            if ($('#invoice_id').val() == '') {
                $('#invoice_id_error').html('<span style="color: red">Lütfen sipariş no giriniz</span>');
                error = true;
            } else {
                $('#invoice_id_error').html('');
            }
        }////

        if ($('#customer_name').val() == '') {
            $('#customer_name_error').html('<span style="color: red">Lütfen isim giriniz</span>');
            error = true;
        } else {
            $('#customer_name_error').html('');
        }

        if ($('#customer_phone').val() == '') {
            $('#customer_phone_error').html('<span style="color: red">Lütfen telefon giriniz</span>');
            error = true;
        } else {
            $('#customer_phone_error').html('');
        }

        /*if ($('#customer_email').val() == '') {
            $('#customer_email_error').html('<span style="color: red">Lütfen eposta giriniz</span>');
            error = true;
        } else {
            $('#customer_email_error').html('');
        }*/



        if ($('#product_list').val() == '') {
            $('#select_error').html('<span style="color: red">Lütfen ürün seçiniz</span>');
            error = true;
        } else {
            $('#select_error').html('');
            //   $('#email_error').html('');

            /* $.get( "{{url('orders/check-products/')}}/"+$('#product_list').val(), function( data ) {
            if(data=='ok'){
                $('#select_error').html('')
            }else{
                var error = true;
                $('#select_error').html('<span style="color: red">'+data+'</span>');
            }
            console.log(data);*/

            // $( "#variant_id_"+count ).html( data );

            //  alert( "Load was performed." );
            //});
        }////product_select
        if ($('#amount').val() == '') {
            $('#amount_error').html('<span style="color: red">Lütfen tutar giriniz</span>');
            error = true;
        } else {

            if(Number.isInteger(parseInt($('#amount').val()))){
                $('#amount_error').html('');
            }else{
                $('#amount_error').html('<span style="color: red">Tutar tamsayı olmalıdır</span>');
                error = true;
            }
        }

        if(error){
            return false;
        }

        //   swal("ok");
        save(formData, '{{route('order-update-post')}}', '', 'btn-1','');
    });
</script>