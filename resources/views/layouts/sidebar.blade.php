<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-primary">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
        <img src="{{url('public/assets/dist/img/AdminLTELogo.png')}}"
             alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Madmin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{url('public/assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{route('leads.index')}}" class="nav-link {{(Request::is('leads') || Request::is('home'))? 'active': ''}}">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>Leads</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('partners.index')}}" class="nav-link {{Request::is('partners')? 'active': ''}}">
                        <i class="nav-icon far fa-handshake"></i>
                        <p>Partners</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('communication.index')}}" class="nav-link {{Request::is('lead_communication')? 'active': ''}}">
                        <i class="nav-icon fas fa-pager"></i>
                        <p>Lead Communication</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('emailSent.index')}}" class="nav-link {{Request::is('email_sent')? 'active': ''}}">
                        <i class="nav-icon fas fa-paper-plane"></i>
                        <p>Email Sent</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('introduce.index')}}" class="nav-link {{Request::is('introduce')? 'active': ''}}">
                        <i class="nav-icon far fa-address-book"></i>
                        <p>Introduced</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('projects')}}" class="nav-link {{Request::is('projects')? 'active': ''}}">
                        <i class="nav-icon fas fa-project-diagram"></i>
                        <p>Projects</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('vendor')}}" class="nav-link {{Request::is('vendor')? 'active': ''}}">
                        <i class="nav-icon fab fa-intercom"></i>
                        <p>Vendor Request</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('customerRequest')}}" class="nav-link {{Request::is('customer_request')? 'active': ''}}">
                        <i class="nav-icon fas fa-user-secret"></i>
                        <p>Customer Request</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('user.index')}}" class="nav-link {{Request::is('users')? 'active': ''}}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{Request::is('settings/*')? 'menu-open': ''}}">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('category.index')}}" class="nav-link {{Request::is('settings/category')? 'active': ''}}">
                                <i class="fas fa-list-alt nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tags.index')}}" class="nav-link {{Request::is('settings/tags')? 'active': ''}}">
                                <i class="fas fa-tags nav-icon"></i>
                                <p>Tags</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('country.index')}}" class="nav-link {{Request::is('settings/country')? 'active': ''}}">
                                <i class="far fa-flag nav-icon"></i>
                                <p>Country</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('city.index')}}" class="nav-link {{Request::is('settings/city')? 'active': ''}}">
                                <i class="far fa-building nav-icon"></i>
                                <p>City</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('progress.index')}}" class="nav-link {{Request::is('settings/progress')? 'active': ''}}">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>Progress</p>
                            </a>
                        </li>
                    </ul>
                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
