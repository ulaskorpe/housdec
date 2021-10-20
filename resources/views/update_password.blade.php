
<form class="form-horizontal form-label-left input_mask" id="create-admin"
      action="{{route('admin-create-post')}}" method="post"
      enctype="multipart/form-data">
    {{csrf_field()}}




    <div class="form-group">
        <label class="text-black font-w500 w-100">Şifre :</label>

        <input type="password" value="" placeholder="Şifre"   name="pw" id="pw" class="form-control form-control-lg">
        <div id="password_error"></div>

    </div>
    <div class="form-group">
        <label class="text-black font-w500 w-100">Şifre Yeniden :</label>

        <input type="password" value="" placeholder="Şifre Yeniden"   name="pw2" id="pw2" class="form-control form-control-lg">
        <div id="password_error_2"></div>

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
        if ($('#pw').val() == '') {
            $('#password_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');
            error = true;
        } else {
            if($('#pw').val().length <6  ){
                $('#password_error').html('<span style="color: red">Şifreniz en az 6 karakter olmalıdır</span>');
                 error = true;
            }else{
            $('#password_error').html('');
            }
        }

        if ($('#pw').val() != $('#pw2').val()) {
            $('#password_error_2').html('<span style="color: red">Şifrenizi yeniden giriniz</span>');
            $('#pw2').val('');
            error = true;
        }else{
            $('#password_error_2').html('');
        }








        if(error){
            return false;
        }else{

            save(formData, '{{route('update-password-post')}}', '', 'btn-1','');
        }

    });
