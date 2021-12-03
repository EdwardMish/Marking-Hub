<div class="ibox ">
    <div class="ibox-title">
        <h5>Create A New Campaign</h5>
    </div>
    <div class="ibox-content">
        @foreach ($errors->all() as $error)
            {{ $error }}<br/>
        @endforeach
        <form action="{{ Route('saveCampaign') }}" method="post">
            @csrf
            @include('form.campaign.select-shop')
            @include('form.campaign.select-audience')
            @include('form.campaign.select-postcard')
            @include('form.campaign.limit-send')
            @include('form.campaign.create-code')
        </form>
    </div>
</div>
