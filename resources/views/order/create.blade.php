<link rel="stylesheet" href="{{url('vendor/bootstrap/scss/bootstrap.css')}}">

<form class="form-horizontal form-label-left input_mask" id="create-order"
      action="{{route('order-create-post')}}" method="post"
      enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="form-group">
        <label class="text-black font-w500 w-100">Satıcı Site</label>
        <select class="form-control default-select w-100" id="provider_id" name="provider_id">
            <option value="0">Seçiniz...</option>
            @foreach($providers as $provider)
                <option value="{{$provider['id']}}">{{$provider['name']}}</option>
                @endforeach
        </select>
        <div id="provider_id_error"></div>
    </div>

    <div class="form-group">
        <label class="text-black font-w500 w-100">Durum</label>
        <select class="form-control default-select w-100" id="status" name="status" onchange="checkStatus();">
            <option value="0">Seçiniz...</option>
            <option value="1">Hazırlanıyor</option>
            <option value="2">Tamamlandı</option>
            <option value="3">İptal Edildi</option>
        </select>
        <div id="status_error"></div>
    </div>



    <div class="form-group">
        <label class="text-black font-w500">Sipariş Tarihi</label>
        <input name="order_date" type="date" class="form-control" id="order_date">
        <div id="order_date_error"></div>
    </div>

    <div class="form-group">
        <label class="text-black font-w500">Sipariş No</label>
        <input name="order_id" id="order_id" type="text" class="form-control">
        <div id="order_id_error"></div>
    </div>

    <div id="invoice_div" style="display: none">

        <div class="form-group">
            <label class="text-black font-w500">Fatura Tarihi</label>
            <input name="invoice_date" type="date" class="form-control" id="invoice_date">
            <div id="invoice_date_error"></div>
        </div>

        <div class="form-group">
            <label class="text-black font-w500">Fatura No</label>
            <input name="invoice_id" id="invoice_id" type="text" class="form-control">
            <div id="invoice_id_error"></div>
        </div>


    </div>

    <div class="form-group">
        <label class="text-black font-w500">Müşteri Adı</label>
        <input name="customer_name" id="customer_name" type="text" class="form-control">
        <div id="customer_name_error"></div>
    </div>
    <div class="form-group">
        <label class="text-black font-w500">Müşteri Telefon</label>
        <input name="customer_phone" id="customer_phone" type="text" class="form-control">
        <div id="customer_phone_error"></div>
    </div>
    <div class="form-group">
        <label class="text-black font-w500">Müşteri Email</label>
        <input name="customer_email" id="customer_email" type="text" class="form-control">
        <div id="customer_email_error"></div>
    </div>


    <input type="hidden" name="product_list" id="product_list">

    <div class="input-group sec">
        <label class="text-black font-w500 w-100">Ürün Seçimi</label>
        <div id="radius" class="input-group-prepend">
            <span class="input-group-text">1. Ürün</span>
        </div>
        <select name="product_id_1" class="default-select form-control" id="product_id_1" onchange="showVariant(this.value,1)">
            <option value="0">Ürün </option>
            @foreach($products as $product)
                <option value="{{$product['id']}}">{{$product['product_name']}}</option>
                @endforeach

        </select>
        <div id="product_error"></div>
        <select name="variant_id_1" class="default-select form-control" id="variant_id_1" disabled onchange="variantSelected(1)">
            <option value="0">Varyant</option>
        </select>
        <input type="number" class="form-control" name="qty_1" id="qty_1" disabled>
        <div class="input-group-append" style="height: 38px">
            <span class="input-group-text" id="basic-addon2">adet</span>
        </div>
        <div id="qty_error"></div>
    </div>

    <div id="additional"></div>
    <div id="select_error"></div>
    <button type="button" class="btn btn-rounded btn-outline-success w-100 mt-15"
            value="AND" id="and-button" onclick="addDiv()"><i class="fa fa-plus"></i> Yeni Ürün Ekle</button>

    <br><br>

    <div class="input-group">
        <label class="text-black font-w500 w-100">Sipariş Tutarı</label>
        <input type="text" class="form-control" id="amount" name="amount">
        <div class="input-group-append">
            <span class="input-group-text ">TL</span>
        </div><br>
        <div id="amount_error" style="width: 100%"></div>
    </div>
    <br>
    <button type="submit" class="btn btn-primary right" onmouseover="calc()">Kaydet</button>
</form>

<script>

    var co =1 ;

    function showVariant(product_id,count){
        $.get( "{{url('orders/get-variants/')}}/"+product_id, function( data ) {
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

    $('#create-order').submit(function (e) {
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
        save(formData, '{{route('order-create-post')}}', '', 'btn-1','');
    });
</script>