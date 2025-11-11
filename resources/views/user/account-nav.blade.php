<ul class="account-nav">
    <li><a href="{{ route('user.index') }}" class="menu-link menu-link_us-s">Bảng Điều Khiển</a></li>
    <li><a href="{{ route('user.orders') }}" class="menu-link menu-link_us-s">Đơn Hàng</a></li>
    <li><a href="{{ route('user.address')}}" class="menu-link menu-link_us-s">Địa Chỉ</a></li>
    <li><a href="account-details.html" class="menu-link menu-link_us-s">Chi Tiết Tài Khoản</a></li>
    <li><a href="{{ route('wishlist.index')}}" class="menu-link menu-link_us-s">Danh Sách Ưa Thích</a></li>
    <!-- Trong menu user dropdown -->
    <li>
        <a href="{{ route('user.my.reviews') }}" class="menu-link">
            <i class="fa fa-star"></i> Đánh giá của tôi
        </a>
      </li>

    <li>
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <a href="{{ route('logout') }}" class="menu-link menu-link_us-s"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng Xuất</a>
        </form>
    </li>
</ul>
