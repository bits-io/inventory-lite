        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label">Dashboard</li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('app.dashboard.index') }}">Dashboard</a></li>
                            <!-- <li><a href="./index-2.html">Home 2</a></li> -->
                        </ul>
                    </li>
                    <li class="nav-label">Master</li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">Master Data</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('app.inventory.index') }}">Inventory</a></li>
                        </ul>
                    </li>
                    <li class="nav-label">Transaction</li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-screen-tablet menu-icon"></i><span class="nav-text">Transaction</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('app.purchase.index') }}">Purchace</a></li>
                            <li><a href="{{ route('app.sales.index') }}">Sales</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
