@extends('layouts.app', ['activePage' => 'design', 'titlePage' => __('Select your audience')])

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Step 3: Set Your Rules</h5>
                    </div>

                    <form action="{{ Route('startCampaign', ['project_id' => $projectId]) }}" method="post">
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
                    </form>
                </div>
                @include('campaign.create-code')
            </div>
            <div class="col-lg-6 col-md-4">
                @include('campaign.calculator')
            </div>
        </div>
    </div>
@endsection
