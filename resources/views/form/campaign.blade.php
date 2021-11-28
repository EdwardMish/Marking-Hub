<div class="ibox ">
    <div class="ibox-title">
        <h5>Create A New Campaign</h5>
    </div>
    <div class="ibox-content">
        <form action="{{ Route('saveCampaign') }}" method="post">
            @csrf
            @include('campaign.select-shop')
            @include('campaign.select-audience')
            @include('campaign.select-postcard')
            @include('campaign.create-code')
        </form>
    </div>
</div>
