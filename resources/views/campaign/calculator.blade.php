<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Campaign Estimator</h5>
            </div>
            <div class="ibox-content">
                <div class="row m-b-lg">
                    <div class="col-lg-12">
                        <div id="drag-fixed" class="slider_red"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p class="font-bold">Audience Size</p>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" id="audience-size" class="form-control" value="1500">
                    </div>
                    {{--                    <div class="col-lg-4">--}}
                    {{--                        <div id="audience-size-slider"></div>--}}
                    {{--                    </div>--}}
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p class="font-bold">Est. Address Match</p>
                    </div>
                    <div class="col-lg-6">
                        <div id="address-match">30%</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p class="font-bold">Post Cards Sent</p>
                    </div>
                    <div class="col-lg-6">
                        <div id="postcards-to-send">1500</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p class="font-bold">Conversion Rate</p>
                    </div>
                    <div class="col-lg-2">
                        <input id="conversion-rate" type="text" id="audience-size" class="form-control" value="3%">
                    </div>
                    <div class="col-lg-4">
                        <div id="conversion-rate-slider"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p class="font-bold">Incremental Orders</p>
                    </div>
                    <div class="col-lg-6">
                        <div id="incremental-orders">45</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p class="font-bold">Total Post Card Cost</p>
                    </div>
                    <div class="col-lg-6">
                        <div id="total-post-card-cost">$1500</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p class="font-bold">Cost per Acquisition</p>
                    </div>
                    <div class="col-lg-6">
                        <div id="cost-per-acquisition">$20</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p class="font-bold">Average Order Size</p>
                    </div>
                    <div class="col-lg-2">
                        <input type="text" id="average-order-size" class="form-control" value="150">
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <p class="font-bold">RoAS (based on your AoV)</p>
                    </div>
                    <div class="col-lg-6">
                        <div id="return-on-ad-spend">5.0x</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('css')
    <link href="{{ asset('css/plugins/nouislider/jquery.nouislider.css') }}" rel="stylesheet">
@endpush
@push('onload-js')
    <script src="{{ asset('js/plugins/nouislider/jquery.nouislider.min.js') }}" defer></script>
    <script src="{{ asset('js/plugins/wnumb/wnumb.min.js') }}" defer></script>
@endpush
@push('js')
    <script>
        $(document).ready(function () {
            updateCalculator();
            var conversionRate = document.getElementById('conversion-rate');
            var audienceSize = document.getElementById('audience-size');
            var averageOrderSize = document.getElementById('average-order-size');

            conversionRate.addEventListener('change', function () {
                conversionRateVal = conversionRate.value
                if (conversionRateVal.slice(-1) != '%') {
                    conversionRate.value = conversionRateVal + '%'
                    conversionRateVal = conversionRate.value;
                }
                if (parseInt(conversionRateVal.slice(0, -1)) > 0) {
                    updateCalculator()
                }

            });

            audienceSize.addEventListener('change', function () {
                audienceSizeVal = parseInt(audienceSize.value)
                updateCalculator();

            });

            averageOrderSize.addEventListener('change', function () {
                averageOrderSizeVal = parseInt(averageOrderSize.value)
                if (averageOrderSizeVal > 0) {
                    updateCalculator();
                }

            });


            function updateCalculator() {

                let audienceSize = document.getElementById('audience-size').value;
                audienceSize = audienceSize.replace(/\D/g,'');
                let estMatch = document.getElementById('address-match').innerText;
                let postCardsToSend = document.getElementById('postcards-to-send');
                postCardsToSend.innerText = Math.ceil(parseInt(estMatch.slice(0, -1)) / 100 * audienceSize);

                let conversionRate = document.getElementById('conversion-rate').value
                conversionRate = conversionRate.replace(/\D/g,'');
                let incrementalOrders = document.getElementById('incremental-orders');
                incrementalOrders.innerText = Math.ceil(conversionRate / 100 * postCardsToSend.innerText);
                let totalPostCardCost = document.getElementById('total-post-card-cost');
                let totalPostCardCostVal = Math.round(1.15 * postCardsToSend.innerText);
                totalPostCardCost.innerText = '$' + totalPostCardCostVal


                let costPerAcquisition = document.getElementById('cost-per-acquisition');
                let costPerAcqRounded = totalPostCardCost.innerText.substring(1, totalPostCardCost.innerText.length) / incrementalOrders.innerText;
                costPerAcquisition.innerText = '$' + costPerAcqRounded.toFixed(2)

                let averageOrderSize = document.getElementById('average-order-size').value;
                averageOrderSize = averageOrderSize.replace(/\D/g,'');

                let roas = document.getElementById('return-on-ad-spend');
                roasVal = averageOrderSize / costPerAcqRounded;
                roas.innerText = roasVal.toFixed(1) + 'x';

            }


            // var audience_size_slider = document.getElementById('audience-size-slider');
            //
            // noUiSlider.create(audience_size_slider, {
            //     start: 10000,
            //     behaviour: 'tap-drag',
            //     connect: 'upper',
            //     range: {
            //         'min':  600,
            //         'max':  15000
            //     }
            // });
            //
            // var inputFormat = document.getElementById('audience-size');
            //
            // audience_size_slider.noUiSlider.on('update', function (values, handle) {
            //     inputFormat.innerText = Math.round(values[handle]);
            // });
            //
            // inputFormat.addEventListener('change', function () {
            //     audience_size_slider.noUiSlider.set(this.value);
            // });
            //
            //
            // var conversion_rate_slider = document.getElementById('conversion-rate-slider');
            //
            // noUiSlider.create(conversion_rate_slider, {
            //     start: 2,
            //     behaviour: 'tap-drag',
            //     connect: 'upper',
            //     range: {
            //         'min':  1,
            //         'max':  5
            //     }
            // });
            //
            // var conversionRate = document.getElementById('conversion-rate');
            //
            // conversion_rate_slider.noUiSlider.on('update', function (values, handle) {
            //     conversionRate.innerText = Math.round(values[handle]) + '%';
            // });
        });
    </script>
@endpush
