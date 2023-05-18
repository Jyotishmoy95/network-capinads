<div class="row row-sm">
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-order ">
                    <label class="main-content-label mb-3 pt-1">Total Members</label>
                    <h2 class="text-right card-item-icon card-icon">
                    <i class="mdi mdi-account-multiple icon-size float-left text-primary"></i><span class="font-weight-bold">{{ $totalUsers }}</span></h2>
                    <p class="mb-0 text-muted">Today's Joinings<span class="float-right">{{ $todayUsers }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-widget">
                    <label class="main-content-label mb-3 pt-1">Total Active Users</label>
                    <h2 class="text-right"><i class="mdi mdi-cube icon-size float-left text-primary"></i><span class="font-weight-bold">{{ $totalActivations }}</span></h2>
                    <p class="mb-0 text-muted">Today's Activations<span class="float-right">{{ $todayActivations }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-widget">
                    <label class="main-content-label mb-3 pt-1">Total Revenue</label>
                    <h2 class="text-right"><i class="icon-size mdi mdi-poll-box   float-left text-primary"></i><span class="font-weight-bold">{{ env('CURRENCY_SYMBOL').$totalRevenues }}</span></h2>
                    <p class="mb-0 text-muted">Today's Revenue<span class="float-right">{{ env('CURRENCY_SYMBOL').$todayRevenues }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-widget">
                    <label class="main-content-label mb-3 pt-1">Total Epins</label>
                    <h2 class="text-right"><i class="mdi mdi-cart icon-size float-left text-primary"></i><span class="font-weight-bold">{{ $totalE-Pins }}</span></h2>
                    <p class="mb-0 text-muted">E-Pins Created Today<span class="float-right">{{ $epinsCreatedToday }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-widget">
                    <label class="main-content-label mb-3 pt-1">Used E-Pins</label>
                    <h2 class="text-right"><i class="icon-size mdi mdi-poll-box   float-left text-primary"></i><span class="font-weight-bold">{{ $usedEpins }}</span></h2>
                    <p class="mb-0 text-muted">E-Pins Used Today<span class="float-right">{{ $epinsUsedToday }}</span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
        <div class="card custom-card">
            <div class="card-body">
                <div class="card-widget">
                    <label class="main-content-label mb-3 pt-1">Total Sales</label>
                    <h2 class="text-right"><i class="mdi mdi-cart icon-size float-left text-primary"></i><span class="font-weight-bold">46,486</span></h2>
                    <p class="mb-0 text-muted">Monthly Sales<span class="float-right">3,756</span></p>
                </div>
            </div>
        </div>
    </div>
</div>