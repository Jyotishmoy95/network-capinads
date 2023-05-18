<script src="https://cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
<script>
    $(document).ready(function () {
        CKEDITOR.replace('welcome_letter', {
            customConfig: "{{ asset('js/editorConfig.js') }}"
        });

        /* Submit Welcome Letter Form */
        $('#welcome-letter').on('submit', function(event){
            event.preventDefault();
            $('#submit-btn-welcome').html(`<span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...`);
            $('#submit-btn-welcome').attr('disabled', 'disabled');
            $(".form-group>div.error").html("");
            $(".form-group>input.form-control").removeClass("is-invalid");

            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            $.ajax({
                url:"{{ route('admin.settings.updateWelcomeLetter') }}",
                method:"POST",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(data)
                {
                    Swal.fire({
                        text: 'Welcome Letter successfully updated',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false,
                    });
                    $('#submit-btn-welcome').html('Update');
                    $('#submit-btn-welcome').removeAttr('disabled');
                    $(".form-group>div.error").html("");
                    $(".form-group>input.form-control").removeClass("is-invalid");
                },
                error: function(xhr, textStatus, errorThrown) { 
                    let data = xhr.responseJSON;
                    Object.keys(data.errors).forEach(key => {

                        let error = data.errors[key];
                        let arr_err = key.split('.');   

                        if(arr_err[1]){
                            $(`#input-${arr_err[0]}-${arr_err[1]}`).addClass('is-invalid');
                            $(`#${arr_err[0]}-${arr_err[1]}-error`).html(error);
                        }else{
                            $(`#input-${key}`).addClass("is-invalid");
                            $(`#${key}-error`).html(data.errors[key]);
                        }
                    });
                    $('#submit-btn-welcome').html('Submit');
                    $('#submit-btn-welcome').removeAttr('disabled');
                }
            });
        });

    });
</script>