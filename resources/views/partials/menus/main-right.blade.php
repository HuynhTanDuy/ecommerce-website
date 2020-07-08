<ul>
    @guest
    <li><a style="color: #fdfdfd;" href="{{ route('register') }}">Đăng kí</a></li>
    <li><a style="color: #fdfdfd;" href="{{ route('login') }}">Đăng nhập</a></li>
    @else
    <li>
        <a style="color: #fdfdfd;" href="{{ route('users.edit') }}">Tài khoản</a>
    </li>
    @if (Auth::user()->role_id==4)
	<li style="cursor: default">
    <div class="dropdown">
		<span style="color: #fdfdfd;">Cửa hàng  <i class="fa fa-caret-down"></i></span>
		<div style="margin-left: -45px;" class="dropdown-content">
		<ul class="menu-store">
			<li><a href="{{ route('store.information')}}">Thông tin cửa hàng</a></li>
			<li><a href="{{ route('store.my-store')}}">Quản lý sản phẩm</a></li>
			<li><a href="{{ route('order.list')}}">Quản lý order</a></li>
			</ul>
  		</div>
	</div>
	</li>
    @else
    <li>
        <a style="color: #fdfdfd;" href="{{ route('store.index') }}">Đăng kí mở cửa hàng</a>
    </li>
    @endif
    <li>
        <a style="color: #fdfdfd;" href="{{ route('orders.index') }}">
            Lịch sử đặt hàng
        </a>
    </li>
    <li>
        <a style="color: #fdfdfd;" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Đăng xuất
        </a>
    </li>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    @endguest
    <li><a style="color: #fdfdfd;" href="{{ route('cart.index') }}">Giỏ hàng
    @if (Cart::instance('default')->count() > 0)
    <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
    @endif
    </a></li>
    {{-- @foreach($items as $menu_item)
        <li>
            <a href="{{ $menu_item->link() }}">
                {{ $menu_item->title }}
                @if ($menu_item->title === 'Cart')
                    @if (Cart::instance('default')->count() > 0)
                    <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
                    @endif
                @endif
            </a>
        </li>
    @endforeach --}}
</ul>
