<div class="row row-sm">
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="card custom-card">
            <div class="card-body text-center">
                <div class="icon-service bg-primary-transparent rounded-circle text-primary">
                    <i class="fe fe-user"></i>
                </div>
                <p class="mb-1 text-muted">Total Members</p>
                <h3 class="mb-0">{{ $total_members }}</h3>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="card custom-card">
            <div class="card-body text-center">
                <div class="icon-service bg-secondary-transparent rounded-circle text-secondary">
                    <i class="fe fe-trending-up"></i>
                </div>
                <p class="mb-1 text-muted">Total Activations</p>
                <h3 class="mb-0">{{ '0' }}</h3>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="card custom-card">
            <div class="card-body text-center">
                <div class="icon-service bg-info-transparent rounded-circle text-info">
                    <i class="fe fe-dollar-sign"></i>
                </div>
                <p class="mb-1 text-muted">Deposit Wallet</p>
                <h3 class="mb-0"><span>{{ env('CURRENCY_SYMBOL') }}</span>{{ $hirarchyRow->wallet_3 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6">
        <div class="card custom-card">
            <div class="card-body text-center">
                <div class="icon-service bg-success-transparent rounded-circle text-success">
                    <i class="fe fe-shopping-cart"></i>
                </div>
                <p class="mb-1 text-muted">Earning Wallet</p>
                <h3 class="mb-0"><span>{{ env('CURRENCY_SYMBOL') }}</span>{{ $hirarchyRow->wallet_1 }}</h3>
            </div>
        </div>
    </div>
</div>