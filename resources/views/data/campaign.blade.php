<table class="table table-bordered">
    <thead>
    <tr>
        <th>Design</th>
        <th>Project Id</th>
        <th>Shop Name</th>
        <th>Audience Size</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($campaigns as $campaign)
        <tr>
            <td><img src="{{ $campaign->thumbnail_url }}"></td>
            <td>{{ $campaign->project_id }}</td>
            <td>{{ $campaign->shop_name }}</td>
            <td>{{ $campaign->audience_size }}</td>
            <td>{{ $campaign->state_name }}</td>
            @if ($campaign->deleted_at === null)
                <th><a href="{{ Route('stopCampaign', $campaign->project_id)}}">Stop</a></th>
            @else
                <th><a data-id="$campaign->project_id)" href="javascript:void(0)" class="restart-campaign">Restart</a></th>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
