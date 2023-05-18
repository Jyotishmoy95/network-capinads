<script>
    $(document).ready(function () {
    
        /* Submit Withdraw Deduction Form */
        $('#change-password-form').on('submit', function(event){
            event.preventDefault();
            $('#submit-btn-change-password').html(`<span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...`);
            $('#submit-btn-change-password').attr('disabled', 'disabled');
            $(".form-group>div.error").html("");
            $(".form-group>input.form-control").removeClass("is-invalid");

            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            $.ajax({
                url:"{{ route('admin.settings.updateProfilePassword') }}",
                method:"POST",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(data)
                {
                    Swal.fire({
                        text: 'Profile password successfully updated',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false,
                    });
                    $('#submit-btn-change-password').html('Update');
                    $('#submit-btn-change-password').removeAttr('disabled');
                    $(".form-group>div.error").html("");
                    $('#change-password-form')[0].reset();
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
                    $('#submit-btn-change-password').html('Update');
                    $('#submit-btn-change-password').removeAttr('disabled');
                }
            });
        });

    });
</script>