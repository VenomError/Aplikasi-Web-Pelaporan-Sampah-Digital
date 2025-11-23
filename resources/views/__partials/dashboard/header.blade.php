<div class="header">
    <div class="header-left active d-flex align-items-center">
        <a class="logo logo-normal text-decoration-none d-flex align-items-center text-center" href="#">
            <i class="ri-recycle-fill  text-primary me-2" style="font-size: 50px;"></i>
            <b class="fw-bold text-primary" style="font-size: 30px">RECYCLE</b>
        </a>
    </div>

    <!-- /Logo -->

    <a
        class="mobile_btn"
        id="mobile_btn"
        href="#sidebar"
    >
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <!-- Header Menu -->
    <ul class="nav user-menu">

        <!-- Search -->
        <li class="nav-item nav-searchinputs">

        </li>
        <!-- /Search -->

        <!-- Select Store -->
        <li class="nav-item dropdown has-arrow main-drop select-store-dropdown">

        </li>
        <!-- /Select Store -->

        <!-- Flag -->
        <li class="nav-item dropdown has-arrow flag-nav nav-item-box">

        </li>
        <!-- /Flag -->

        <li class="nav-item nav-item-box">

        </li>
        <li class="nav-item nav-item-box">

        </li>
        <!-- Notifications -->
        <li class="nav-item dropdown nav-item-box">
        </li>
        <!-- /Notifications -->

        <li class="nav-item nav-item-box">
        </li>
        <li class="nav-item dropdown has-arrow main-drop">
            <a
                class="dropdown-toggle nav-link userset"
                data-bs-toggle="dropdown"
                href="javascript:void(0);"
            >
                <span class="user-info ">
                    <span class="user-letter  rounded-circle">
                        <x-img
                            class="img-fluid  rounded-circle"
                            src="assets/img/profiles/avator1.jpg"
                            alt=""
                        />
                    </span>
                    <span class="user-detail">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">{{ auth()->user()->getRoleNames()->first() }}</span>
                    </span>
                </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilename">
                    <div class="profileset">
                        <div class="profilesets">
                            <h6>{{ auth()->user()->name }}</h6>
                            <h5>{{ auth()->user()->getRoleNames()->first() }}</h5>
                        </div>
                    </div>
                    <hr class="m-0">
                    <a class="dropdown-item" href="profile.html"> <i class="me-2" data-feather="user"></i> My
                        Profile</a>
                    <a class="dropdown-item" href="general-settings.html"><i class="me-2"
                            data-feather="settings"></i>Settings</a>
                    <hr class="m-0">
                    <a class="dropdown-item logout pb-0" href="{{ url('/logout') }}"><x-img
                            class="me-2"
                            src="assets/img/icons/log-out.svg"
                            alt="img"
                        />Logout</a>
                </div>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a
            class="nav-link dropdown-toggle"
            data-bs-toggle="dropdown"
            href="javascript:void(0);"
            aria-expanded="false"
        ><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.html">My Profile</a>
            <a class="dropdown-item" href="general-settings.html">Settings</a>
            <a class="dropdown-item" href="signin.html">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->
</div>
