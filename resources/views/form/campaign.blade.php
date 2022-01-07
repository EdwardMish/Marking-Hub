<<<<<<< HEAD
=======
@foreach ($errors->all() as $error)
    {{ $error }}<br/>
@endforeach
>>>>>>> new-design
<form action="{{ Route('saveCampaign') }}" method="post" name="campaign">
    @csrf
    @include('form.campaign.select-shop')
    @include('form.campaign.select-audience')
    @include('form.campaign.select-postcard')
    @include('form.campaign.create-code')
</form>
<<<<<<< HEAD
=======
@include('form.payment')
>>>>>>> new-design

@push('js')
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}" defer></script>
    <script>
        $('#submitCampaign').on('click', function (result) {
            $('.ibox').children('.ibox-content').toggleClass('sk-loading');
            var shopId = $('select[name="shop_id"]').val();
<<<<<<< HEAD
            $('#submitCampaign').prop("disabled",true);
=======
>>>>>>> new-design
            $.ajax({
                method: "post",
                url: "{{ Route('saveCampaign') }}",
                data: $("form").serialize()
            }).done(function(result) {
                $('.ibox').children('.ibox-content').toggleClass('sk-loading');
                window.location.href = result.success['redirect'];
            }).fail(function(result) {
<<<<<<< HEAD
                let obj = result.responseJSON.errors;
                let arr = Object.keys(obj).map(function (key) { return obj[key]; });

                //Check if it failed due to payment
                if (result.status == 402) {
                    $('#paymentModal').modal('show');
                    $('#payment_shop_id').val(result.responseJSON.errors.campaign_id);
                } else {
                    swal({
                        title: "Form input error",
                        text: arr,
                        icon: "error",
                        confirmButtonColor: "#DD6B55",
                    });
                }
                $('#submitCampaign').prop("disabled",false);
=======
                // $('#paymentModal').show();
                let obj = result.responseJSON.errors;

                let arr = Object.keys(obj).map(function (key) { return obj[key]; });

                swal({
                    title: "Form input error",
                    text: arr,
                    icon: "error",
                    confirmButtonColor: "#DD6B55",
                });

>>>>>>> new-design
                $('.ibox').children('.ibox-content').toggleClass('sk-loading');
            });
        })
    </script>
@endpush

@push('css')
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endpush
