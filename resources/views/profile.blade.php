
<form class="form-horizontal form-label-left input_mask" id="create-admin"
      action="{{route('admin-create-post')}}" method="post"
      enctype="multipart/form-data">
    {{csrf_field()}}




    <div class="form-group">
        <label class="text-black font-w500 w-100">E-posta :</label>

        <input type="text" value="{{$admin['email']}}" placeholder="E-posta"   name="email" id="email" class="form-control form-control-lg">
        <div id="email_error"></div>

    </div>

    <div class="form-group">
        <label class="text-black font-w500 w-100">Adı Soyadı:</label>

        <input type="text" value="{{$admin['name_surname']}}" placeholder="Adı Soyadı" name="name_surname" id="name_surname" class="form-control  form-control-lg">
        <div id="name_surname_error"></div>

    </div>

    <div class="form-group">
        <label class="text-black font-w500 w-100">Telefon:</label>

        <input type="text" value="{{$admin['phone']}}" placeholder="Telefon" name="phone" id="phone" class="form-control  form-control-lg">
        <div id="phone_error"></div>

    </div>



    <div class="form-group">
        <label class="text-black font-w500 w-100">Avatar:</label>
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

            @if($admin['avatar']!='')

                <img src="{{url($admin['avatar'])}}" width="120" alt="" id="avatar_img"
                     style="margin-top: 0px">
                <img id="target" width="120" style="display: none;">
            @else
                <img id="target" width="120" style="display: none;">
                <img id="avatar_img" width="120" style="display: none;">
            @endif

        </div>
    </div>




    <div class="form-group">
        <div class="custom-control custom-checkbox mb-3 checkbox-danger">
            <input type="checkbox" class="custom-control-input" @if($admin['active']) checked @endif id="active" name="active" value="13" >
            <label class="custom-control-label" for="active">Aktif</label>
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


    $('#create-admin').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var error = false;
        if ($('#name_surname').val() == '') {
            $('#name_surname_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');
            error = true;
        } else {
            $('#name_surname_error').html('');
        }





        if ($('#email').val() == '') {
            $('#email_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');

        } else {
            $.get("{{url('email-check-admin/')}}/" + $('#email').val()  , function (data) {
                //   swal(data);

                if (data != 'ok') {

                    $('#email').val('');
                    $('#email_error').html('<span style="color: red">' + data + '</span>');
                    error = true;
                } else {
                    $('#email_error').html('');


                    //function save(formData,route,formID,btn,modal_btn) {


                }
            });
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
        }else{

        save(formData, '{{route('profile-post')}}', '', 'btn-1','');
        }

    });
