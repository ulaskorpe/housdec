
<form class="form-horizontal form-label-left input_mask" id="update-variant"
      action="#" method="post"
      enctype="multipart/form-data">
    {{csrf_field()}}


    <input type="hidden" value="{{$variant['id']}}"   name="id" id="id" >
    <input type="hidden" value="{{$variant->product()->first()->id}}"   name="product_id" id="product_id" >

    <div class="form-group">
        <label class="text-black font-w500 w-100">Ürün Adı:</label>
{{$variant->product()->first()->product_name}}

    </div>






    <div class="form-group">
        <label class="text-black font-w500 w-100">Varyant:</label>

        <input type="text" value="{{$variant['variant']}}" placeholder="Varyant" name="variant" id="variant" class="form-control  form-control-lg">
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





    $('#update-variant').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var error = false;


        if ($('#variant').val() == '') {
            $('#variant_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');
            error = true;
        } else {
            $.get("{{url('products/variant-check/')}}/{{$variant->product()->first()->id}}" +"/"+ $('#variant').val()+"/{{$variant['id']}}"  , function (data) {

                if (data != 'ok') {

                    $('#variant').val('');
                    $('#variant_error').html('<span style="color: red">' + data + '</span>');
                    error = true;
                } else {
                    $('#variant_error').html('');
                }
            });
        }




//console.log("{{url('products/variant-check/')}}/{{$variant->product()->first()->id}}" +"/"+ $('#variant').val()+"/{{$variant['id']}}");
        if(error){
            return false;
        }

        save(formData, '{{route('variant-update-post')}}', '', 'btn-1','');
    });

</script>