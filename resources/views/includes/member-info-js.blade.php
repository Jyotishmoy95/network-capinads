<script>
    $(document).ready(function(){

        //get page url
        const page_url = window.location.pathname;

        $('#input-member_id').on('keyup', function(){
            let member_id = $(this).val();
            if(member_id !== '' && member_id.length >=7){
                $.ajax({
                    url: "{{ route('member.check') }}",
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'member_id': member_id
                    },
                    success: function(data){
                        if(data.status){
                            $('.member-info-input').addClass('text-success');
                            $('.member-info-input').removeClass('text-danger');

                            $('.member-info-input').html(`Name: ${data.member.full_name}`);

                            let btn = $('#submit-btn');
                            if(btn.length){
                                btn.removeAttr('disabled');
                            }

                        }else{
                            $('.member-info-input').addClass('text-danger');
                            $('.member-info-input').removeClass('text-success');
                            $('.member-info-input').html(data.message);

                            let btn = $('#submit-btn');
                            if(btn.length){
                                btn.attr('disabled', 'disabled');
                            }

                        }
                    }
                });
            }else{
                $('.member-info-input').removeClass('text-success');
                $('.member-info-input').removeClass('text-danger');
                $('.member-info-input').html('');

                let btn = $('#submit-btn');
                if(btn.length){
                    btn.attr('disabled', 'disabled');
                }
            }
        });
    });
</script>