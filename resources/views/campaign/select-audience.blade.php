@extends('layouts.app', ['activePage' => 'design', 'titlePage' => __('Select your audience')])

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-6">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Step 3: Set Your Rules</h5>
                </div>
                <form action="{{ Route('startCampaign', ['project_id' => $projectId]) }}">
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
                            <tr>
                                <td>
                                    <div class="i-checks"><label><input name="audience" type="checkbox"
                                                                        value="1"><i></i> All Site Vistors</label></div>
                                </td>
                                <td>50,000</td>
                                <td>15,000</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="i-checks"><label> <input name="audience" type="checkbox" value="2">
                                            <i></i> Add to Carts </label></div>
                                </td>
                                <td>5,000</td>
                                <td>1,500 <small>(Recommended)</small></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="i-checks"><label> <input name="audience" type="checkbox" value="3">
                                            <i></i>Abandoned Checkouts</label></div>
                                </td>
                                <td>2,000</td>
                                <td>600</td>
                            </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-secondary btn-lg" type="submit">Save & Exit</button>
                        <button class="btn btn-primary btn-lg" type="submit">Start Campaign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
