<div class="row row-sm">
    <div class="col-sm-6 col-md-6 col-lg-4">
        <div class="card custom-card">
            <div class="card-body text-center">
                <div class="icon-service bg-primary-transparent rounded-circle text-primary">
                    <i class="fe fe-user"></i>
                </div>
                <p class="mb-1 text-muted">Total Members</p>
                <h3 class="mb-0">{{ $totalUsers }}</h3>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4">
        <div class="card custom-card">
            <div class="card-body text-center">
                <div class="icon-service bg-secondary-transparent rounded-circle text-secondary">
                    <i class="fe fe-trending-up"></i>
                </div>
                <p class="mb-1 text-muted">Total Activations</p>
                <h3 class="mb-0">{{ $totalActivations }}</h3>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4">
        <div class="card custom-card">
            <div class="card-body text-center">
                <div class="icon-service bg-info-transparent rounded-circle text-info">
                    <i class="fe fe-dollar-sign"></i>
                </div>
                <p class="mb-1 text-muted">Total Revenue</p>
                <h3 class="mb-0"><span>{{ env('CURRENCY_SYMBOL') }}</span>{{ $totalRevenues }}</h3>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4">
        <div class="card custom-card">
            <div class="card-body text-center">
                <div class="icon-service bg-success-transparent rounded-circle text-success">
                    <i class="fe fe-shopping-cart"></i>
                </div>
                <p class="mb-1 text-muted">Total Orders</p>
                <h3 class="mb-0">35,897</h3>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4">
        <div class="card custom-card">
            <div class="card-body text-center">
                <div class="icon-service bg-secondary-transparent rounded-circle text-secondary">
                    <i class="fe fe-trending-up"></i>
                </div>
                <p class="mb-1 text-muted">Total Sales</p>
                <h3 class="mb-0">98,674</h3>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4">
        <div class="card custom-card">
            <div class="card-body text-center">
                <div class="icon-service bg-info-transparent rounded-circle text-info">
                    <i class="fe fe-dollar-sign"></i>
                </div>
                <p class="mb-1 text-muted">Total Profits</p>
                <h3 class="mb-0"><span>$</span>45,078</h3>
            </div>
        </div>
    </div>
</div>