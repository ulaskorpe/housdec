<script src="{{url('js/jquery-3.5.1.min.js')}}"></script>
<script src="{{url('js/custom.js')}}"></script>

<!-- Required vendors -->
<script src="{{url('vendor/global/global.min.js')}}"></script>
<script src="{{url('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>

<script src="{{url('js/custom.min.js')}}"></script>
<script src="{{url('js/deznav-init.js')}}"></script>
<!--
<script src="{{url('js/vendor/owl-carousel/owl.carousel.js')}}"></script>
<!-- Datatable
<script src="{{url('vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
-->
<script src="{{url('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('js/plugins-init/datatables.init.js')}}"></script>
<script src="{{url('js/sweetalert.min.js')}}"></script>

<script src="{{url('js/save.js')}}"></script>

<script src="{{url('vendor/lightgallery/js/lightgallery-all.min.js')}}"></script>

<script>


    $('.lightgallery').lightGallery({
        loop:true,
        thumbnail:true,
        exThumbImage: 'data-exthumbimage'
    });

    $(document).ready(function() {

        $.get( "{{route('get-pic')}}", function( data ) {
             $( "#avatar-admin" ).attr('src', data );
            //alert(data );
        });
    });
</script>

@yield('scripts')