@extends('main_template')

@section('css')
    <link rel="stylesheet" href="{{url('vendor/pickadate/themes/default.date.css')}}">
    @endsection
@section('main')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Ürün Güncelle ({{$product['product_name']}})</h4>
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex">

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link @if($selected==0) active @endif" data-toggle="tab" href="#info">Ürün Künye</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($selected==1) active @endif"  data-toggle="tab" href="#variants">Varyantlar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($selected==2) active @endif"  data-toggle="tab" href="#images">Resimler</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link @if($selected==3) active @endif" data-toggle="tab" href="#stocks">Stoklar</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade @if($selected==0) active show @endif" id="info" role="tabpanel">
                                        <div class="pt-4">
                                            @include('products.update_product_form');
                                        </div>
                                    </div>
                                    <div class="tab-pane fade @if($selected==1) active show @endif" id="variants" role="tabpanel">
                                        <div class="pt-4">
                                            @include('products.variants.variants');
                                        </div>
                                    </div>
                                    <div class="tab-pane fade @if($selected==2) active show @endif" id="images" role="tabpanel">
                                        <div class="pt-4">
                                            @include('products.images.images');
                                        </div>
                                    </div>

                                    <div class="tab-pane fade @if($selected==3) active show @endif" id="stocks" role="tabpanel">
                                        <div class="pt-4">
                                            @include('products.stock_list');
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('scripts')
    <script src="{{url('vendor/pickadate/picker.js')}}"></script>
    <script src="{{url('vendor/pickadate/picker.date.js')}}"></script>

    <script>

        function imageOrder(img_id,order){
            $.get("{{url('products/image-order')}}/" + img_id+"/"+order, function (data) {
                swal("" + data);
                setTimeout(function () {
                    window.open('{{url('products/update/'.$product_id.'/2')}}', '_self');

                }, 2000);

                //   console.log(user_id+":"+follower_id);


            });
        }

        $('#update-product').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var error = false;
            if ($('#name').val() == '') {
                $('#name_error').html('<span style="color: red">{{__('errors.this_field_is_required')}}</span>');
                error = true;
            } else {
                $('#name_error').html('');
            }

            if(error){
                return false;
            }

            save(formData, '{{route('product-update-post')}}', '', 'btn-1','');

        });


        function deleteImg(img_id){
            swal("Resim silinecek, Emin misiniz?", {
                buttons: ["İptal", "Evet"],
                dangerMode: true,
            }).then((value) => {
                if (value) {
                 //   console.log("{{url('products/image-delete')}}/" + img_id);
                    $.get("{{url('products/image-delete')}}/" + img_id, function (data) {
                        swal("" + data);
                        setTimeout(function () {
                            window.open('{{url('products/update/'.$product_id.'/2')}}', '_self');

                        }, 2000);

                        //   console.log(user_id+":"+follower_id);


                    });


                }
            })
        }
        function deleteStock(stock_id){
            swal("Stok hareketi silinecek, Emin misiniz?", {
                buttons: ["İptal", "Evet"],
                dangerMode: true,
            }).then((value) => {
                if (value) {

                    $.get("{{url('stocks/stock-delete')}}/" + stock_id, function (data) {
                        swal("" + data);
                        setTimeout(function () {
                            window.open('{{url('products/update/'.$product_id.'/3')}}', '_self');

                        }, 2000);

                        //   console.log(user_id+":"+follower_id);


                    });


                }
            })
        }
    </script>
@endsection
