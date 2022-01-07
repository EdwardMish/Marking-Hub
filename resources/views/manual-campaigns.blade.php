@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')

<!-- Include Apex Charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.31.0/apexcharts.min.js" integrity="sha512-5nh/cCgHEr1ncUodSt5m0z5vOsT+iJlRN9fUtuyc1hC4KPB/bMozP2hsGiWg7DmC8/+96ZowqLKKt7yqmVNW9g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Manual Campaigns</h4>
            </div>
        </div>
    </div>
    <!-- This is the new User interface  -->
    <div class="row">
        <div class="col-lg-6">
<<<<<<< HEAD
            <form action="{{ Route('manualCampaigns.startCampaign') }}" method="post" name="campaign">
                @csrf
                @include('manual-campaigns.parts._campaign-name')

                @include('manual-campaigns.parts._select-postcard')
            </form>
                @include('manual-campaigns.parts._criteria')

                @include('manual-campaigns.parts._chart')

                @include('manual-campaigns.parts._start')
            
        </div>
        <div class="col-lg-6">
            
            @include('manual-campaigns.parts._campaign-estimator')
        
=======
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title heading-dashboard">
                            Campaign Criteria
                        </div>
                        <div class="ibox-content">
                            <p class="custom-text">
                                I want to send this postcard with this offer to this audience:
                            </p>
                            <div class="row">
                                <div class="col-6">
                                    <select class="form-control custom-input" id="example-select">
                                        <option>All unique prior customers</option>
                                        <option>Customers who purchased more than [X]</option>
                                        <option>Customers who purchased more than [X] times</option>
                                        <option>Top [X]% of customers by spend</option>
                                    </select>
                                </div>
                                <div class="col-6"></div>

                            </div>
                            <div class="row mt-20">
                                <div class="col-3 p-r-5">
                                    <input type="text" id="customer_spend" class="form-control custom-input" value="Customer Spend">
                                </div>
                                <div class="col-3 p-l-5">
                                    <select class="form-control custom-input" id="example-select">
                                        <option>equals</option>
                                        <option>greator to</option>
                                        <option>less than</option>
                                    </select>
                                </div>
                                <div class="col-6"><input type="text" id="amount_inp" class="form-control custom-input" value="100"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">

                            <div class=" shadow-none m-0 ">
                                <div class="card-body text-center">
                                    <div id="audience_chart"></div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title heading-dashboard">
                            Campaign Estimator
                        </div>
                        <div class="ibox-content">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="audience_inp" class="inputs-label">Audience Size</label>
                                        <input type="text" id="audience_inp" class="form-control custom-input">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="" class="inputs-label">Conversion Rate</label>
                                        <input type="text" id="conversionRate_Label" class="form-control custom-input">
                                        <div id="conversionRate">
                                            <input id="conversionRate_ranger" value="5" type="range" min="1" max="10" step="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="avg_order_val" class="inputs-label">Average Order Value</label>
                                        <input type="text" id="avg_order_val" class="form-control custom-input">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <button type="button" class="btn custom_launch_button" onclick="launchCampaignModal()">Launch Campaign</button>
                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-lg-12">
                                    <h2 class="heading-dashboard text-center p-t-25">What you’ll get</h2>
                                    <br>

                                    <div class="row no-gutters">
                                        <div class="col-xl-4">
                                            <div class=" shadow-none m-0">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-briefcase text-muted" style="font-size: 24px;"></i>
                                                    <h3 class="green-figures"><span>750</span></h3>
                                                    <p class="mb-0 text-figures">Post Cards Sent</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class=" shadow-none m-0 ">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-checklist text-muted" style="font-size: 24px;"></i>
                                                    <h3 class="green-figures"><span>$1,125</span></h3>
                                                    <p class="mb-0 text-figures">Total Cost</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class=" shadow-none m-0 ">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                                    <h3 class="green-figures"><span>38</span></h3>
                                                    <p class="mb-0 text-figures">Number of New Orders</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row no-gutters">
                                        <div class="col-xl-4">
                                            <div class=" shadow-none m-0">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-briefcase text-muted" style="font-size: 24px;"></i>
                                                    <h3 class="green-figures"><span>$3,800</span></h3>
                                                    <p class="mb-0 text-figures">New Revenue</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class=" shadow-none m-0 ">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-checklist text-muted" style="font-size: 24px;"></i>
                                                    <h3 class="green-figures"><span>$30</span></h3>
                                                    <p class="mb-0 text-figures">Customer Acquisition Cost</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-4">
                                            <div class=" shadow-none m-0 ">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                                    <h3 class="green-figures"><span>3.4x</span></h3>
                                                    <p class="mb-0 text-figures">Return on Ad Spend</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
>>>>>>> new-design
        </div>

    </div>


    <!-- Campaign overview modal -->

    <!-- Modal -->
<<<<<<< HEAD
    @include('manual-campaigns.parts._modals._campaign-overview')
=======
    <div class="modal fade" id="campaignOverviewModal" tabindex="-1" aria-labelledby="campaignOverviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="row">
                    <div class="col-lg-12" style="margin-top: -15px;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="width: 20px;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-title heading-dashboard">
                                        Campaign Overview
                                    </div>
                                    <div class="ibox-content">
                                        <p class="custom-text">
                                            $1.50 per postcard sent.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-title heading-dashboard">
                                        Payment Information
                                    </div>
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <label for="card_number" class="inputs-label">Card Number</label>
                                                    <input type="text" id="card_number" class="form-control custom-input" placeholder="1234 1234 1234 1234">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group mb-3">
                                                    <label for="card_number" class="inputs-label">Security Code</label>
                                                    <input type="text" id="card_number" class="form-control custom-input" placeholder="CVC">
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group mb-3">
                                                    <label for="card_number" class="inputs-label">Expiration Date</label>
                                                    <input type="text" id="card_number" class="form-control custom-input" placeholder="MM / YY">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p class="faded-text" style="margin: 0;">This card will be used for all future Simplepost purchases</p>
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-lg-12">
                                                <div style="padding: 20px 10px 0px 0px">
                                                    <button type="button" class="btn custom-button" onclick="">Add Payment</button>
                                                </div>
                                            </div>

                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox">
                                    <div class="ibox-title heading-dashboard">
                                        Billing Address
                                    </div>
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <!-- <p class="faded-text" style="margin: 0;">Your billing address will determine the applicable sales tax.</p>
                                                <div class="row mt-20 mb-30">
                                                    <div class="col-lg-8">
                                                        <p class="custom-text">Use same address as my organization's contact information</p>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="billing_address_checkbox">
                                                            <label class="custom-control-label custom-text" for="billing_address_checkbox">Yes</label>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="form-group mb-3">
                                                    <label for="street_address" class="inputs-label">Address</label>
                                                    <input type="text" id="street_address" class="form-control custom-input mb-10" placeholder="Street address">
                                                    <input type="text" id="street_address2" class="form-control custom-input" placeholder="Apt, suite, building (optional)">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="card_number" class="inputs-label">City</label>
                                                    <input type="text" id="card_number" class="form-control custom-input" placeholder="e.g. Boston">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="card_number" class="inputs-label">State/Province/Region</label>
                                                    <input type="text" id="card_number" class="form-control custom-input" placeholder="e.g. MA">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="country_select" class="inputs-label">Country</label>
                                                    <select class="form-control custom-input" id="country_select">
                                                        <option>Select</option>
                                                        <option value="AF">Afghanistan</option>
                                                        <option value="AX">Åland Islands</option>
                                                        <option value="AL">Albania</option>
                                                        <option value="DZ">Algeria</option>
                                                        <option value="AS">American Samoa</option>
                                                        <option value="AD">Andorra</option>
                                                        <option value="AO">Angola</option>
                                                        <option value="AI">Anguilla</option>
                                                        <option value="AQ">Antarctica</option>
                                                        <option value="AG">Antigua and Barbuda</option>
                                                        <option value="AR">Argentina</option>
                                                        <option value="AM">Armenia</option>
                                                        <option value="AW">Aruba</option>
                                                        <option value="AU">Australia</option>
                                                        <option value="AT">Austria</option>
                                                        <option value="AZ">Azerbaijan</option>
                                                        <option value="BS">Bahamas</option>
                                                        <option value="BH">Bahrain</option>
                                                        <option value="BD">Bangladesh</option>
                                                        <option value="BB">Barbados</option>
                                                        <option value="BY">Belarus</option>
                                                        <option value="BE">Belgium</option>
                                                        <option value="BZ">Belize</option>
                                                        <option value="BJ">Benin</option>
                                                        <option value="BM">Bermuda</option>
                                                        <option value="BT">Bhutan</option>
                                                        <option value="BO">Bolivia, Plurinational State of</option>
                                                        <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                                        <option value="BA">Bosnia and Herzegovina</option>
                                                        <option value="BW">Botswana</option>
                                                        <option value="BV">Bouvet Island</option>
                                                        <option value="BR">Brazil</option>
                                                        <option value="IO">British Indian Ocean Territory</option>
                                                        <option value="BN">Brunei Darussalam</option>
                                                        <option value="BG">Bulgaria</option>
                                                        <option value="BF">Burkina Faso</option>
                                                        <option value="BI">Burundi</option>
                                                        <option value="KH">Cambodia</option>
                                                        <option value="CM">Cameroon</option>
                                                        <option value="CA">Canada</option>
                                                        <option value="CV">Cape Verde</option>
                                                        <option value="KY">Cayman Islands</option>
                                                        <option value="CF">Central African Republic</option>
                                                        <option value="TD">Chad</option>
                                                        <option value="CL">Chile</option>
                                                        <option value="CN">China</option>
                                                        <option value="CX">Christmas Island</option>
                                                        <option value="CC">Cocos (Keeling) Islands</option>
                                                        <option value="CO">Colombia</option>
                                                        <option value="KM">Comoros</option>
                                                        <option value="CG">Congo</option>
                                                        <option value="CD">Congo, the Democratic Republic of the</option>
                                                        <option value="CK">Cook Islands</option>
                                                        <option value="CR">Costa Rica</option>
                                                        <option value="CI">Côte d'Ivoire</option>
                                                        <option value="HR">Croatia</option>
                                                        <option value="CU">Cuba</option>
                                                        <option value="CW">Curaçao</option>
                                                        <option value="CY">Cyprus</option>
                                                        <option value="CZ">Czech Republic</option>
                                                        <option value="DK">Denmark</option>
                                                        <option value="DJ">Djibouti</option>
                                                        <option value="DM">Dominica</option>
                                                        <option value="DO">Dominican Republic</option>
                                                        <option value="EC">Ecuador</option>
                                                        <option value="EG">Egypt</option>
                                                        <option value="SV">El Salvador</option>
                                                        <option value="GQ">Equatorial Guinea</option>
                                                        <option value="ER">Eritrea</option>
                                                        <option value="EE">Estonia</option>
                                                        <option value="ET">Ethiopia</option>
                                                        <option value="FK">Falkland Islands (Malvinas)</option>
                                                        <option value="FO">Faroe Islands</option>
                                                        <option value="FJ">Fiji</option>
                                                        <option value="FI">Finland</option>
                                                        <option value="FR">France</option>
                                                        <option value="GF">French Guiana</option>
                                                        <option value="PF">French Polynesia</option>
                                                        <option value="TF">French Southern Territories</option>
                                                        <option value="GA">Gabon</option>
                                                        <option value="GM">Gambia</option>
                                                        <option value="GE">Georgia</option>
                                                        <option value="DE">Germany</option>
                                                        <option value="GH">Ghana</option>
                                                        <option value="GI">Gibraltar</option>
                                                        <option value="GR">Greece</option>
                                                        <option value="GL">Greenland</option>
                                                        <option value="GD">Grenada</option>
                                                        <option value="GP">Guadeloupe</option>
                                                        <option value="GU">Guam</option>
                                                        <option value="GT">Guatemala</option>
                                                        <option value="GG">Guernsey</option>
                                                        <option value="GN">Guinea</option>
                                                        <option value="GW">Guinea-Bissau</option>
                                                        <option value="GY">Guyana</option>
                                                        <option value="HT">Haiti</option>
                                                        <option value="HM">Heard Island and McDonald Islands</option>
                                                        <option value="VA">Holy See (Vatican City State)</option>
                                                        <option value="HN">Honduras</option>
                                                        <option value="HK">Hong Kong</option>
                                                        <option value="HU">Hungary</option>
                                                        <option value="IS">Iceland</option>
                                                        <option value="IN">India</option>
                                                        <option value="ID">Indonesia</option>
                                                        <option value="IR">Iran, Islamic Republic of</option>
                                                        <option value="IQ">Iraq</option>
                                                        <option value="IE">Ireland</option>
                                                        <option value="IM">Isle of Man</option>
                                                        <option value="IL">Israel</option>
                                                        <option value="IT">Italy</option>
                                                        <option value="JM">Jamaica</option>
                                                        <option value="JP">Japan</option>
                                                        <option value="JE">Jersey</option>
                                                        <option value="JO">Jordan</option>
                                                        <option value="KZ">Kazakhstan</option>
                                                        <option value="KE">Kenya</option>
                                                        <option value="KI">Kiribati</option>
                                                        <option value="KP">Korea, Democratic People's Republic of</option>
                                                        <option value="KR">Korea, Republic of</option>
                                                        <option value="KW">Kuwait</option>
                                                        <option value="KG">Kyrgyzstan</option>
                                                        <option value="LA">Lao People's Democratic Republic</option>
                                                        <option value="LV">Latvia</option>
                                                        <option value="LB">Lebanon</option>
                                                        <option value="LS">Lesotho</option>
                                                        <option value="LR">Liberia</option>
                                                        <option value="LY">Libya</option>
                                                        <option value="LI">Liechtenstein</option>
                                                        <option value="LT">Lithuania</option>
                                                        <option value="LU">Luxembourg</option>
                                                        <option value="MO">Macao</option>
                                                        <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                                                        <option value="MG">Madagascar</option>
                                                        <option value="MW">Malawi</option>
                                                        <option value="MY">Malaysia</option>
                                                        <option value="MV">Maldives</option>
                                                        <option value="ML">Mali</option>
                                                        <option value="MT">Malta</option>
                                                        <option value="MH">Marshall Islands</option>
                                                        <option value="MQ">Martinique</option>
                                                        <option value="MR">Mauritania</option>
                                                        <option value="MU">Mauritius</option>
                                                        <option value="YT">Mayotte</option>
                                                        <option value="MX">Mexico</option>
                                                        <option value="FM">Micronesia, Federated States of</option>
                                                        <option value="MD">Moldova, Republic of</option>
                                                        <option value="MC">Monaco</option>
                                                        <option value="MN">Mongolia</option>
                                                        <option value="ME">Montenegro</option>
                                                        <option value="MS">Montserrat</option>
                                                        <option value="MA">Morocco</option>
                                                        <option value="MZ">Mozambique</option>
                                                        <option value="MM">Myanmar</option>
                                                        <option value="NA">Namibia</option>
                                                        <option value="NR">Nauru</option>
                                                        <option value="NP">Nepal</option>
                                                        <option value="NL">Netherlands</option>
                                                        <option value="NC">New Caledonia</option>
                                                        <option value="NZ">New Zealand</option>
                                                        <option value="NI">Nicaragua</option>
                                                        <option value="NE">Niger</option>
                                                        <option value="NG">Nigeria</option>
                                                        <option value="NU">Niue</option>
                                                        <option value="NF">Norfolk Island</option>
                                                        <option value="MP">Northern Mariana Islands</option>
                                                        <option value="NO">Norway</option>
                                                        <option value="OM">Oman</option>
                                                        <option value="PK">Pakistan</option>
                                                        <option value="PW">Palau</option>
                                                        <option value="PS">Palestinian Territory, Occupied</option>
                                                        <option value="PA">Panama</option>
                                                        <option value="PG">Papua New Guinea</option>
                                                        <option value="PY">Paraguay</option>
                                                        <option value="PE">Peru</option>
                                                        <option value="PH">Philippines</option>
                                                        <option value="PN">Pitcairn</option>
                                                        <option value="PL">Poland</option>
                                                        <option value="PT">Portugal</option>
                                                        <option value="PR">Puerto Rico</option>
                                                        <option value="QA">Qatar</option>
                                                        <option value="RE">Réunion</option>
                                                        <option value="RO">Romania</option>
                                                        <option value="RU">Russian Federation</option>
                                                        <option value="RW">Rwanda</option>
                                                        <option value="BL">Saint Barthélemy</option>
                                                        <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                                                        <option value="KN">Saint Kitts and Nevis</option>
                                                        <option value="LC">Saint Lucia</option>
                                                        <option value="MF">Saint Martin (French part)</option>
                                                        <option value="PM">Saint Pierre and Miquelon</option>
                                                        <option value="VC">Saint Vincent and the Grenadines</option>
                                                        <option value="WS">Samoa</option>
                                                        <option value="SM">San Marino</option>
                                                        <option value="ST">Sao Tome and Principe</option>
                                                        <option value="SA">Saudi Arabia</option>
                                                        <option value="SN">Senegal</option>
                                                        <option value="RS">Serbia</option>
                                                        <option value="SC">Seychelles</option>
                                                        <option value="SL">Sierra Leone</option>
                                                        <option value="SG">Singapore</option>
                                                        <option value="SX">Sint Maarten (Dutch part)</option>
                                                        <option value="SK">Slovakia</option>
                                                        <option value="SI">Slovenia</option>
                                                        <option value="SB">Solomon Islands</option>
                                                        <option value="SO">Somalia</option>
                                                        <option value="ZA">South Africa</option>
                                                        <option value="GS">South Georgia and the South Sandwich Islands</option>
                                                        <option value="SS">South Sudan</option>
                                                        <option value="ES">Spain</option>
                                                        <option value="LK">Sri Lanka</option>
                                                        <option value="SD">Sudan</option>
                                                        <option value="SR">Suriname</option>
                                                        <option value="SJ">Svalbard and Jan Mayen</option>
                                                        <option value="SZ">Swaziland</option>
                                                        <option value="SE">Sweden</option>
                                                        <option value="CH">Switzerland</option>
                                                        <option value="SY">Syrian Arab Republic</option>
                                                        <option value="TW">Taiwan, Province of China</option>
                                                        <option value="TJ">Tajikistan</option>
                                                        <option value="TZ">Tanzania, United Republic of</option>
                                                        <option value="TH">Thailand</option>
                                                        <option value="TL">Timor-Leste</option>
                                                        <option value="TG">Togo</option>
                                                        <option value="TK">Tokelau</option>
                                                        <option value="TO">Tonga</option>
                                                        <option value="TT">Trinidad and Tobago</option>
                                                        <option value="TN">Tunisia</option>
                                                        <option value="TR">Turkey</option>
                                                        <option value="TM">Turkmenistan</option>
                                                        <option value="TC">Turks and Caicos Islands</option>
                                                        <option value="TV">Tuvalu</option>
                                                        <option value="UG">Uganda</option>
                                                        <option value="UA">Ukraine</option>
                                                        <option value="AE">United Arab Emirates</option>
                                                        <option value="GB">United Kingdom</option>
                                                        <option value="US">United States</option>
                                                        <option value="UM">United States Minor Outlying Islands</option>
                                                        <option value="UY">Uruguay</option>
                                                        <option value="UZ">Uzbekistan</option>
                                                        <option value="VU">Vanuatu</option>
                                                        <option value="VE">Venezuela, Bolivarian Republic of</option>
                                                        <option value="VN">Viet Nam</option>
                                                        <option value="VG">Virgin Islands, British</option>
                                                        <option value="VI">Virgin Islands, U.S.</option>
                                                        <option value="WF">Wallis and Futuna</option>
                                                        <option value="EH">Western Sahara</option>
                                                        <option value="YE">Yemen</option>
                                                        <option value="ZM">Zambia</option>
                                                        <option value="ZW">Zimbabwe</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label for="zip_postal_code" class="inputs-label">Postal/Zip Code</label>
                                                    <input type="text" id="zip_postal_code" class="form-control custom-input" placeholder="e.g. 01234">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <button type="button" class="btn custom-button" onclick="">Confirm Subscription</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
>>>>>>> new-design

    <script>
        "use strict";

        //Campaign overview code starts
        function launchCampaignModal() {
            $('#campaignOverviewModal').modal({
                backdrop: false,
                show: true
            });
        }
        // Campaign overview modal ends

        function NumericInput(inp) {
            var numericKeys = '0123456789';

            // restricts input to numeric keys 0-9
            inp.addEventListener('keypress', function(e) {
                var event = e || window.event;
                var target = event.target;

                if (event.charCode == 0) {
                    return;
                }

                if (-1 == numericKeys.indexOf(event.key)) {
                    // Could notify the user that 0-9 is only acceptable input.
                    event.preventDefault();
                    return;
                }
            });

            // add the thousands separator when the user blurs
            inp.addEventListener('blur', function(e) {
                var event = e || window.event;
                var target = event.target;

                var tmp = target.value.replace(/,/g, '');
                var val = Number(tmp).toLocaleString('en-CA');

                if (tmp == '') {
                    target.value = '';
                } else {
                    target.value = val;
                }
            });

            // strip the thousands separator when the user puts the input in focus.
            inp.addEventListener('focus', function(e) {
                var event = e || window.event;
                var target = event.target;
                var val = target.value.replace(/[,.]/g, '');

                target.value = val;
            });
        }

        var Amount = new NumericInput(document.getElementById("avg_order_val"));
        var AudienceSize = new NumericInput(document.getElementById("audience_inp"));


<<<<<<< HEAD
        var audienceSizeEle = document.getElementById("audience_inp");
        var averageOrderSizeEle = document.getElementById("avg_order_val");
        var conversionRate_LabelEle = document.getElementById("conversionRate_Label");
        var audienceSize = parseInt(audienceSizeEle.value);
        var averageOrderSize = parseInt(averageOrderSizeEle.value);

        audienceSizeEle.addEventListener('change', function() {
            audienceSize = parseInt(audienceSizeEle.value)
            updateCalculator();

        });

        averageOrderSizeEle.addEventListener('change', function() {
            averageOrderSize = parseInt(averageOrderSizeEle.value)
            if (averageOrderSize > 0) {
                updateCalculator();
            }
        });

        // conversionRate_LabelEle.addEventListener('input', function() {
        //     updateCalculator();
        // });


        function updateCalculator() {

            let audienceSize = audienceSizeEle.value;
            audienceSize = audienceSize.replace(/\D/g, '');

            let estMatch = '50%';
            estMatch = estMatch.replace(/\D/g, '');

            let postCardsToSend = document.getElementById('postcards-to-send');
            postCardsToSend.innerText = Math.ceil(estMatch / 100 * audienceSize);

            let conversionRate = document.getElementById('conversionRate_Label').value
            conversionRate = conversionRate.replace(/\D/g, '');

            let incrementalOrders = document.getElementById('incremental-orders');
            incrementalOrders.innerText = Math.ceil(conversionRate / 100 * postCardsToSend.innerText);
            let totalPostCardCost = document.getElementById('total-post-card-cost');
            let totalPostCardCostVal = Math.round(1.5 * postCardsToSend.innerText);
            totalPostCardCost.innerText = '$' + totalPostCardCostVal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            let costPerAcquisition = document.getElementById('cost-per-acquisition');
            let costPerAcqRounded = totalPostCardCost.innerText.substring(1, totalPostCardCost.innerText.length).replace(',', '') / incrementalOrders.innerText.replace(',', '');
           // costPerAcquisition.innerText = '$' + costPerAcqRounded.toFixed(2)
            costPerAcquisition.innerText = '$' + Math.round(costPerAcqRounded);

            let averageOrderSize = document.getElementById('avg_order_val').value;
            averageOrderSize = averageOrderSize.replace(/\D/g, '');

            let additionalRevenue = document.getElementById('additional-revenue');
            additionalRevenue.innerText = '$' + (Math.ceil(averageOrderSize * incrementalOrders.innerText)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

            let roas = document.getElementById('return-on-ad-spend');
            let roasVal = averageOrderSize / costPerAcqRounded;
            roas.innerText = roasVal.toFixed(1) + 'x';

        }

=======
>>>>>>> new-design
        // Script written for range sliders

        const conversionRate = document.querySelector('#conversionRate input');
        const conversionRateLabel = document.getElementById('conversionRate_Label');
        const conversionRateLabelPrefix = conversionRateLabel.innerHTML;
        const conversionRateRange = document.createElement('label');

        conversionRateRange.id = 'rangeLimits_conversionRate';
        conversionRateRange.className = 'row';
        conversionRateRange.innerHTML = `<span class="col-6 text-left faded-range">${conversionRate.getAttribute('min')}%</span><span class="col-6 text-right faded-range">${conversionRate.getAttribute('max')}%</span>`;
        document.querySelector('#conversionRate').appendChild(conversionRateRange);

        conversionRateLabel.value = `${conversionRate.value}%`;

        conversionRate.addEventListener('input', function() {
            conversionRateLabel.value = `${Number(conversionRate.value)}%`;
<<<<<<< HEAD
            updateCalculator();
=======
>>>>>>> new-design
        }, false);

        document.getElementById("conversionRate_ranger").oninput = function() {
            var value = (this.value - this.min) / (this.max - this.min) * 100
            this.style.background = 'linear-gradient(to right, #007200 0%, #007200 ' + value + '%, #fff ' + value + '%, white 100%)'
        };

        // Checkbox show/hide toggle function
        $("#customCheck1").change(function() {
            if (this.checked) {
                $("#panel").slideDown();
            } else {
                $("#panel").slideUp();
            }
        });


<<<<<<< HEAD
        function drawChart(series){

            $('#audience_chart').empty();

            //Apex Donut Chart whole #80b880
            var options = {
                chart: {
                    height: 350,
                    type: 'donut'
                },
                fill: {
                    colors: ['#80b880', '#007200']
                },
                legend: {
                    show: true,
                    showForSingleSeries: false,
                    showForNullSeries: true,
                    showForZeroSeries: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    floating: false,
                    fontSize: '14px',
                    fontFamily: 'Helvetica Neue Normal',
                    fontWeight: 400
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '50%'
                        },
                        expandOnClick: false
                    }
                },
                colors: ['#80b880', '#007200'],
                labels: ['Whole Audience (# and $ revenue focused)', 'Selected audience size (# and order value)'],
                series
            };
            
            var chart = new ApexCharts(document.querySelector("#audience_chart"), options);
            chart.render();
        }

        const postcard_audience = document.getElementById('postcard_audience');
        const spend_operator = document.getElementById('spend_operator');
        const input_value = document.getElementById('input_value');
        
        function getAudienceChartData(){
            let postcardAudienceVal = postcard_audience.value;
            let spendOperatorVal = spend_operator.value;
            let inputValueVal = input_value.value;
            
            $.ajax({
                method: "post",
                url: "/manual-campaigns/draw-data",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    audience:postcardAudienceVal,
                    operator:spendOperatorVal,
                    value:inputValueVal
                },
                dataType:'json',
                success:function(serialData) {
                    drawChart(serialData);
                },
                error: function(error) {
                    console.log('error', error)                                
                    drawChart([]);
                }
            });

        }

        postcard_audience.addEventListener('change', getAudienceChartData);
        spend_operator.addEventListener('change', getAudienceChartData);
        input_value.addEventListener('change', getAudienceChartData);

        getAudienceChartData();

=======
        //Apex Donut Chart whole #80b880

        var options = {
            chart: {
                height: 350,
                type: 'donut'
            },
            fill: {
                colors: ['#80b880', '#007200']
            },
            legend: {
                show: true,
                showForSingleSeries: false,
                showForNullSeries: true,
                showForZeroSeries: true,
                position: 'bottom',
                horizontalAlign: 'center',
                floating: false,
                fontSize: '14px',
                fontFamily: 'Helvetica Neue Normal',
                fontWeight: 400
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '50%'
                    },
                    expandOnClick: false
                }
            },
            colors: ['#80b880', '#007200'],
            labels: ['Whole Audience (# and $ revenue focused)', 'Selected audience size (# and order value)'],
            series: [80, 20]
        };

        var chart = new ApexCharts(document.querySelector("#audience_chart"), options);
        chart.render();
>>>>>>> new-design
    </script>


</div>
@endsection

<!-- so we get historical order data from stores, what we'd like to be able to do is graphically display and sort that order data into meaning along these lines: top [x%] of customers (note: customers can have multiple orders), customers who have purchased something more than [x] times, customers who have spent more than [$x]
so we will need a new page that is able to read and sort through the historical order data -->
<<<<<<< HEAD

@push('js')
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}" defer></script>
    <script>
        $('#submitCampaign').on('click', function (result) {
            $('.ibox').children('.ibox-content').toggleClass('sk-loading');
            var shopId = $('select[name="shop_id"]').val();
            $.ajax({
                method: "post",
                url: $("form").attr('action'),
                data: $("form").serialize()
            }).done(function(result) {
                $('.ibox').children('.ibox-content').toggleClass('sk-loading');
                window.location.href = result.success['redirect'];
            }).fail(function(result) {
                // $('#paymentModal').show();
                let obj = result.responseJSON.errors;

                let arr = Object.keys(obj).map(function (key) { return obj[key]; });

                swal({
                    title: "Form input error",
                    text: arr,
                    icon: "error",
                    confirmButtonColor: "#DD6B55",
                });

                $('.ibox').children('.ibox-content').toggleClass('sk-loading');
            });
        })
    </script>
@endpush

@push('css')
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
@endpush
=======
>>>>>>> new-design
