@extends('layouts.app', ['activePage' => 'design', 'titlePage' => __('Select A Postcard')])

@section('content')

    @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    <div class="alert alert-info alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        A wonderful serenity has taken possession. <a class="alert-link" href="#">Alert Link</a>.
    </div>

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Campaigns</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    @if(!empty($campaigns) &&  count($campaigns) > 0)
                        <div class="col-lg-12">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5>Active Campaigns</h5>
                                </div>
                                <div class="ibox-content">
                                    @include('data.campaign')
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(!empty($archivedCampaigns) && count($archivedCampaigns) > 0)
                        <div class="col-lg-12">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h5>Archived Campaigns</h5>
                                </div>
                                <div class="ibox-content">
                                    @include('data.archivedCampaign')
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(!empty($availableShops) && count($availableShops) > 0)
                        <div class="col-lg-12">
                            @include('form.campaign')
                        </div>
                    @endif
                </div>
                @include('form.payment')
            </div>
            <div class="col-lg-6 col-md-4">
                @include('campaign.calculator')
            </div>
        </div>
    </div>

@endsection
