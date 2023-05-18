<div class="tab-pane fade" id="ad-setting" role="tabpanel">
    <label class="main-content-label my-auto">Ad Income Settings</label>
    <hr>
    <div class="">
        <form id="ad-income-settings-form" class="row">
            @csrf
            <div class="col-md-6">
                <div class="form-group">
                    <label for="credit_type">Income Credit Type</label>
                    <select name="credit_type" id="input-credit_type" class="form-control">
                        <option value="">Select Option</option>
                        <option @if($settings->income_credit_type == 'one') selected @endif value="one">After Viewing One Ad</option>
                        <option @if($settings->income_credit_type == 'all') selected @endif value="all">After Viewing All Ads</option>
                    </select>
                    <div class="invalid-feedback error" id="credit_type-error"></div>
                </div>
            </div>

            <!-- <div class="col-md-6">
                <div class="form-group">
                    <label for="self_income">Self Income</label>
                    <input type="number" name="self_income" id="input-self_income" value="{{ $settings->self_income }}" step="0.01" min="0" class="form-control" placeholder="Enter Self Income">
                    <div class="invalid-feedback error" id="self_income-error"></div>
                </div>
            </div> -->

            <!-- @for($i=0; $i < $ad_levels; $i++)

                @php 
                    $level_data = null;
                    foreach($ad_level_incomes as $level) {
                        if($level->level == $i+1) {
                            $level_data = $level;
                            break;
                        }
                    }
                @endphp

            <div class="col-md-6">
                <div class="form-group">
                    <label for="levels">Level {{ $i+1 }}</label>
                    <input type="number" name="levels[]" id="input-levels-{{ $i }}" value="{{ $level_data ? $level_data->amount : null }}" step="0.01" min="0" class="form-control" placeholder="Enter Level {{ $i+1 }} income">
                    <div class="invalid-feedback error" id="levels-{{ $i }}-error"></div>
                </div>
            </div>

            @endfor -->

            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" id="submit-btn-ad" class="btn btn-primary float-right">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>