@extends('main_template')


@section('main')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Stok Hareketleri</h4>
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div class="d-flex">

                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newOrder"
                                    onclick="showModal('{{route('stock-create')}}','Stok Hareketi Ekle')">

                                <i class="fa fa-plus "></i> Stok Hareketi Ekle</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display min-w850">
                            <thead>
                            <tr>
                                <th>Fotoğraf</th>
                                <th>Ürün Adı/Kodu</th>
                                <th>Varyant</th>
                                <th>Hareket</th>
                                <th>Stok Girişi</th>
                                <th>Satış Adedi</th>
                                <th>Mevcut Stok</th>
                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($stocks as $stock)
                            <tr>

                                @if(!empty($stock['variant_id']))
                                    <td>
                                        @if(!empty($stock->variant()->first()->img_id))
                                            <img src="{{url($stock->variant()->first()->img()->first()->thumb)}}" alt="">
                                        @else
                                            @if(!empty($stock->product()->first()->img_id))
                                                <img src="{{url($stock->product()->first()->img()->first()->thumb)}}" alt="">

                                            @endif
                                        @endif

                                    </td>
                                    <td><a href="{{route('stock-list',[$stock->product()->first()->id,$stock->variant()->first()->id])}}">
                                        {{$stock->product()->first()->product_name}} /
                                        {{$stock->product()->first()->code}}
                                        </a>

                                    </td>
                                    <td> {{$stock->variant()->first()->variant}}</td>
                                    <td>
                                        @if($stock['incoming']>0)
                                            +{{$stock['incoming']}}
                                        @else
                                            -{{$stock['outgoing']}}
                                        @endif
                                    </td>
                                    <td> {{$stock->variant()->first()->incoming}}</td>
                                    <td> {{$stock->variant()->first()->outgoing}}</td>
                                    <td> {{$stock->variant()->first()->current}}</td>

                                    @else
                                    <td>
                                        @if(!empty($stock->product()->first()->img_id))
                                            <img src="{{url($stock->product()->first()->img()->first()->thumb)}}" alt="">

                                        @endif

                                    </td>
                                    <td>
                                        <a href="{{route('stock-list',[$stock->product()->first()->id])}}">
                                        {{$stock->product()->first()->product_name}} /
                                        {{$stock->product()->first()->code}}
                                        </a>
                                    </td>
                                    <td>-</td>
                                    <td>
                                        @if($stock['incoming']>0)
                                            +{{$stock['incoming']}}
                                        @else
                                            -{{$stock['outgoing']}}
                                        @endif
                                    </td>
                                    <td> {{$stock->product()->first()->incoming}}</td>
                                    <td> {{$stock->product()->first()->outgoing}}</td>
                                    <td> {{$stock->product()->first()->current}}</td>



                                    @endif






                                <td>
                                    <div class="d-flex">
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#editStock" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="btn btn-danger shadow btn-xs sharp" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="fa fa-trash "></i></a>
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
