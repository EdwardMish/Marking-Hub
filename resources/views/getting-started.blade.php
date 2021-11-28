@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <h3>
                    Automated Retargeting
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox">
                    <div class="ibox-title">
                        How It Works
                    </div>
                    <div class="ibox-content">
                        <p>
                            We take your site visitors' IP addresses and determining their physical home address so you can send
                            them targeted direct mail within 48 - 72 hours of their web visit.
                        </p>

                        <iframe width="90%" height="500px"
                                src="https://www.youtube.com/embed/8TjQDK5_1cU">
                        </iframe>
                        <div style="padding: 20px 10px 0px 0px">
                            <input type="button" class="btn-primary btn" onclick="location.href='{{ Route('viewCampaigns') }}'" value="Create My Campaign">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-4">
                @include('campaign.calculator')
            </div>
        </div>
    </div>
@endsection
