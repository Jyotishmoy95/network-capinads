<div class="tab-pane fade" id="welcome" role="tabpanel">
    <label class="main-content-label my-auto">Welcome Letter</label>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <form id="welcome-letter">
                @csrf
                <div class="form-group">
                    <label for="welcome_letter">Welcome Letter Content</label>
                    <textarea class="form-control" id="input-welcome_letter" name="welcome_letter" rows="3" required>{{ $settings->welcome_letter }}</textarea>
                    <div class="invalid-feedback error" id="welcome_letter-error"></div>
                </div>
                <div class="form-group">
                    <button type="submit" id="submit-btn-welcome" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>