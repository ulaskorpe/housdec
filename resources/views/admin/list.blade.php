@extends('main_template')


@section('main')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tüm Yöneticiler</h4>
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex">


                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newOrder"
                                    onclick="showModal('{{route('admin-create')}}','Yönetici Ekle')">

                                <i class="fa fa-plus "></i> Yeni Ekle</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example4" class="display min-w850">
                            <thead>
                            <tr>

                                <th>Resim</th>
                                <th>Adı Soyadı </th>
                                <th>Eposta</th>
                                <th>Telefon</th>
                                <th>Süper Admin</th>
                                <th>Aktif</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                           @foreach($admins as $admin)
                                <tr>
                                   <td>
                                       @if(!empty($admin['avatar']))
                                           <img src="{{$admin['avatar']}}" alt="" style="width: 150px">
                                        @endif
                                   </td>
                                   <td>{{$admin['name_surname']}}</td>
                                   <td>{{$admin['email']}}</td>
                                   <td>{{$admin['phone']}}</td>
                                   <td>
                                       @if(!empty($admin['active']))
                                        <b>EVET</b>
                                        @endif
                                    </td>
                                   <td>  @if(!empty($admin['sudo']))
                                           <b>EVET</b>
                                       @endif</td>
                                   <td>

       <div class="d-flex">
           <a href="javascript:void(0)" onclick="showModal('{{route('admin-update',$admin['id'])}}','Yönetici Güncelle')"  data-toggle="modal" data-target="#newOrder" class="btn btn-primary shadow btn-xs sharp mr-1">
               <i class="fa fa-pencil"></i></a>

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
