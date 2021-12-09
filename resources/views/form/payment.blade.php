@extends('layouts.app', ['activePage' => 'design', 'titlePage' => __('Select A Postcard')])

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Add a Subscription</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Add a Payment Method</h5>
                        </div>
                        <div class="ibox-content">
                            <h5>Payment Method</h5>

                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Product:</strong>: Simplepost <br>
                                    <strong>Price:</strong>: <span class="text-navy">$1.50</span> <small>per
                                        postcard</small>

                                    <p class="m-t">
                                        Your card will be charged weekly based on the number of postcards sent each
                                        week. Charges are done every Monday for the previous week.
                                    </p>
                                </div>
                                <form action="{{ Route('startSubscription') }}" method="post">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Name on card</label>
                                                    <input type="text" class="form-control" name="nameCard"
                                                           placeholder="Full name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Credit Card Number</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="number"
                                                               placeholder="Card Number"
                                                               required="required">
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-credit-card"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 col-md-7">
                                                <div class="form-group">
                                                    <label>Expiration Date</label>
                                                    <input type="text" class="form-control" name="expiration"
                                                           placeholder="MM / YY" required="required">
                                                </div>
                                            </div>
                                            <div class="col-5 col-md-5 float-right">
                                                <div class="form-group">
                                                    <label>CVV</label>
                                                    <input type="text" class="form-control" name="CVV"
                                                           placeholder="CVV" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button class="btn btn-primary btn-lg" name="submit" value="start" type="submit">Start Campaign</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
