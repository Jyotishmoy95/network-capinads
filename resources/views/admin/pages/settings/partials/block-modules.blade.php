<div class="tab-pane fade" id="block-modules" role="tabpanel">
    <label class="main-content-label my-auto">Block Particular Modules</label>
    <hr>
    <div class="d-flex">
        <div>
            Login Block
        </div>
        <div class="main-toggle-group-demo ml-4">
            <div class="main-toggle main-toggle-success {{ $settings->login_blocked ? 'on' : '' }}" data-id="login">
                <span></span>
            </div>
        </div>
    </div>
    <hr>
    <div class="d-flex">
        <div>
            Registration Block
        </div>
        <div class="main-toggle-group-demo ml-4">
            <div class="main-toggle main-toggle-success {{ $settings->registration_blocked ? 'on' : '' }}" data-id="registration">
                <span></span>
            </div>
        </div>
    </div>
    <hr>
    <div class="d-flex">
        <div>
            Activation Block
        </div>
        <div class="main-toggle-group-demo ml-4">
            <div class="main-toggle main-toggle-success {{ $settings->activation_blocked ? 'on' : '' }}" data-id="activation">
                <span></span>
            </div>
        </div>
    </div>
    <hr>
    <div class="d-flex">
        <div>
            Withdrawal Block
        </div>
        <div class="main-toggle-group-demo ml-4">
            <div class="main-toggle main-toggle-success {{ $settings->withdrawal_blocked ? 'on' : '' }}" data-id="withdrawal">
                <span></span>
            </div>
        </div>
    </div>
    <hr>
    <div class="d-flex">
        <div>
            Ad Block
        </div>
        <div class="main-toggle-group-demo ml-4">
            <div class="main-toggle main-toggle-success {{ $settings->ad_blocked ? 'on' : '' }}" data-id="ad">
                <span></span>
            </div>
        </div>
    </div>
</div>