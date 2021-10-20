<form class="form-horizontal form-label-left input_mask" id="create-stock"
      action="#" method="post"
      enctype="multipart/form-data">
    {{csrf_field()}}


    <div class="form-group">
        <label class="text-black font-w500 w-100">Ürün :</label>

        <select name="product_id" id="product_id" class="form-control  form-control-lg">
            <option value="">Seçiniz</option>
            @foreach($products as $product)
                <option value="{{$product['id']}}"
                        @if($product_id==$product['id']) selected @endif>{{$product['product_name']}}</option>
            @endforeach
        </select>
        <div id="product_error"></div>

    </div>

@if($variants_count  > 0)
    <div class="form-group">
        <label class="text-black font-w500 w-100">Varyant :</label>

        <select name="variant_id" id="variant_id" class="form-control  form-control-lg" onchange="getStock($('#product_id').val(),this.value)">
            <option value="">Seçiniz</option>
            @foreach($variants as $variant)
                <option value="{{$variant['id']}}">{{$variant['variant']}}</option>
            @endforeach
        </select>
        <div id="variant_error"></div>
        <input type="hidden" value="0" id="qty_check" name="qty_check">
    </div>

    @endif
    <div class="form-group">
        <label class="text-black font-w500">Tarih :</label>
        <input name="stock_date" id="stock_date" type="date" class="form-control" value="{{date('d.m.Y')}}">
        <div id="date_error"></div>
    </div>

    <div class="form-group">
        <label class="text-black font-w500">Miktar :</label>
        <input name="qty" id="qty" type="number" class="form-control" value="{{date('d.m.Y')}}">
        <div id="qty_error"></div>
    </div>
    <div class="form-group">

        <select name="going" id="going" class="form-control  form-control-lg">
            <option value="">Seçiniz</option>
            <option value="in">Giriş</option>
            <option value="out">Çıkış</option>

        </select>
        <div id="going_error"></div>
    </div>
    <div class="form-group">
        <div class="col-md-12 my-auto">
            <button type="submit" class="btn btn-primary"
                    id="btn-1">Gönder
            </button>
            <img src="{{url('images/blue-hourglass.gif')}}" alt="" style="width: 50px;display: none"
                 id="btn-1-hourglass">
        </div>
    </div>


</form>

<script>


    function getStock(product_id,variant_id){
        $.get("{{url('stocks/count-stock/')}}/" + product_id+"/"+variant_id, function (data) {

                $('#qty_check').val(data);

        });

    }

    $('#create-stock').submit(function (e) {

        e.preventDefault();
        var formData = new FormData(this);
        var error = false;
        if ($('#product_id').val() == '') {
            $('#product_error').html('<span style="color: red">Ürün Seçiniz</span>');
            error = true;
        } else {
            $('#product_error').html('');
        }

        @if($variants_count > 0)
        if ($('#variant_id').val() == '') {
            $('#variant_error').html('<span style="color: red">Lütfen seçiniz</span>');
            error = true;
        } else {

            $('#variant_error').html('');
        }

        @endif

        if ($('#stock_date').val() == '') {
            $('#date_error').html('<span style="color: red">Tarih seçiniz</span>');
            error = true;
        } else {
            $('#date_error').html('');
        }

        if ($('#qty').val() == '') {
            $('#qty_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');
            error = true;
        } else {

            if($('#qty').val()<1){
                $('#qty_error').html('<span style="color: red">Tam Sayı girmelisiniz</span>');
                error = true;
            }else{
                $('#qty_error').html('');
            }


        }


        if ($('#going').val() == '') {
            $('#going_error').html('<span style="color: red">Lütfen Hareket Tipi Seçiniz</span>');
            error = true;
        } else {

            if ($('#going').val() == 'out') {


                if(parseInt($('#qty_check').val()) < parseInt($('#qty').val())){
                   // alert( $('#qty_check').val()+" : "+$('#qty').val());
                    $('#qty_error').html('<span style="color: red">Stokta '+$('#qty_check').val()+' sayıda ürün mevcut</span>');
                    $('#qty').val($('#qty_check').val());
                    error = true;
                }

            }else{
                $('#going_error').html('');
            }

            if (error) {
                return false;

            }else{
                 save(formData, '{{route('stock-create-post')}}', '', 'btn-1', '');
            }

        }







    });

</script>