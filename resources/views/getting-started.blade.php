@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <!-- <div class="row">
        <div class="col-lg-12">
            <h3>
                Automated Retargeting
            </h3>
        </div>
    </div> -->
    <!-- This is the new User interface  -->
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title heading-dashboard">
                            Step 1: Set Your Rules
                        </div>
                        <div class="ibox-content">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="inputs-label">Target Audience</th>
                                        <th scope="col" class="inputs-label">Audience Size</th>
                                        <th scope="col" class="inputs-label">Est. Address Match (30%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioGroup" id="all_visitors">
                                                <label class="form-check-label table-content" for="all_visitors">
                                                    All Visitors
                                                </label>
                                            </div>
                                        </td>
                                        <td class="table-content">
                                            50,000
                                        </td>
                                        <td class="table-content">
                                            15,000
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioGroup" id="add_to_carts" checked>
                                                <label class="form-check-label table-content" for="add_to_carts">
                                                    Add to Carts
                                                </label>
                                            </div>
                                        </td>
                                        <td class="table-content">
                                            50,000
                                        </td>
                                        <td class="table-content">
                                            15,000
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="radioGroup" id="abd_checkouts">
                                                <label class="form-check-label table-content" for="abd_checkouts">
                                                    Abandoned Checkouts
                                                </label>
                                            </div>
                                        </td>
                                        <td class="table-content">
                                            50,000
                                        </td>
                                        <td class="table-content">
                                            15,000
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



            </div>
            <div class="row">

                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title heading-dashboard">
                            Step 2: Design Your Postcard
                        </div>
                        <div class="ibox-content">
                            <p class="custom-text">
                                Choose from hundreds of pre-made, conversion optimized templates to amplify your sales.
                            </p>


                            <div>
                                <button type="button" class="btn custom-button">Open Designer</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title heading-dashboard">
                            Step 3: Create Your Offer
                        </div>
                        <div class="ibox-content">
                            <p class="custom-text">
                                Statistics show that customers are more likely to convert when presented an offer. Each customer’s post card will come with a custom printed code they can use at checkout.
                            </p>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="example-select" class="inputs-label">Offer Type</label>
                                        <select class="form-control custom-input" id="example-select">
                                            <option>%Off</option>
                                            <option>%Discount</option>
                                            <option>Flat Off</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="simpleinput" class="inputs-label">Amount</label>
                                        <input type="text" id="amount_inp" class="form-control custom-input">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="simpleinput" class="inputs-label">Discount Prefix</label>
                                        <input type="text" id="simpleinput" class="form-control custom-input">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <p class="faded-text">Ex. Code: ‘EZURE-ABC123’ grants 10% off purchases</p>
                                </div>
                            </div>
                            <div style="padding: 20px 10px 0px 0px">
                                <button type="button" class="btn custom-button" onclick="launchCampaignModal()">Start Campaign</button>
                            </div>

                            <div class="row mt-20">
                                <div class="col-lg-8"><small class="custom-text">Do you want to limit the number of postcards sent on a monthly basis?</small></div>
                                <div class="col-lg-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label custom-text" for="customCheck1">Yes</label>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-20" id="panel" style="display: none;">
                                <div class="col-lg-6 mt-10"><small class="custom-text">Please limit the number of postcards sent per month to: </small></div>
                                <div class="col-lg-6">
                                    <input type="text" id="amount_inp" class="form-control custom-input">
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
                                        <label for="simpleinput" class="inputs-label">Audience Size</label>
                                        <input type="text" id="audience_inp" class="form-control custom-input">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="" class="inputs-label">Estimated Address Match</label>
                                        <input type="text" id="eAddressMatch_Label" class="form-control custom-input">
                                        <div id="eAddressMatch">
                                            <input id="eAddressMatch_ranger" value="50" type="range" min="45" max="55" step="5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="" class="inputs-label">Conversion Rate</label>
                                        <input type="text" id="conversionRate_Label" class="form-control custom-input">
                                        <div id="conversionRate">
                                            <input id="conversionRate_ranger" value="5" type="range" min="1" max="10" step="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-3">
                                        <label for="simpleinput" class="inputs-label">Average Order Value</label>
                                        <input type="text" id="simpleinput" class="form-control custom-input">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-lg-12">
                                    <h2 class="heading-dashboard text-center p-t-25">What you’ll get</h2>
                                    <br>

                                    <div class="row no-gutters">
                                        <div class="col-sm-6 col-xl-4">
                                            <div class=" shadow-none m-0">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-briefcase text-muted" style="font-size: 24px;"></i>
                                                    <h3 class="green-figures"><span>750</span></h3>
                                                    <p class="mb-0 text-figures">Post Cards Sent</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-4">
                                            <div class=" shadow-none m-0 ">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-checklist text-muted" style="font-size: 24px;"></i>
                                                    <h3 class="green-figures"><span>$1,125</span></h3>
                                                    <p class="mb-0 text-figures">Total Cost</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-4">
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
                                        <div class="col-sm-6 col-xl-4">
                                            <div class=" shadow-none m-0">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-briefcase text-muted" style="font-size: 24px;"></i>
                                                    <h3 class="green-figures"><span>$3,800</span></h3>
                                                    <p class="mb-0 text-figures">New Revenue</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-4">
                                            <div class=" shadow-none m-0 ">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-checklist text-muted" style="font-size: 24px;"></i>
                                                    <h3 class="green-figures"><span>$30</span></h3>
                                                    <p class="mb-0 text-figures">Customer Acquisition Cost</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-4">
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
        </div>

    </div>


    <!-- Campaign overview modal -->

    <!-- Modal -->
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

        var Amount = new NumericInput(document.getElementById("amount_inp"));
        var AudienceSize = new NumericInput(document.getElementById("audience_inp"));


        // Script written for range sliders

        //First Slider
        const comission = document.querySelector('#eAddressMatch input');
        const comissionLabel = document.getElementById('eAddressMatch_Label');
        const comissionLabelPrefix = comissionLabel.innerHTML;
        const comissionRange = document.createElement('label');

        comissionRange.id = 'rangeLimits';
        comissionRange.className = 'row';
        comissionRange.innerHTML = `<span class="col-6 text-left faded-range">${comission.getAttribute('min')}%</span><span class="col-6 text-right faded-range">${comission.getAttribute('max')}%</span>`;
        document.querySelector('#eAddressMatch').appendChild(comissionRange);

        comissionLabel.value = `${comission.value}%`;

        comission.addEventListener('input', function() {
            comissionLabel.value = `${Number(comission.value)}%`;
        }, false);

        document.getElementById("eAddressMatch_ranger").oninput = function() {
            var value = (this.value - this.min) / (this.max - this.min) * 100
            this.style.background = 'linear-gradient(to right, #007200 0%, #007200 ' + value + '%, #fff ' + value + '%, white 100%)'
        };


        //Second Slider       

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
    </script>

    <!-- New interface ends here -->


    <!-- <div class="row">
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

                    <iframe width="90%" height="500px" src="https://www.youtube.com/embed/8TjQDK5_1cU">
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
    </div> -->
</div>
@endsection