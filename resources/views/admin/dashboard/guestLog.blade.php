<div class="logs guest">
    <h2>WALK-IN SUBSCRIPTION</h2>
    <form id="guest_attendee" class="guest-form" action="{{ route('guest.store') }}" method="post">
        @csrf

        <div class="personal-information">
            <h4>Guest Information</h4>
            <div class="form-group">
                <input type="text" id="first_name" name="first_name" placeholder="First Name" required/>
                <input type="text" id="last_name" name="last_name" placeholder="Last Name"/>
            </div>

            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Email Address"/>
                <input type="text" id="phone" name="phone" placeholder="Phone Number" required/>
            </div>

            <div class="form-group">
                <input type="text" id="city" name="city" placeholder="City"/>
                <input type="text" id="province" name="province" placeholder="Province"/>
            </div>
        </div>
        <div class="payment">
            <div class="form-group payment-method">
                <h4>Payment Method</h4>
                <div class="payment-options">
                    <label>
                        <input type="radio" name="payment_method" value="cash" required checked> Cash
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="gcash" required> GCash
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="card" required> Card
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="other" id="other-payment"> Other
                    </label>

                    <!-- "Other" Payment Method Input Field -->
                    <div id="other-payment-method" style="display:none;">
                        <input type="text" name="other_payment_method" placeholder="Please specify">
                    </div>
                </div>
            </div>

            <button type="submit">Submit</button>
        </div>
    </form>
</div>

<script>
    // Show/Hide "Other" field based on user selection
    document.querySelectorAll('input[name="payment_method"]').forEach(function (radio) {
        radio.addEventListener('change', function() {
            if (document.getElementById('other-payment').checked) {
                // Show the "Other" payment method input and make it required
                document.getElementById('other-payment-method').style.display = 'block';
                document.querySelector('input[name="other_payment_method"]').setAttribute('required', 'required');
            } else {
                // Hide the "Other" payment method input and remove the required attribute
                document.getElementById('other-payment-method').style.display = 'none';
                document.querySelector('input[name="other_payment_method"]').removeAttribute('required');
            }
        });
    });
</script>