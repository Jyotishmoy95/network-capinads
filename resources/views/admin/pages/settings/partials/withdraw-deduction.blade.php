<div class="tab-pane fade" id="withdraw" role="tabpanel">
    <div class="d-flex mb-4">
        <label class="main-content-label my-auto">Withdraw & Deduction Settings</label>
    </div>
    <hr>
    <div class="">
        <form id="withdraw-deduction-form" class="row">
            @csrf
            <div class="col-md-6">
                <div class="form-group">
                    <label for="minimum_withdraw">Minimum Withdraw</label>
                    <input type="number" name="minimum_withdraw" id="input-minimum_withdraw" value="{{ $settings->minimum_withdrawal }}" step="0.01" min="1" class="form-control" placeholder="Enter Minimum Withdraw">
                    <div class="invalid-feedback error" id="minimum_withdraw-error"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="maximum_withdraw">Maximum Withdraw</label>
                    <input type="number" name="maximum_withdraw" id="input-maximum_withdraw" value="{{ $settings->maximum_withdrawal }}" step="0.01" min="1" class="form-control" placeholder="Enter Maximum Withdraw">
                    <div class="invalid-feedback error" id="maximum_withdraw-error"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="deductions">Admin Charge Deductions</label>
                    <input type="number" name="deductions" id="input-deductions" step="0.01" min="0" class="form-control" value="{{ $settings->admin_charges }}" placeholder="Enter Admin Charge Deductions" required>
                    <div class="invalid-feedback error" id="deductions-error"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" id="submit-btn-withdraw" class="btn btn-primary float-right">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>