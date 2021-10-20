@extends('main_template')


@section('main')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tüm Müşteriler</h4>
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex">


                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newOrder"
                                    onclick="showModal('{{route('customer-create')}}','Müşteri Ekle')">

                                <i class="fa fa-plus "></i> Müşteri Ekle</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="display min-w850">
                            <thead>
                            <tr>


                                <th>Müşteri Adı</th>
                                <th>Telefon</th>
                                <th>E-posta</th>

                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $customer)
                                <tr>

                                    <td>{{$customer['name']}}</td>
                                    <td>{{$customer['phone']}}</td>
                                    <td>{{$customer['email']}}</td>


                                    <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#newOrder"
                                                onclick="showModal('{{route('customer-update',$customer['id'])}}','Müşteri Güncelle')">Güncelle</button></td>
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
