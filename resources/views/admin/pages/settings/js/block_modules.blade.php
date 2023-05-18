<script>
    $(".main-toggle").on("click",(function(){
        $(this).toggleClass("on");
        let id = $(this).data("id");
        let status;

        //Check if element has class "on"
        if ($(this).hasClass("on")) {
            status = 1;  
        } else {
            status = 0;
        }

        $.ajax({
            url: "{{ route('admin.settings.updateBlockedModules') }}",
            type: 'POST',
            data: {
                id,
                status,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                Swal.fire({
                    text: data.message,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                });
            },
            error: function(data) {
                Swal.fire({
                    text: 'Something went wrong! Refresh the page and try again.',
                    icon: 'error',
                    showConfirmButton: true,
                });
            }
        });

    }));
</script>