<?php session_start(); ?>

<?php include("partials-user/header.php"); ?>


<!-- end header section -->

  </div>

    <!-- Payment -->
    <section class="my-1 py-5 checkout">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Payment</h2>
            <hr class="mx-auto">
        </div>

            <div class="mx-auto container text-center">
        

              <?php if(isset($_SESSION['order_id']) && $_SESSION['order_id'] != 0
                        && isset($_SESSION['total']) && $_SESSION['total'] != 0 ) {?>
                 
                      <?php $amount = strval($_SESSION['total']); ?>
                  
                       <p>Total: <?php echo "$". $_SESSION['total']; ?></p>

                         <!--Set up a container element for the button -->
                         <div id="paypal-button-container"></div>



              <?php } else { ?>

                       <p>you don't have an order</p> 

              <?php } ?>  

            

            </div>
           
        </div>
    </section>


<!-- Include the PayPal JavaScript SDK; replace "test" with your own sandbox Business account app client ID -->
<script src="https://www.paypal.com/sdk/js?client-id=AVJvuzFfibnGBnbGG_csDBB5ybbnlb-N_n7Y9DUVZFyc-NLkB1occ7N4Na__aoHp7Ae5KTOcjAlVxnLY&currency=USD"></script>


<script>
  paypal.Buttons({

    // Sets up the transaction when a payment button is clicked
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '<?php echo $amount;?>' // Can reference variables or functions. Example: `value: document.getElementById('...').value`
          }
        }]
      });
    },

    // Finalize the transaction after payer approval
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(orderData) {
        // Successful capture! For dev/demo purposes:
        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
        var transaction = orderData.purchase_units[0].payments.captures[0];
        alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');


        window.location.href = "complete_payment.php?transaction_id="+transaction.id;
       
        // When ready to go live, remove the alert and show a success message within this page. For example:
        // var element = document.getElementById('paypal-button-container');
        // element.innerHTML = '';
        // element.innerHTML = '<h3>Thank you for your payment!</h3>';
        // Or go to another URL:  actions.redirect('thank_you.html');
      });
    }
  }).render('#paypal-button-container');

</script>



<?php include("partials-user/footer.php"); ?>