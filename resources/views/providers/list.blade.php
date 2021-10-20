@extends('main_template')


@section('main')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tüm Tedarikçiler</h4>
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex">


                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newOrder"
                                    onclick="showModal('{{route('provider-create')}}','Tedarikçi Ekle')">

                                <i class="fa fa-plus "></i> Yeni Ekle</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="display min-w850">
                            <thead>
                            <tr>

                                <th>Logo</th>
                                <th>Tedarikçi Adı</th>
                                <th>Yetkili Kişi</th>
                                <th>Telefon</th>
                                <th>E-posta</th>

                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($providers as $provider)
                                <tr>
                                    <td>
                                        @if(!empty($provider['logo']))
                                            <img src="{{$provider['logo']}}" alt="" style="width: 150px">
                                        @endif
                                    </td>
                                    <td>{{$provider['name']}}</td>
                                    <td>{{$provider['contact_person']}}</td>
                                    <td>{{$provider['phone']}}</td>
                                    <td>{{$provider['email']}}</td>


                                    <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#newOrder"
                                                onclick="showModal('{{route('provider-update',$provider['id'])}}','Tedarikçi Güncelle')">Güncelle</button></td>
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
