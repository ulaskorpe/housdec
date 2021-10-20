@extends('main_template')


@section('main')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tüm Ürünler</h4>
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex">

                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newOrder"
                                    onclick="showModal('{{route('product-create')}}','Ürün Ekle')">

                                <i class="fa fa-plus "></i> Ürün Ekle</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="display min-w850">
                            <thead>
                            <tr>


                                <th>Ürün Adı</th>
                                <th>Ürün Kodu</th>
                                <th>Açıklama</th>

                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr>

                                    <td>{{$product['product_name']}}</td>
                                    <td>{{$product['code']}}</td>
                                    <td>{{substr($product['description'],0,20)}}</td>


                                    <td>
                                        <a href="javascript:void(0)" onclick="window.open('{{route('product-update',$product['id'])}}','_self')" class="btn btn-primary shadow btn-xs sharp mr-1">
                                            <i class="fa fa-pencil"></i></a>

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
