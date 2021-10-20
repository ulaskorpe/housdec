<div class="deznav">
    <div class="deznav-scroll">
        <a href="javascript:void(0)" onclick="showModal('{{route('order-create')}}','Sipariş Ekle')" class="add-menu-sidebar" data-toggle="modal" data-target="#newOrder">+ Yeni Ekle</a>
        <ul class="metismenu" id="menu">

            @if(!empty(Session::get('sudo')))
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-user"></i>
                    <span class="nav-text">Yöneticiler</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('admin-list')}}">Tüm Yöneticiler</a></li>


                </ul>
            </li>
            @endif
@if(false)
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Siparişler</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('order-list')}}">Tüm Siparişler</a></li>
                    <li><a href="{{route('order-create')}}">Sipariş Ekle</a></li>
                </ul>
            </li>
                @endif
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-television"></i>
                    <span class="nav-text">Stok Durumu</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('stock-list')}}">Stok Listesi</a></li>
                    @if(!empty($product_id))
                        @if(!empty($variant_id))
                    <li  style="display: none"><a href="{{route('stock-list',[$product_id,$variant_id])}}">Stok Listesi</a></li>
                            @else
                            <li  style="display: none"><a href="{{route('stock-list',[$product_id])}}">Stok Listesi</a></li>
                        @endif
                    @endif
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-controls-3"></i>
                    <span class="nav-text">Muhasebe</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="#">Faturalar</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-user"></i>
                    <span class="nav-text">Veri Yönetimi</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{route('product-list')}}">Ürünler</a></li>
                    <li><a href="{{route('provider-list')}}">Tedarikçiler</a></li>
                    <li><a href="{{route('customer-list')}}">Müşteriler</a></li>
                    @if(!empty($product_id))
                    @if(!empty($selected))
                        <li style="display: none"><a href="{{route('product-update',[$product_id,$selected])}}">Müşteriler</a></li>
                        @else
                        <li style="display: none"><a href="{{route('product-update',$product_id)}}">Müşteriler</a></li>

                        @endif
                        @endif
                </ul>
            </li>
        </ul>
        <div class="copyright">
            <p><strong>Porevak Sipariş Yönetimi</strong></p>
        </div>
    </div>
</div>
