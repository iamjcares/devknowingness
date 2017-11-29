<?php include('includes/header.php'); ?>

<?php if ($type == 'index'): ?>

    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <h2 class="form-signin-heading">Please Payment Method</h2>
    <div class="form-signin">
        <div id="paypal-button"></div>
    </div>

    <script>
        var CREATE_PAYMENT_URL = '<?= URL::to('payment/create') ?>';
        var EXECUTE_PAYMENT_URL = '<?= URL::to('payment/execute') ?>';

        paypal.Button.render({
            env: 'sandbox', // Or 'sandbox'

            commit: true, // Show a 'Pay Now' button

            style: {
                color: 'gold',
                size: 'medium'
            },
            payment: function () {
                return paypal.request.post(CREATE_PAYMENT_URL).then(function (data) {
                    return data.id;
                });
            },
            onAuthorize: function (data) {
                return paypal.request.post(EXECUTE_PAYMENT_URL, {
                    paymentID: data.paymentID,
                    payerID: data.payerID
                }).then(function () {
                    //window.location = '/payment/check';
                });
            }

        }, '#paypal-button');
    </script>
<?php endif; ?>

<?php include('includes/footer.php'); ?>