@extends('layouts.app', ['activePage' => 'design', 'titlePage' => __('Select A Postcard')])

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="ibox">
                    <div class="ibox-title heading-dashboard">
                        New Getting Started
                    </div>
                    <div class="ibox-content">
                        <p class="custom-text">Over 200 billion emails are sent each day, but the recipient opens only 34.1% of those emails. Given that potential customers are already overwhelmed with an inbox full of emails, there's a significant chance that they won't open your email, regardless of how relevant or personalized it is.</p>
                        <p>Direct mailing lists have a much higher delivery rate and open rate than email campaigns. And 77% of people sort through their physical mail as soon as they get it.</p>
                        <p>Direct mail is inherently more visible than email communication because it is tangible. By sending it, you can get around email fatigue and get your message in front of high-intent customers.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-6 col-md-6">
                <iframe style="width:100%;" width="420" height="400" src="https://www.youtube.com/embed/tgbNymZ7vqY"></iframe>
            </div>

            <div class="col-lg-6 col-md-6">

                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <p class="custom-text">
                                    Automated Retargeting:
                                </p>
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" id="customer_spend" class="form-control custom-input" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="ibox">
                            <div class="ibox-content">
                                <p class="custom-text">
                                    Manual Retargeting:
                                </p>
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" id="customer_spend" class="form-control custom-input" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
