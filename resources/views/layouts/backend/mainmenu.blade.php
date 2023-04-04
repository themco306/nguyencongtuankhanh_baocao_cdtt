<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-brands fa-docker"></i>
                <p>
                    Sản phẩm
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('product.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tất cả sản phẩm</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh mục sản phẩm</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('brand.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thương hiệu</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-book-open"></i>
                <p>
                    Bài viết
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('topic.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Chủ đề bài viết</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('page.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Trang đơn</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('post.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tất cả bài viết</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-users"></i>
                <p>
                    Quản lí khách hàng
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('customer.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Khách hàng</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('order.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Đơn hàng</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('contact.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Liên hệ</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fa-solid fa-mountain-sun"></i>
                <p>
                    Giao diện
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('menu.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Menu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('slider.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Slider</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="" class="nav-link">
              <i class="fa-solid fa-user"></i>
                <p>
                    Người quản trị
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thành viên</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">

            <a href="{{ route('admin.logout') }}" class="nav-link">
                <i class="fa-solid fa-right-from-bracket text-danger"></i>
                <p class="text">Đăng xuất</p>
            </a>
        </li>
        <li class="nav-item">

        </li>

    </ul>
</nav>