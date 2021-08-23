<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body style="text-align: center">
        <h1 style="margin-bottom: 70px">Demo Paystack</h1>

        @if (Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Transaction</strong> {{Session::get('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form id="paymentForm">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email-address" required />
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="tel" name="amount" id="amount" required />
            </div>
            <button type="submit" class="btn btn-primary" onclick="payWithPaystack()">Submit</button>
        </form>

        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        
        <script src="https://js.paystack.co/v1/inline.js"></script> <!-- JS Paystack -->
        <script>
            var paymentForm = document.getElementById('paymentForm');
            paymentForm.addEventListener('submit', payWithPaystack, false);
            function payWithPaystack(e) {
                e.preventDefault();
                var handler = PaystackPop.setup({
                  key: 'pk_test_a93f80a4bbf031f1c0029d06614342ac5af02842', // Replace with your public key
                  email: document.getElementById('email-address').value,
                  amount: document.getElementById('amount').value * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
                  currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars. Default Currency is NGN for Nigeria
                  ref: ''+Math.floor((Math.random() * 1000000000) + 1), // Get Default Random References for Initialize transaction
                  callback: function(response) {
                    window.location = 
                        "http://127.0.0.1:8000/pay/verify/transaction?reference=" + response.reference;
                  },
                  onClose: function() {
                    alert('Transaction was not completed, window closed.');
                    window.location = "http://127.0.0.1:8000/pay"
                  },
                });
              handler.openIframe();
            }
        </script> 
    </body>
</html>