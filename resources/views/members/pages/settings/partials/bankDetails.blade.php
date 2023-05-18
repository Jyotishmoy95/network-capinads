<div class="tab-pane fade show" id="welcome" role="tabpanel">
    <div class="d-flex mb-4">
        <label class="main-content-label my-auto">Bank Details</label>
    </div>
    <div class="">
        <form id="bank-details-form" class="row">
            @csrf
            <div class="col-12">
                <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" name="bank_name" id="input-bank_name" value="{{ $bank_detail ? $bank_detail->bank_name : '' }}" class="form-control" placeholder="Enter Bank Name" required>
                    <div class="invalid-feedback error" id="bank_name-error"></div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="account_name">A/C Holder Name</label>
                    <input type="text" name="account_name" id="input-account_name" value="{{ $bank_detail ? $bank_detail->account_name : '' }}" class="form-control" placeholder="Enter A/C Holder Name">
                    <div class="invalid-feedback error" id="account_name-error"></div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="account_number">A/C Number</label>
                    <input type="number" name="account_number" id="input-account_number" value="{{ $bank_detail ? $bank_detail->account_number : '' }}" class="form-control" placeholder="Enter A/C Number">
                    <div class="invalid-feedback error" id="account_number-error"></div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="ifsc_code">IFSC Code</label>
                    <input type="text" name="ifsc_code" id="input-ifsc_code" value="{{ $bank_detail ? $bank_detail->ifsc_code : '' }}" class="form-control" placeholder="Enter IFSC Code" required>
                    <div class="invalid-feedback error" id="ifsc_code-error"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" id="submit-btn-bank-details" class="btn btn-primary float-right">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>