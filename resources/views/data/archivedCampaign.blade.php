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
    @foreach ($archivedCampaigns as $campaign)
        <tr>
            <td><img src="{{ $campaign->thumbnail_url }}"></td>
            <td>{{ $campaign->project_id }}</td>
            <td>{{ $campaign->shop_name }}</td>
            <td>{{ $campaign->audience_size }}</td>
            <td>{{ $campaign->state_name }}</td>
            @if ($campaign->deleted_at === null)
                <th><a href="{{ Route('stopCampaign', $campaign->project_id)}}">Stop</a></th>
            @else
                <th><a data-id="{{ Route('restartCampaign' , $campaign->project_id) }}" href="javascript:void(0)" class="restart-campaign">Restart</a></th>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>

@push('js')
    <script>
        $('.restart-campaign').on('click', function (result) {
            const postUrl = $(this).attr("data-id");

            $.ajax({
                method: "get",
                url: postUrl,
            }).done(function(result) {
                window.location.href = result.success['redirect'];
            }).fail(function(result) {
                $('#paymentModal').modal('show');
                $('#payment_shop_id').val(result.responseJSON.errors.campaign_id);
            });
        })
    </script>
@endpush
