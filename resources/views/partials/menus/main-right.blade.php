<ul>
    @guest
    <li><a href="{{ route('register') }}">Đăng kí</a></li>
    <li><a href="{{ route('login') }}">Đăng nhập</a></li>
    @else
    <li>
        <a href="{{ route('users.edit') }}">Tài khoản</a>
    </li>
	<li>
    <div class="dropdown">
		<span style="color: #e9e9e9;">Cửa hàng  <i class="fa fa-caret-down"></i></span>
		<div class="dropdown-content">
		<ul class="menu-store">
			<li><a href="{{ route('store.my-store')}}">Thông tin cửa hàng</a></li>
			<li><a href="{{ route('store.my-store')}}">Quản lý sản phẩm</a></li>
			<li><a href="{{ route('order.list')}}">Quản lý order</a></li>
			</ul>
  		</div>
	</div>
	</li>
    <li>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout
        </a>
    </li>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    @endguest
    <li><a href="{{ route('cart.index') }}">Cart
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
