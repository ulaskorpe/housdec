
<form class="form-horizontal form-label-left input_mask" id="create-provider"
      action="#" method="post"
      enctype="multipart/form-data">
    {{csrf_field()}}

    <input type="hidden" name="id" id="id" value="{{$provider['id']}}">


    <div class="form-group">
        <label class="text-black font-w500 w-100">Adı :</label>

        <input type="text" value="{{$provider['name']}}" placeholder="Adı" name="name" id="name" class="form-control form-control-lg">
        <div id="name_error"></div>

    </div>

    <div class="form-group">
        <label class="text-black font-w500 w-100">Yetkili Kişi :</label>

        <input type="text" value="{{$provider['contact_person']}}" placeholder="Yetkili Kişi" name="contact_person" id="contact_person" class="form-control form-control-lg">
        <div id="contact_person_error"></div>

    </div>
    <div class="form-group">
        <label class="text-black font-w500 w-100">Adres:</label>

        <input type="text" value="{{$provider['address']}}" placeholder="Adres" name="address" id="address" class="form-control  form-control-lg">
        <div id="address_error"></div>

    </div>
    <div class="form-group">
        <label class="text-black font-w500 w-100">Telefon:</label>

        <input type="text" value="{{$provider['phone']}}" placeholder="Telefon" name="phone" id="phone" class="form-control  form-control-lg">
        <div id="phone_error"></div>

    </div>

    <div class="form-group">
        <label class="text-black font-w500 w-100">E-posta :</label>

        <input type="text" value="{{$provider['email']}}" placeholder="E-posta" name="email" id="email" class="form-control form-control-lg">
        <div id="email_error"></div>

    </div>

    <div class="form-group">
        <label class="text-black font-w500 w-100">Logo:</label>
        <div class="input-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input"

                       placeholder="Avatar" name="avatar" id="avatar"
                       onchange="showImage('avatar','target','avatar_img')">
                <label class="custom-file-label">Dosya Seçin</label>

            </div><br>
            <div id="avatar_error" style="width: 100%;margin-top: 20px"></div>
        </div>


    </div>
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12"> </span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">

            @if($provider['logo']!='')

                <img src="{{url($provider['logo'])}}" width="120" alt="" id="avatar_img"
                     style="margin-top: 0px">
                <img id="target" width="120" style="display: none;">
            @else
                <img id="target" width="120" style="display: none;">
                <img id="avatar_img" width="120" style="display: none;">
            @endif

        </div>
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





    function showImage(img, target, hide_it) {


        $('#' + hide_it).hide();
        $('#' + img).show();

        var src = document.getElementById(img);
        var target = document.getElementById(target);
        var val = $('#' + img).val();
        var arr = val.split('\\');
        $.get("{{url('/check_image')}}/" + arr[arr.length - 1], function (data) {
            //alert(data);
            if (data === 'ok') {
                $('#avatar_error').html("");
                $('#target').show();
                var fr = new FileReader();
                fr.onload = function (e) {

                    var image = new Image();
                    image.src = e.target.result;

                    image.onload = function (e) {
                        // access image size here

                        //   swal(this.width+"x"+this.height);

                        //  $('#imgresizepreview, #profilepicturepreview').attr('src', this.src);
                    };


                    target.src = this.result;
                };
                fr.readAsDataURL(src.files[0]);
            } else {
                $('#avatar_error').html('<span style="color: red">{{__('errors.wrong_format')}}</span>');
                //swal("admin.image_wrong_format");
                $('#avatar').val('');
                $('#target' ).hide();
                $('#avatar_img' ).hide();


            }
        });


    }


    $('#create-provider').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var error = false;
        if ($('#name').val() == '') {
            $('#name_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');
            error = true;
        } else {
            $('#name_error').html('');
        }



        if ($('#contact_person').val() == '') {
            $('#contact_person_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');
            error = true;
        } else {
            $('#contact_person_error').html('');
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


        if ($('#avatar').val() != '') {

            var ext =   $('#avatar').val().split('.').pop();

            ext = ext.toLowerCase();
            if(ext!='jpg' && ext!='jpeg'){
                $('#avatar').val('');
                $('#avatar_error').html('<span style="color: red">Seçili dosya jpg olmalı</span>');
                error = true;
            }else{
                $('#avatar_error').html('');
            }

        }else{
            $('#avatar_error').html('');
        }
        if(error){
            return false;
        }

        save(formData, '{{route('provider-update-post')}}', '', 'btn-1','');

    });