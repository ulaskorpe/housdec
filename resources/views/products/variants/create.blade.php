
<form class="form-horizontal form-label-left input_mask" id="create-variant"
      action="#" method="post"
      enctype="multipart/form-data">
    {{csrf_field()}}


    <input type="hidden" value="{{$product_id}}"   name="product_id" id="product_id" >

    <div class="form-group">
        <label class="text-black font-w500 w-100">Ürün Adı:</label>

        {{$product['product_name']}}
    </div>






    <div class="form-group">
        <label class="text-black font-w500 w-100">Varyant:</label>

        <input type="text" value="" placeholder="Varyant" name="variant" id="variant" class="form-control  form-control-lg">
        <div id="variant_error"></div>

    </div>




    <div class="form-group">
        <div class="col-md-12 my-auto">
            <button type="submit" class="btn btn-primary"
                    id="btn-1">Gönder</button>
            <img src="{{url('images/blue-hourglass.gif')}}" alt="" style="width: 50px;display: none"
                 id="btn-1-hourglass">
        </div>
    </div>

</form>

<script>





    $('#create-variant').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var error = false;


        if ($('#variant').val() == '') {
            $('#variant_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');
            error = true;
        } else {

            $.get("{{url('products/variant-check/')}}/{{$product_id}}"+"/" + $('#variant').val()  , function (data) {
               // swal(data);
                if (data != 'ok') {

                    $('#variant').val('');
                    $('#variant_error').html('<span style="color: red">' + data + '</span>');
                   error = true;
                } else {
                    $('#variant_error').html('');
                }
            });


        }





        if(error){
            return false;
        }


        save(formData, '{{route('variant-create-post')}}', '', 'btn-1','');
    });

</script>