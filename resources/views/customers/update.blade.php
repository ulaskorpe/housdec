
<form class="form-horizontal form-label-left input_mask" id="create-customer"
      action="#" method="post"
      enctype="multipart/form-data">
    {{csrf_field()}}

    <input type="hidden" name="id" id="id" value="{{$customer['id']}}">


    <div class="form-group">
        <label class="text-black font-w500 w-100">Adı :</label>

        <input type="text" value="{{$customer['name']}}" placeholder="Adı" name="name" id="name" class="form-control form-control-lg">
        <div id="name_error"></div>

    </div>


    <div class="form-group">
        <label class="text-black font-w500 w-100">Adres:</label>

        <input type="text" value="{{$customer['address']}}" placeholder="Adres" name="address" id="address" class="form-control  form-control-lg">
        <div id="address_error"></div>

    </div>
    <div class="form-group">
        <label class="text-black font-w500 w-100">Telefon:</label>

        <input type="text" value="{{$customer['phone']}}" placeholder="Telefon" name="phone" id="phone" class="form-control  form-control-lg">
        <div id="phone_error"></div>

    </div>

    <div class="form-group">
        <label class="text-black font-w500 w-100">E-posta :</label>

        <input type="text" value="{{$customer['email']}}" placeholder="E-posta" name="email" id="email" class="form-control form-control-lg">
        <div id="email_error"></div>

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






    $('#create-customer').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var error = false;
        if ($('#name').val() == '') {
            $('#name_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');
            error = true;
        } else {
            $('#name_error').html('');
        }





        if ($('#email').val() == '') {
            $('#email_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');

        } else {
            $('#email_error').html('');
        }

        if ($('#phone').val() == '') {
            $('#phone_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');

        } else {
            $('#email_error').html('');
        }



        if(error){
            return false;
        }

        save(formData, '{{route('customer-update-post')}}', '', 'btn-1','');

    });