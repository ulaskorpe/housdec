@extends('main_template')


@section('main')
    <div class="row">
        <div class="col-xl-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center pt-15">
                        <div>
                            <p class="fs-18 mb-1">Toplam Sipariş Adedi</p>
                            <span class="fs-35 text-black font-w600">{{$total_order}}
					                    </span>
                        </div>
                        <span class="mr-4">
					                    <svg width="51" height="52" viewBox="0 0 51 52" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M25.5 43C34.8888 43 42.5 35.3888 42.5 26C42.5 16.6112 34.8888 9 25.5 9C16.1112 9 8.5 16.6112 8.5 26C8.5 35.3888 16.1112 43 25.5 43ZM25.5 51.5C39.5833 51.5 51 40.0833 51 26C51 11.9167 39.5833 0.5 25.5 0.5C11.4167 0.5 0 11.9167 0 26C0 40.0833 11.4167 51.5 25.5 51.5Z"
                                                  fill="white" fill-opacity="0.18"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M33.9997 1.95836C31.9058 1.21807 29.72 0.75304 27.4976 0.578384C26.3965 0.491843 25.4997 1.39543 25.4997 2.5V6.86605C25.4997 7.97062 26.3981 8.854 27.4951 8.98264C29.8644 9.26046 32.1572 10.031 34.223 11.253C36.8645 12.8155 39.0379 15.0589 40.5159 17.7486C41.9939 20.4384 42.7223 23.4757 42.625 26.5433C42.5277 29.6108 41.6082 32.5959 39.9627 35.1866C38.3172 37.7772 36.006 39.8783 33.2707 41.2703C30.5355 42.6623 27.4766 43.294 24.4136 43.0995C21.3507 42.905 18.3963 41.8913 15.8591 40.1645C13.8749 38.814 12.2029 37.0662 10.9444 35.0397C10.3616 34.1013 9.1801 33.6636 8.18029 34.1331L4.2283 35.989C3.22848 36.4585 2.79178 37.6543 3.33818 38.6143C4.44093 40.5516 5.79093 42.3324 7.35106 43.9131C8.50759 45.0848 9.77958 46.1466 11.1519 47.0806C14.9279 49.6506 19.3249 51.1592 23.8834 51.4487C28.4418 51.7382 32.9943 50.798 37.0652 48.7264C41.136 46.6548 44.5756 43.5277 47.0246 39.6721C49.4736 35.8165 50.842 31.3739 50.9868 26.8085C51.1317 22.2432 50.0476 17.7228 47.8479 13.7197C45.6482 9.71663 42.4137 6.37787 38.4824 4.05236C37.0536 3.2072 35.5519 2.50715 33.9997 1.95836Z"
                                                  fill="#FE634E"/>
                                        </svg>
					                </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center pt-15">
                        <div>
                            <p class="fs-18 mb-1">Toplam Satış Tutarı</p>
                            <span class="fs-35 text-black font-w600">{{$total_amount}} ₺
                                        </span>
                        </div>
                        <span class="mr-4">
                                        <svg width="51" height="31" viewBox="0 0 51 31" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M49.3228 0.840214C50.7496 2.08096 50.9005 4.24349 49.6597 5.67035L34.6786 22.8987C32.284 25.6525 28.1505 26.0444 25.281 23.7898L19.529 19.2704C18.751 18.6591 17.6431 18.7086 16.9226 19.3866L5.77023 29.883C4.3933 31.1789 2.22651 31.1133 0.930578 29.7363C-0.365358 28.3594 -0.299697 26.1926 1.07723 24.8967L13.4828 13.2209C15.9494 10.8993 19.7428 10.7301 22.4063 12.8229L28.0152 17.2299C28.8533 17.8884 30.0607 17.774 30.7601 16.9696L44.4926 1.1772C45.7334 -0.249661 47.8959 -0.400534 49.3228 0.840214Z"
                                                  fill="#FE634E"/>
                                        </svg>
                                    </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tüm Siparişler</h4>
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex">
                            <button type="button" class="btn btn-outline-info mr-15" data-toggle="modal"
                                    data-target="#sticker"><i class="fa fa-barcode "></i> Sticker Yazdır
                            </button>
                            <a href="#">
                                <button type="button" class="btn btn-outline-primary mr-15"><i class="fa fa-print"></i>
                                    Fatura Yazdır
                                </button>
                            </a>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newOrder"
                                    onclick="showModal('{{route('order-create')}}','Sipariş Ekle')">

                                <i class="fa fa-plus "></i> Yeni Ekle
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <input type="text" id="checked_list" name="checked_list">
                        <table id="example4" class="display min-w850">
                            <thead>
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkAll" onclick="chekAll()" >
                                        <label class="custom-control-label" for="checkAll"></label>
                                    </div>
                                </th>

                                <th>Satıcı Site</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                                <th>Sipariş No</th>
                                <th>Müşteri Adı</th>
                                <th>Telefon</th>
                                <th class="min-with">Ürün Bilgileri</th>
                                <th>Sipariş Tutarı</th>
                                <th>Fatura Tarihi</th>
                                <th>Fatura No</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                   onclick="changeChecked()" value="13"
                                                   class="custom-control-input" id="check{{$order['id']}}"
                                                   name="check{{$order['id']}}">
                                            <label class="custom-control-label" for="check{{$order['id']}}"></label>
                                        </div>
                                    </td>

                                    <td>{{$order->provider()->first()->name}}</td>
                                    <td>
                                        <span class="badge badge-rounded {{$badges[$order['status']][0]}}">{{$badges[$order['status']][1]}}</span>


                                    </td>
                                    <td>{{$order['order_date']}}</td>
                                    <td>{{$order['order_id']}}</td>
                                    <td>{{$order['customer_name']}}</td>
                                    <td>{{$order['customer_phone']}}</td>
                                    <td class="lightgallery">

                                        @foreach($order->order_products as $order_product)
                                            @php

                                            @endphp
                                             @if( $order_product->variant_id >0)

                                            @else

                                            @endif
                                        <a href="images/DM01.jpg" data-exthumbimage="images/DM01.jpg"
                                           data-src="images/DM01.jpg">
                                            <img class="rounded-circle" width="35" src="images/DM01.jpg" alt="">
                                            <span>{{$order_product->product()->first()->product_name}} ({{$order_product['quantity']}})</span>
                                        </a>
                                        @endforeach


                                    </td>
                                    <td><strong>{{$order['amount']}}</strong></td>
                                    <td>{{$order['invoice_date']}}</td>
                                    <td>
                                        @if($order['invoice_id']>0)
                                        {{$order['invoice_id']}}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="javascript:void(0)" onclick="showModal('{{route('order-update',[$order['id']])}}','Sipariş Güncelle')"
                                               data-toggle="modal" data-target="#newOrder"
                                               class="btn btn-primary shadow btn-xs sharp mr-1">
                                                <i class="fa fa-pencil"></i></a>

                                            <a href="#" onclick="deleteOrder('{{$order['id']}}')"
                                               class="btn btn-danger shadow btn-xs sharp" data-toggle="modal"
                                               data-target=".bd-example-modal-sm"><i class="fa fa-trash "></i></a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>

        function deleteOrder(order_id){
            swal("Sipariş silinecek, Emin misiniz?", {
                buttons: ["İptal", "Evet"],
                dangerMode: true,
            }).then((value) => {
                if (value) {
                    //   console.log("{{url('orders/delete-order')}}/" + img_id);
                    $.get("{{url('orders/delete-order')}}/" + order_id, function (data) {
                        swal("" + data);
                        setTimeout(function () {
                            window.open('{{url('/')}}', '_self');

                        }, 2000);

                        //   console.log(user_id+":"+follower_id);


                    });


                }
            })
        }

        function chekAll(){
            let list ="";
            if( $('#checkAll').is(':checked')){
                @foreach($orders as $order)


                    //swal("yes"+order_id)
                    list += "x{{$order['id']}}";

                    //swal("no"+order_id)

                @endforeach
                     }

            $('#checked_list').val(list);
        }

        function changeChecked(){

            let list ="";
            let all = true;
            $('#checked_list').val(list);
            @foreach($orders as $order)

            if ($('#check{{$order['id']}}').is(':checked') ) {
                //swal("yes"+order_id)
                list += "x{{$order['id']}}";

                //swal("no"+order_id)
            }else{
                all = false;
            }
            @endforeach
            $('#checkAll').prop('checked', all);

        /*    var list= $('#checked_list').val();
            if ($('#check'+order_id).is(':checked')) {
                //swal("yes"+order_id)
                list += "x"+order_id;
            }else{
                list.toString();
                list.replace("x"+order_id,"");
                //swal("no"+order_id)
            }*/
            $('#checked_list').val(list);
        }
    </script>
    @endsection