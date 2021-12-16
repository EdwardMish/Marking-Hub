@extends('layouts.app', ['activePage' => 'design', 'titlePage' => __('Select A Postcard')])

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                @include('form.campaign')
            </div>
            <div class="col-lg-6 col-md-6">
                @include('campaign.calculator')
            </div>
        </div>
    </div>
    </div>
@endsection
