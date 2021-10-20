
<form class="form-horizontal form-label-left input_mask" id="create-product"
      action="#" method="post"
      enctype="multipart/form-data">
    {{csrf_field()}}




    <div class="form-group">
        <label class="text-black font-w500 w-100">Ürün Adı:</label>

        <input type="text" value="" placeholder="Ürün Adı" name="name" id="name" class="form-control form-control-lg">
        <div id="name_error"></div>

    </div>


    <div class="form-group">
        <label class="text-black font-w500 w-100">Ürün Kodu:</label>

        <input type="text" value="{{$code}}" placeholder="Ürün Kodu" name="code" id="code" class="form-control  form-control-lg">
        <div id="code_error"></div>

    </div>
    <div class="form-group">
        <label class="text-black font-w500 w-100">Açıklama:</label>

        <input type="text" value="" placeholder="Açıklama" name="description" maxlength="255" id="description" class="form-control  form-control-lg">


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





    $('#create-product').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var error = false;
        if ($('#name').val() == '') {
            $('#name_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');
            error = true;
        } else {
            $('#name_error').html('');
        }




        if ($('#code').val() == '') {
            $('#code_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');

        } else {
            $.get("{{url('products/product-code-check/')}}/" + $('#code').val()  , function (data) {
                //   swal(data);

                if (data != 'ok') {

                    $('#code').val('');
                    $('#code_error').html('<span style="color: red">' + data + '</span>');
                    error = true;
                } else {
                    $('#code_error').html('');




                }
            });
        }





        if(error){
            return false;
        }

        save(formData, '{{route('product-create-post')}}', '', 'btn-1','');

    });

    </script>