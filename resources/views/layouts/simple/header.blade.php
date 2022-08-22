<header id="page-topbar">
    <div class="navbar-header justify-content-between">

        <div class="d-flex align-items-center">

            <div class="text-info cursor-pointer" style="margin-left: 15px;">
                <div class="dropdown d-none d-lg-inline-block ms-1 p-1">
                    <span>Balans</span>
                    <p style="margin-bottom: 0;">156656.55</p>
                </div>
            </div>
            <div class="text-primary cursor-pointer" style="margin-left: 15px;">
                <div class="dropdown d-none d-lg-inline-block ms-1 p-1">
                    <span>Foyda</span>
                    <p style="margin-bottom: 0;">156656.55</p>
                </div>
            </div>
            <div class="text-default cursor-pointer" style="margin-left: 15px;" data-bs-toggle="modal" data-bs-target="#currencies">
                <div class="dropdown d-none d-lg-inline-block ms-1 p-1">
                    <span>USD</span>
                    <p style="margin-bottom: 0;">1</p>
                </div>
                <div class="dropdown d-none d-lg-inline-block ms-1 p-1">
                    <span>UZS</span>
                    <p style="margin-bottom: 0;">11050</p>
                </div>
                <div class="dropdown d-none d-lg-inline-block ms-1 p-1">
                    <span>EUR</span>
                    <p style="margin-bottom: 0;">0.89</p>
                </div>
            </div>
        </div>
        @isset($header)
            <div>
                <h4>{{ $header }}</h4>
            </div>
        @endisset
        <div class="d-flex align-items-center">
            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="/assets/images/trade/buy.png" style="width: 2rem;" alt="">
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end" style="">
                    <div class="px-lg-2">
                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="/trade?type=cash">
                                    <img src="assets/images/trade/money.png" alt="Github">
                                    <span>Naqd savdo</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="/trade?type=loan">
                                    <img src="assets/images/trade/loan.png" alt="bitbucket">
                                    <span>Nasiya</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="/trade?type=installment">
                                    <img src="assets/images/trade/pay-day.png" alt="dribbble">
                                    <span>Muddatli to’lov</span>
                                </a>
                            </div>
                        </div>

                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="/income">
                                    <img src="/assets/images/trade/add.png" alt="dropbox">
                                    <span>Kirim</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="/transfer">
                                    <img src="assets/images/trade/goods.png" alt="mail_chimp">
                                    <span>O`tkazma</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="/return">
                                    <img src="assets/images/trade/return.png" alt="slack">
                                    <span>Maxsulot qaytish</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dropdown d-none d-lg-inline-block ms-1" style="margin-right: 5px;">
                <span>Sana</span>
                <p style="margin-bottom: 0;">{{ \Carbon\Carbon::now()->format('d.m.Y') }}
                </p>
            </div>

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="uil-minus-path"></i>
                </button>
            </div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                        id="page-header-notifications-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="uil-bell"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                     aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 font-size-16"> Xabarlar </h5>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                    </div>
                    <div class="p-2 border-top">
                        <div class="d-grid">
                            <a class="btn btn-sm btn-link font-size-14 text-center" href="/account">
                                <i class="uil-arrow-circle-right me-1"></i> Ko'rish
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block mr-5 ml-5">

                <div class="sun">
                    <input type="checkbox" class="form-check-input theme-choice" id="light-mode-switch" checked
                           style="display: none"/>
                    <label class="form-check-label btn header-item noti-icon waves-effect" for="light-mode-switch"><i
                            class="uil-sun" style="top: 20%; position: relative;"></i></label>
                </div>

                <div class="moon" style="display: none">
                    <input type="checkbox" class="form-check-input theme-choice" id="dark-mode-switch"
                           style="display: none"/>
                    <label class="form-check-label btn header-item noti-icon waves-effect" for="dark-mode-switch"><i
                            class="uil-moon" style="top: 20%; position: relative;"></i></label>
                </div>
                {{--<button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">--}}
                {{--<i class="uil-moon"></i>--}}
                {{--</button>--}}
            </div>

            @php($user = auth()->user())
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    <span class="d-none d-xl-inline-block ms-1 fw-medium font-size-15">{{ $user->name }}</span>
                    <i class="uil-angle-down d-none d-xl-inline-block font-size-15"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i> <span
                            class="align-middle">Выход</span></a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>


        </div>
    </div>
</header>
