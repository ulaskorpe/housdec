<div class="card">
    <div class="card-header">
        <h4 class="card-title">Tüm Varyantlar</h4>
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex">

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newOrder"
                        onclick="showModal('{{route('variant-create',$product_id)}}','Varyant Ekle')">

                    <i class="fa fa-plus "></i> Varyant Ekle</button>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table id="example4" class="display min-w850">
                <thead>
                <tr>


                    <th>Varyant</th>

                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($product->variants  as $variant)
                    <tr>

                        <td width="80%">

                            {{$variant['variant']}}</td>
                        <td>

                            <a href="javascript:void(0)" onclick="showModal('{{route('variant-update',$variant['id'])}}','Varyant Güncelle')" data-toggle="modal" data-target="#newOrder" class="btn btn-primary shadow btn-xs sharp mr-1">
                                <i class="fa fa-pencil"></i></a>
                              </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div></div>