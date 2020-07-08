@extends('layout')

@section('title', 'Shopping Cart')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="#">Trang chủ</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Giỏ hàng</span>
    @endcomponent

    <div class="cart-section container">
        <div>
            @if (session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session()->get('success_message') }}
                </div>
            @endif

            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- @if (Cart::count() > 0) --}}

            <h2>Giỏ hàng</h2>

            <div class="cart-table">
                @foreach ($products as $item)
                <div class="cart-table-row">
                    <input type="hidden" id="product_id" value="{{$item->id}}">
                    <div class="cart-table-row-left">
                        <a href="{{ route('shop.show', $item->slug) }}"><img src="{{ productImage($item->image) }}" alt="item" class="cart-table-img"></a>
                        <div class="cart-item-details">
                            <div class="cart-table-item"><a href="{{ route('shop.show', $item->slug) }}">{{ $item->name }}</a></div>
                            <div class="cart-table-description">{{ $item->details }}</div>
                        </div>
                    </div>
                    <div class="cart-table-row-right">
                        <div class="cart-table-actions">
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="cart-options">Xóa</button>
                            </form>

                            <form action="{{ route('cart.switchToSaveForLater', $item->id) }}" method="POST">
                                {{ csrf_field() }}

                                <button type="submit" class="cart-options">Để dành mua sau</button>
                            </form>
                        </div>
                        <div>
                            {{-- <select class="quantity" data-id="{{ $item->id }}" data-productQuantity="{{ $item->quantity }}">
                                @for ($i = 1; $i < 5 + 1 ; $i++)
                                    <option {{ $item->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select> --}}
                            <input type="number" name="quantity" min="1" id="quantity_{{$item->id}}" value="{{$item->quantity_cart}}"  style="width: 45px;" onchange="changeQuantity({{$item->id}})">
                        </div>
                        <div id="price_item_{{$item->id}}">{{ presentPrice($item->price) }}</div>
                    </div>
                </div> <!-- end cart-table-row -->
                @endforeach

            </div> <!-- end cart-table -->

            @if (! session()->has('coupon'))

                <a href="#" class="have-code">Mã giảm giá</a>

                <div class="have-code-container">
                    <form action="{{ route('coupon.store') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="text" name="coupon_code" id="coupon_code">
                        <button type="submit" class="button button-plain" style="width: 200px;">Áp dụng</button>
                    </form>
                </div> <!-- end have-code-container -->
            @endif

            <div class="cart-totals">
                <div class="cart-totals-left">
                    {{-- Shipping is free because we’re awesome like that. Also because that’s additional stuff I don’t feel like figuring out :). --}}
                </div>

                <div class="cart-totals-right">
                    <div>
                        Tạm tính <br>
                        @if (session()->has('coupon'))
                            Code ({{ session()->get('coupon')['name'] }})
                            <form action="{{ route('coupon.destroy') }}" method="POST" style="display:block">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                <button type="submit" style="font-size:14px;">Remove</button>
                            </form>
                            <hr>
                            {{-- New Subtotal <br> --}}
                        @endif
                        {{-- Tax ({{config('cart.tax')}}%)<br> --}}
                        <span class="cart-totals-total">Thành tiền</span>
                    </div>
                    <div class="cart-totals-subtotal">
                        {{ presentPrice($sub_total) }} <br>
                        @if (session()->has('coupon'))
                            -{{ presentPrice($discount) }} <br>&nbsp;<br>
                            <hr>
                            {{-- {{ presentPrice($newSubtotal) }} <br> --}}
                        @endif
                        {{-- {{ presentPrice($newTax) }} <br> --}}
                        <span class="cart-totals-total">{{ presentPrice($final_total) }}</span>
                    </div>
                </div>
            </div> <!-- end cart-totals -->

            <div class="cart-buttons">
                <a href="{{ route('shop.index') }}" class="button">Tiếp tục mua sắm</a>
                <a href="{{ route('checkout.index') }}" class="button-primary">Tiến hành đặt hàng</a>
            </div>

           {{--  @else

                <h3>No items in Cart!</h3>
                <div class="spacer"></div>
                <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
                <div class="spacer"></div>

            @endif --}}

            {{-- @if (Cart::instance('saveForLater')->count() > 0) --}}
            @if (count($saveForLater) > 0)
            <h2> Để dành mua sau</h2>

            <div class="saved-for-later cart-table">
                @foreach ($saveForLater as $item)
                <div class="cart-table-row">
                    <div class="cart-table-row-left">
                        <a href="{{ route('shop.show', $item->slug) }}"><img src="{{ productImage($item->image) }}" alt="item" class="cart-table-img"></a>
                        <div class="cart-item-details">
                            <div class="cart-table-item"><a href="{{ route('shop.show', $item->slug) }}">{{ $item->name }}</a></div>
                            <div class="cart-table-description">{{ $item->details }}</div>
                        </div>
                    </div>
                    <div class="cart-table-row-right">
                        <div class="cart-table-actions">
                            {{-- <form action="{{ route('saveForLater.destroy', $item->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="cart-options">Remove</button>
                            </form> --}}
                            <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="cart-options">Xóa</button>
                            </form>

                            <form action="{{ route('saveForLater.switchToCart', $item->id) }}" method="POST">
                                {{ csrf_field() }}

                                <button type="submit" class="cart-options">Thêm vào giỏ hàng</button>
                            </form>
                        </div>

                        <div>{{ presentPrice($item->price, $item->quantity_cart) }}</div>
                    </div>
                </div> <!-- end cart-table-row -->
                @endforeach

            </div> <!-- end saved-for-later -->

            @else

            <h3>Bạn không có sản phẩm để dành mua sau nào !</h3>

            @endif 

        </div>

    </div> <!-- end cart-section -->

    @include('partials.might-like')
    

@endsection

@section('extra-js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // (function(){
        //     const classname = document.querySelectorAll('.quantity')

        //     Array.from(classname).forEach(function(element) {
        //         element.addEventListener('change', function() {
        //             const id = element.getAttribute('data-id')
        //             const productQuantity = element.getAttribute('data-productQuantity')

        //             axios.patch(`/cart/${id}`, {
        //                 quantity: this.value,
        //                 productQuantity: productQuantity
        //             })
        //             .then(function (response) {
        //                 // console.log(response);
        //                 window.location.href = '{{ route('cart.index') }}'
        //             })
        //             .catch(function (error) {
        //                 // console.log(error);
        //                 window.location.href = '{{ route('cart.index') }}'
        //             });
        //         })
        //     })
        // })();
        $.ajaxSetup({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }

        });
        
        function changeQuantity(product_id) {
            var quantity = $("#quantity_"+product_id).val();
            $.ajax({
                url: "/quantity/cart",
                type: "POST",
                data: {
                    "product_id" : product_id,
                    "quantity" : quantity
                },
                success: function(response){
                    // var id="#price_item_" + product_id;
                    // $(id).html(response.data.price);
                    window.location.href = '{{ route('cart.index') }}';
                }});


        }
        

    </script>

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
