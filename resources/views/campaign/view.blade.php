@extends('layouts.app', ['activePage' => 'design', 'titlePage' => __('Select A Postcard')])

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Your Campaigns</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Your Campaigns</h5>
                    </div>
                    <div class="ibox-content">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Design</th>
                                <th>Project Id</th>
                                <th>Audience Size</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($campaigns as $campaign)
                                <tr>
                                    <td><img src="{{ $campaign->thumbnail_url }}"></td>
                                    <td>{{ $campaign->project_id }}</td>
                                    <td>{{ $campaign->audienceSize }}</td>
                                    <td>{{ $campaign->stateName }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-4">
                @include('campaign.calculator')
            </div>
        </div>
    </div>
@endsection
