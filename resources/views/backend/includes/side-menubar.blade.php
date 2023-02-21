    <!-- ########## START: LEFT PANEL ########## -->
    <div class="br-logo"><a href="{{ route('admin.dashboard') }}"><span>[</span>bracket <i>plus</i><span>]</span></a>
    </div>
    <div class="br-sideleft sideleft-scrollbar">
        <ul class="br-sideleft-menu">

            <li class="br-menu-item">
                <a href="{{ route('admin.dashboard') }}" class="br-menu-link active">
                    <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
                    <span class="menu-item-label">Dashboard</span>
                </a>
            </li>

            <label class="sidebar-label pd-x-10 mg-t-25 mg-b-20 tx-info">Product Management</label>

            <li class="br-menu-item">
                <a href="#"
                    class="br-menu-link with-sub
            @if (Route::is('brand.manage') || Route::is('brand.create') || Route::is('brand.edit') || Route::is('brand.softdelete')) active @endif
            ">
                    <i class="menu-item-icon icon ion-ios-infinite-outline tx-20"></i>
                    <span class="menu-item-label">Brands</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="{{ route('brand.create') }}"
                            class="sub-link @if (Route::is('brand.create')) active @endif ">Add New Brand</a></li>
                    <li class="sub-item"><a href="{{ route('brand.manage') }}"
                            class="sub-link @if (Route::is('brand.manage')) active @endif ">Manage All Brands</a></li>
                    <li class="sub-item"><a href="{{ route('brand.softdelete') }}"
                            class="sub-link @if (Route::is('brand.softdelete')) active @endif ">Soft Deleted Brands</a>
                    </li>
                </ul>
            </li>

            <li class="br-menu-item">
                <a href="#"
                    class="br-menu-link with-sub
            @if (Route::is('category.manage') ||
                    Route::is('category.create') ||
                    Route::is('category.edit') ||
                    Route::is('category.softdelete')) active @endif
            ">
                    <i class="menu-item-icon icon ion-ios-list-outline tx-20"></i>
                    <span class="menu-item-label">Category</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="{{ route('category.create') }}"
                            class="sub-link @if (Route::is('category.create')) active @endif ">Add New Category</a></li>
                    <li class="sub-item"><a href="{{ route('category.manage') }}"
                            class="sub-link @if (Route::is('category.manage')) active @endif ">Manage All Categories</a>
                    </li>
                    <li class="sub-item"><a href="{{ route('category.softdelete') }}"
                            class="sub-link @if (Route::is('category.softdelete')) active @endif ">Soft Deleted
                            Categories</a></li>
                </ul>
            </li>

            <li class="br-menu-item">
                <a href="#"
                    class="br-menu-link with-sub
            @if (Route::is('product.manage') ||
                    Route::is('product.create') ||
                    Route::is('product.edit') ||
                    Route::is('product.softdelete')) active @endif
            ">
                    <i class="menu-item-icon icon ion-ios-box-outline tx-20"></i>
                    <span class="menu-item-label">Product</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="{{ route('product.create') }}"
                            class="sub-link @if (Route::is('product.create')) active @endif">Add New Product</a></li>
                    <li class="sub-item"><a href="{{ route('product.manage') }}"
                            class="sub-link @if (Route::is('product.manage')) active @endif">Manage All Products</a>
                    </li>
                    <li class="sub-item"><a href="{{ route('product.softdelete') }}"
                            class="sub-link @if (Route::is('product.softdelete')) active @endif">Soft Deleted Products</a>
                    </li>
                </ul>
            </li>

            <li class="br-menu-item">
                <a href="#" class="br-menu-link with-sub">
                    <i class="menu-item-icon icon ion-ios-pricetags-outline tx-20"></i>
                    <span class="menu-item-label">Coupon</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="card-dashboard.html" class="sub-link">Add New Coupon</a></li>
                    <li class="sub-item"><a href="card-social.html" class="sub-link">Manage All Coupons</a></li>
                </ul>
            </li>

            <label class="sidebar-label pd-x-10 mg-t-25 mg-b-20 tx-info">Order Management</label>

            <li class="br-menu-item">
                <a href="{{ route('order.manage') }}"
                    class="br-menu-link 
            @if (Route::is('order.manage') || Route::is('order.details') || Route::is('order.edit')) active @endif
            ">
                    <i class="menu-item-icon icon ion-ios-printer-outline tx-24"></i>
                    <span class="menu-item-label">Manage All Orders</span>
                </a>
            </li>

            <label class="sidebar-label pd-x-10 mg-t-25 mg-b-20 tx-info">Location Management</label>
            {{-- Country --}}
            <li class="br-menu-item">
                <a href="#"
                    class="br-menu-link with-sub
            @if (Route::is('country.manage') || Route::is('country.create') || Route::is('country.edit')) active @endif
            ">
                    <i class="menu-item-icon icon ion-ios-world-outline tx-20"></i>
                    <span class="menu-item-label">Country</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="{{ route('country.create') }}"
                            class="sub-link @if (Route::is('country.create')) active @endif ">Add New Country</a></li>
                    <li class="sub-item"><a href="{{ route('country.manage') }}"
                            class="sub-link @if (Route::is('country.manage')) active @endif ">Manage All Countries</a>
                    </li>
                </ul>
            </li>
            {{-- Division --}}
            <li class="br-menu-item">
                <a href="#"
                    class="br-menu-link with-sub
            @if (Route::is('division.manage') || Route::is('division.create') || Route::is('division.edit')) active @endif
            ">
                    <i class="menu-item-icon icon ion-ios-world-outline tx-20"></i>
                    <span class="menu-item-label">Division</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="{{ route('division.create') }}"
                            class="sub-link @if (Route::is('division.create')) active @endif ">Add New Division</a>
                    </li>
                    <li class="sub-item"><a href="{{ route('division.manage') }}"
                            class="sub-link @if (Route::is('division.manage')) active @endif ">Manage All Divisions</a>
                    </li>
                </ul>
            </li>
            {{-- District --}}
            <li class="br-menu-item">
                <a href="#"
                    class="br-menu-link with-sub
            @if (Route::is('district.manage') || Route::is('district.create') || Route::is('district.edit')) active @endif
            ">
                    <i class="menu-item-icon icon ion-ios-world-outline tx-20"></i>
                    <span class="menu-item-label">District</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="{{ route('district.create') }}"
                            class="sub-link @if (Route::is('district.create')) active @endif ">Add New District</a>
                    </li>
                    <li class="sub-item"><a href="{{ route('district.manage') }}"
                            class="sub-link @if (Route::is('district.manage')) active @endif ">Manage All
                            Districts</a></li>
                </ul>
            </li>

            <label class="sidebar-label pd-x-10 mg-t-25 mg-b-20 tx-info">Customer Management</label>

            <li class="br-menu-item">
                <a href="#"
                    class="br-menu-link with-sub 
            @if (Route::is('customer.manage') || Route::is('customer.create') || Route::is('customer.edit')) active @endif">
                    <i class="menu-item-icon icon ion-ios-people-outline tx-20"></i>
                    <span class="menu-item-label">Customer [CRM]</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="" class="sub-link">Add New Customer</a></li>
                    <li class="sub-item"><a href="{{ route('customer.manage') }}"
                            class="sub-link @if (Route::is('customer.manage')) active @endif">Manage All Customers</a>
                    </li>
                </ul>
            </li>

            <label class="sidebar-label pd-x-10 mg-t-25 mg-b-20 tx-info">Global Settings</label>

            {{-- Slider --}}
            <li class="br-menu-item">
                <a href="#"
                    class="br-menu-link with-sub
            @if (Route::is('setting.manage') || Route::is('setting.edit')) active @endif
            ">
                    <i class="menu-item-icon icon ion-ios-settings tx-20"></i>
                    <span class="menu-item-label">Web Settiings</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="{{ route('setting.manage') }}"
                            class="sub-link @if (Route::is('setting.manage')) active @endif ">Manage Settings</a>
                    </li>
                </ul>
            </li>

            {{-- Slider --}}
            <li class="br-menu-item">
                <a href="#"
                    class="br-menu-link with-sub
            @if (Route::is('slider.manage') || Route::is('slider.create') || Route::is('slider.edit')) active @endif
            ">
                    <i class="menu-item-icon icon ion-ios-settings tx-20"></i>
                    <span class="menu-item-label">Slider</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="{{ route('slider.create') }}"
                            class="sub-link @if (Route::is('slider.create')) active @endif ">Add New Slider</a></li>
                    <li class="sub-item"><a href="{{ route('slider.manage') }}"
                            class="sub-link @if (Route::is('slider.manage')) active @endif ">Manage All Sliders</a>
                    </li>
                </ul>
            </li>

            {{-- News Flash --}}
            <li class="br-menu-item">
                <a href="#"
                    class="br-menu-link with-sub
            @if (Route::is('flash.manage') || Route::is('flash.create') || Route::is('flash.edit')) active @endif
            ">
                    <i class="menu-item-icon icon ion-ios-settings tx-20"></i>
                    <span class="menu-item-label">News Flash</span>
                </a>
                <ul class="br-menu-sub">
                    <li class="sub-item"><a href="{{ route('flash.create') }}"
                            class="sub-link @if (Route::is('flash.create')) active @endif ">Add New Flash</a></li>
                    <li class="sub-item"><a href="{{ route('flash.manage') }}"
                            class="sub-link @if (Route::is('flash.manage')) active @endif ">Manage All Flashes</a>
                    </li>
                </ul>
            </li>

        </ul><!-- br-sideleft-menu -->

        <br>
    </div><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->
