<div class="card">
    <div class="card-header">
        <h4 class="card-title">Stok Hareketleri</h4>
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex">

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newOrder"
                        onclick="showModal('{{route('stock-create',$product_id)}}','Stok Hareketi Ekle')">

                    <i class="fa fa-plus "></i> Stok Hareketi Ekle</button>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table id="example4" class="display min-w850">
                <thead>
                <tr>


                    <th>Tarih</th>
                    <th>Ürün</th>
                    <th>Varyant</th>
                    <th>Giriş/Çıkış</th>


                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($stocks as $stock)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($stock['date'])->format('d.m.Y')}}</td>
                        <td>{{$stock->product()->first()->product_name}}</td>
                        <td>
                            @if($stock['variant_id']>0)
                            {{$stock->variant()->first()->variant}}
                            @endif
                         </td>

                        <td >
                            @if($stock['incoming']>0)
                                +{{$stock['incoming']}}
                                @else
                                -{{$stock['outgoing']}}
                                @endif
                            </td>
                        <td>
                            <a href="#" onclick="deleteStock('{{$stock['id']}}')"
                               class="btn btn-danger shadow btn-xs sharp" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="fa fa-trash "></i></a>
                            </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div></div>