@extends('layouts.app', ['activePage' => 'design', 'titlePage' => __('Select your audience')])

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <form action="{{ Route('startCampaign', ['project_id' => $projectId]) }}" method="post">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Step 3: Set Your Rules</h5>
                    </div>
                        @csrf
                        <div class="ibox-content">

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Target Audience</th>
                                    <th>Audience Size</th>
                                    <th>Est. Address Match (30%)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($audienceSizes as $audienceSize)
                                    <tr>
                                        <td>
                                            <div class="i-checks"><label><input name="audience" type="radio"
                                                                                value="{{ $audienceSize->id }}"
                                                    @if ($audienceSize->id == 20)
                                                        checked="checked"
                                                    @endif
                                                    ><i></i> {{ $audienceSize->name }}</label>
                                            </div>
                                        </td>
                                        <td>50,000</td>
                                        <td>15,000</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <button class="btn btn-secondary btn-lg" name="submit"  value="save" type="submit">Save & Exit</button>
                            <button class="btn btn-primary btn-lg" name="submit" value="start" type="submit">Start Campaign</button>
                        </div>
                </div>
                @include('campaign.create-code')
            </div>
            </form>
            <div class="col-lg-6 col-md-4">
                @include('campaign.calculator')
            </div>
        </div>
    </div>
@endsection
