<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    @if(!empty($title))
        <title>{{$title}}</title>
        @else
    <title>Porevak | Sipariş Yönetim Paneli</title>
    @endif
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('images/favicon.png')}}">
    <link rel="stylesheet" href="{{url('vendor/chartist/css/chartist.min.css')}}">
    <link rel="stylesheet" href="{{url('vendor/bootstrap/scss/bootstrap.css')}}">
    <link href="{{url('vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{url('vendor/lightgallery/css/lightgallery.min.css')}}" rel="stylesheet">
    <link href="{{url('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{url('vendor/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{url('css/style.css')}}" rel="stylesheet">
    <link href="{{url('css/custom.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('vendor/sweetalert2/dist/sweetalert2.min.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    @yield('css')
</head>