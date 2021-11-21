<table class="table table-bordered">
    <thead>
    <tr>
        <th>Design</th>
        <th>Project Id</th>
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
            <td>{{ $campaign->audienceSize }}</td>
            <td>{{ $campaign->stateName }}</td>
            @if ($campaign->deleted_at === null)
                <th><a href="{{ Route('stopCampaign', $campaign->project_id)}}">Stop</a></th>
            @else
                <th><a href="{{ Route('restartCampaign', $campaign->project_id)}}">Restart</a></th>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
