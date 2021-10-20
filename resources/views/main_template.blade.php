<!DOCTYPE html>
<html lang="tr">
@include('partials.head')
<body>


@include('partials.preloader')
<div id="main-wrapper">

    @include('partials.nav_header')
    @include('partials.header')
    @include('partials.left_menu')

    <!-- Add Order -->

    <div class="modal fade" id="newOrder" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-1"></h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body-1">

                </div>
            </div>
        </div>
    </div>
    <div id="sticker" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sticker Yazdır</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div id="printMe">
                        <div class="modal-body">
                            <div class="container my-0">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul>
                                            <li>POREVAK (CARİ NO: 777166122)</li>
                                            <li class="mb-15">Murat Taşpınar</li>
                                            <li>Şirinevler Mh. Gaziler Sk. No:12/B<br>Bahçelievler / İstanbul</li>
                                            <li>5532265504</li>
                                        </ul>
                                        <ul>
                                            <li class="mb-15">Hilal Abuş</li>
                                            <li>Göztepe mh. metin sokak no:4 MEDİPOL MEGA ÜNİVERSİTE HASTANESİ BAĞCILAR 34160 /İstanbul</li>
                                            <li>5309714209</li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <ul>
                                            <li>POREVAK (CARİ NO: 777166122)</li>
                                            <li class="mb-15">Murat Taşpınar</li>
                                            <li>Şirinevler Mh. Gaziler Sk. No:12/B<br>Bahçelievler / İstanbul</li>
                                            <li>5532265504</li>
                                        </ul>
                                        <ul>
                                            <li class="mb-15">Çağrı Kütük</li>
                                            <li>Gümüşpala Mh. Seyisoğlu Sk. No:42/B Avcılar / İstanbul</li>
                                            <li>5309714209</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal">Kapat</button>
                        <button onclick="printDiv('printMe')" type="button" class="btn btn-primary">Yazdır</button>
                    </div>
                </div>
            </div>
        </div>
    <div class="content-body">
        <!-- row -->
        <div class="container-fluid">
        @yield('main')







        </div>
    </div>

    @include('partials.footer')

</div>
@include('partials.scripts')




</body>
</html>