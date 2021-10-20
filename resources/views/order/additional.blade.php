<div class="input-group sec">

    <div id="radius" class="input-group-prepend">
        <span class="input-group-text">{{$count}}. Ürün</span>
    </div>
    <select name="product_id_{{$count}}" class="default-select form-control" id="product_id_{{$count}}" onchange="showVariant(this.value,{{$count}})">
        <option value="0">Ürün </option>
        @foreach($products as $product)
            <option value="{{$product['id']}}">{{$product['product_name']}}</option>
        @endforeach

    </select>
    <select name="variant_id_{{$count}}" class="default-select form-control" id="variant_id_{{$count}}" disabled onchange="variantSelected({{$count}})">
        <option value="0">Varyant</option>
    </select>
    <input type="number" class="form-control" name="qty_{{$count}}" id="qty_{{$count}}" disabled>
    <div class="input-group-append" style="height: 38px">
        <span class="input-group-text" id="basic-addon2">adet</span>
    </div>
</div>