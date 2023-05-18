<div class="tab-pane fade show" id="documents" role="tabpanel">
    <div class="d-flex mb-4">
        <label class="main-content-label my-auto">Upload Documents</label>
    </div>
    <div class="">
        <form id="documents-form" class="row">
            @csrf
            <div class="col-12">
                <div class="form-group">
                    <label for="document_type">Document Type</label>
                    <select class="form-control select2" name="document_type" id="document_type">
                        <option value="">Select Document Type</option>
                        @foreach($document_types as $doc_type)
                            <option @if($document_details && $document_details->document_type == $doc_type) selected @endif value="{{ $doc_type }}">{{ ucwords($doc_type) }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback error" id="document_type-error"></div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="document_number">Document Number</label>
                    <input type="text" value="{{ $document_details && $document_details->document_number ? $document_details->document_number : '' }}" name="document_number" id="input-document_number" class="form-control" placeholder="Enter Document Number">
                    <div class="invalid-feedback error" id="document_number-error"></div>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="document_photo">Upload Document Photo (Max Size: 500KB)</label>
                    <input type="file" class="form-control" name="document_photo" id="input-document_photo">
                    <div class="invalid-feedback error" id="document_photo-error"></div>
                    @if($document_details && $document_details->document_photo)
                    <div>
                        <a href="{{ asset('uploads/documents/'.$document_details->document_photo) }}" target="_blank" class="btn btn-primary mt-2">View Document Photo</a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" id="submit-btn-documents" @if($document_details) disabled @endif class="btn btn-primary float-right">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>