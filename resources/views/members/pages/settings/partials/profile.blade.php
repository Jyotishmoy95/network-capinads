<div class="tab-pane fade show active" id="profile" role="tabpanel">
<div>
        <div class="d-flex mb-4">
            <label class="main-content-label my-auto">Change Profile Picture</label>
        </div>
        <div class="">
            <form id="change-profile-picture-form" class="row">
                @csrf
                <div class="col-12">
                    <div class="form-group">
                        <label for="photo">Select Profile Picture</label>
                        <input type="file" accept="image/*" name="photo" id="input-photo" class="form-control" required>
                        <div class="invalid-feedback error" id="photo-error"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" id="submit-btn-change-photo" class="btn btn-primary float-right">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr />
    <div>
        <div class="d-flex mb-4">
            <label class="main-content-label my-auto">Change Password</label>
        </div>
        <div class="">
            <form id="change-password-form" class="row">
                @csrf
                <div class="col-12">
                    <div class="form-group">
                        <label for="old_password">Old Password</label>
                        <input type="text" name="old_password" id="input-old_password" class="form-control" placeholder="Enter Old Password" required>
                        <div class="invalid-feedback error" id="old_password-error"></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="text" name="password" id="input-password" class="form-control" placeholder="Enter New Password">
                        <div class="invalid-feedback error" id="password-error"></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="text" name="password_confirmation" id="input-password_confirmation" class="form-control" placeholder="Confirm Password" required>
                        <div class="invalid-feedback error" id="password_confirmation-error"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" id="submit-btn-change-password" class="btn btn-primary float-right">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>