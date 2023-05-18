<div class="tab-pane fade show active" id="profile" role="tabpanel">
    <div class="d-flex mb-4">
        <label class="main-content-label my-auto">My Profile</label>
    </div>
    <div class="">
        <form id="" class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="input-name" value="{{ auth()->user()->name }}" readonly class="form-control" placeholder="Enter First Name" required>
                    <div class="invalid-feedback error" id="name-error"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="input-email" value="{{ auth()->user()->email }}" readonly class="form-control" placeholder="Enter Email">
                    <div class="invalid-feedback error" id="email-error"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="input-username" class="form-control" readonly value="{{ auth()->user()->username }}" placeholder="Enter Username" required>
                    <div class="invalid-feedback error" id="username-error"></div>
                </div>
            </div>
        </form>
    </div>
    <hr>
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