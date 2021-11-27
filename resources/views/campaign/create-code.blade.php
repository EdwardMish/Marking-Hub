<div class="ibox ">
    <div class="ibox-title">
        <h5>Step 4: Create Your Offer</h5>
    </div>
    <div class="ibox-content">
        <p>Statistics show that customers are more likely to convert when presented an offer.
            Each customer’s
            post card will come with a custom printed code they can use at checkout</p>

        <div class="row">
            <div class="col-lg-3">
                <div class="form-group"><label>Offer Type</label><select class="form-control m-b"
                                                                         name="discount_type"
                                                                         id="input_discount_type">
                        <option value="1">% Off</option>
                        <option value="2">Flat Discount</option>
                    </select></div>
            </div>
            <div class="col-lg-3">
                <div class="form-group"><label>Amount</label><input class="form-control" name="discount_amount"
                                                                    id="input_discount_amount" value="10"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                Discount Prefix
            </div>
            <div class="col-lg-3">
                <input class="form-control" name="discount_prefix" id="input_discount_prefix" value="
{{ preg_replace("/[^A-Z0-9 ]/", '', strtoupper(substr($userShop, 0,6))) }}">
            </div>
            <div class="col-lg-6">
                <p id="discount-code-sample"></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <button class="btn btn-primary btn-lg" name="submit" value="start" type="submit">Start Campaign</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function () {

            let discountPrefix = document.getElementById('input_discount_prefix');
            let discountType = document.getElementById('input_discount_type');
            let discountAmount = document.getElementById('input_discount_amount');
            updateOfferAmount(discountType.value)
            updateOfferDescription(discountPrefix.value, discountAmount.value)

            discountType.addEventListener('change', function () {
                updateOfferAmount(this.value)
                updateOfferDescription(discountPrefix.value, discountAmount.value)
            });

            discountAmount.addEventListener('change', function () {
                updateOfferAmount(discountType.value)
                updateOfferDescription(discountPrefix.value, discountAmount.value)
            });

            discountPrefix.addEventListener('change', function () {
                updateOfferDescription(discountPrefix.value, discountAmount.value)
            });
        });

        function updateOfferAmount($offerType) {
            let discountAmount = document.getElementById('input_discount_amount');
            let discountAmountVal = discountAmount.value
            discountAmountVal = discountAmountVal.replace(/\D/g, '');
            if ($offerType == 1) {
                discountAmount.value = discountAmountVal + '%';
            } else if ($offerType == 2) {
                discountAmount.value = '$' + discountAmountVal;
            }
        }

        function updateOfferDescription($discountPrefix, $discountAmount) {
            let discountDescription = document.getElementById('discount-code-sample');
            discountDescription.innerText = 'Ex. Code: `' + $discountPrefix + '-ABC123` grants ' + $discountAmount + ' off purchases'

        }

    </script>
@endpush
