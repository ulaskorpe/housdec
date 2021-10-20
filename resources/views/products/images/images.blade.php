<div class="card">
    <div class="card-header">
        <h4 class="card-title">Tüm Resimler</h4>
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex">

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newOrder"
                        onclick="showModal('{{route('image-create',$product_id)}}','Ürün Resmi Ekle')">

                    <i class="fa fa-plus "></i> Ürün Resmi Ekle
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table id="example4" class="display min-w850">
                <thead>
                <tr>


                    <th>Resim</th>
                    <th>Varyant</th>

                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($images  as $image)
                    <tr>

                        <td><img src="{{url($image['thumb'])}}" alt=""></td>
                        <td width="50%">
                            @if($image['variant_id']>0)
                                {{$image->variant->variant}}
                            @endif
                        </td>
                        <td>

                            <select name="order{{$image['id']}}" id="order{{$image['id']}}"
                                    onchange="imageOrder('{{$image['id']}}',this.value)" style="margin-right: 20px">
                                @for($i=1;$i<($img_count+1);$i++)
                                    <option value="{{$i}}" @if($image['count']==$i) selected @endif> {{$i}}</option>
                                @endfor

                            </select>
                            <a href="#" onclick="deleteImg('{{$image['id']}}')"
                               class="btn btn-danger shadow btn-xs sharp" data-toggle="modal"
                               data-target=".bd-example-modal-sm"><i class="fa fa-trash "></i></a>

                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>