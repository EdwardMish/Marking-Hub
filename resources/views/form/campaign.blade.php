<div class="ibox" id="campaign-form">
    <div class="ibox-title">
        <h5>Create A New Campaign</h5>
    </div>
    <div class="ibox-content">
        <div class="sk-spinner sk-spinner-double-bounce">
            <div class="sk-double-bounce1"></div>
            <div class="sk-double-bounce2"></div>
        </div>
        @foreach ($errors->all() as $error)
            {{ $error }}<br/>
        @endforeach
        <form action="{{ Route('saveCampaign') }}" method="post" name="campaign">
            @csrf
            @include('form.campaign.select-shop')
            @include('form.campaign.select-audience')
            @include('form.campaign.select-postcard')
            @include('form.campaign.limit-send')
            @include('form.campaign.create-code')
        </form>
    </div>
</div>
@include('form.payment')

@push('js')
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}" defer></script>
    <script>
        $('#submitCampaign').on('click', function (result) {
            $('#campaign-form').children('.ibox-content').toggleClass('sk-loading');
            var shopId = $('select[name="shop_id"]').val();
            $.ajax({
                method: "post",
                url: "{{ Route('saveCampaign') }}",
                data: $("form").serialize()
            }).done(function() {
                console.log('Done');
                $('#paymentModal').show();
                $('#campaign-form').children('.ibox-content').toggleClass('sk-loading');

            }).fail(function(result) {

                let obj = result.responseJSON.errors;

                let arr = Object.keys(obj).map(function (key) { return obj[key]; });

                swal({
                    title: "Form input error",
                    text: arr,
                    icon: "error",
                    confirmButtonColor: "#DD6B55",
                });

                $('#campaign-form').children('.ibox-content').toggleClass('sk-loading');
            });
        })
    </script>
@endpush

@push('css')
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endpush
