<form class="form-horizontal form-label-left input_mask" id="update-product"
      action="#" method="post"
      enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" value="{{$product['id']}}">
    {{csrf_field()}}




    <div class="form-group">
        <label class="text-black font-w500 w-100">Ürün Adı:</label>

        <input type="text" value="{{$product['product_name']}}" placeholder="Ürün Adı" name="name" id="name" class="form-control form-control-lg">
        <div id="name_error"></div>

    </div>


    <div class="form-group">
        <label class="text-black font-w500 w-100">Ürün Kodu:</label>

        <input type="text" disabled="" value="{{ $product['code'] }}" placeholder="Ürün Kodu" name="code" id="code" class="form-control  form-control-lg">
        <div id="code_error"></div>

    </div>
    <div class="form-group">
        <label class="text-black font-w500 w-100">Açıklama:</label>

        <input type="text" value="{{$product['description']}}"
               maxlength="255"
               placeholder="Açıklama" name="description" id="description" class="form-control  form-control-lg">


    </div>




    <div class="form-group">
        <div class="col-md-12 my-auto">
            <button type="submit" class="btn btn-primary"
                    id="btn-1">Gönder</button>
            <img src="{{url('images/blue-hourglass.gif')}}" alt="" style="width: 50px;display: none"
                 id="btn-1-hourglass">
        </div>
    </div>

</form>