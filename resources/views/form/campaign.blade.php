<form action="{{ Route('saveCampaign') }}" method="post">
    @csrf
    @include('campaign.select-audience')
    @include('campaign.select-postcard')
    @include('campaign.create-code')

</form>
