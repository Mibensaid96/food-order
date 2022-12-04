<?php

session_start();



include("partials-user/header.php"); 


if(isset($_SESSION['order_id']) && $_SESSION['order_id'] != 0 && isset($_SESSION['total']) && $_SESSION['total'] != 0 ) {
    
    $order_id = $_SESSION['order_id'];
    $total = $_SESSION['total'];
    $products_bought = $_SESSION['order'];

    // vider la session car le paiement est reussi
    session_unset();
    session_destroy();

} else {
	header("location: ../index.php");
}


?>

<!-- end header section -->

  </div>

    <!-- Payment -->
    <section class="my-1 py-5 checkout">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Payment</h2>
            <hr class="mx-auto">
        </div>

            <div class="mx-auto container text-center">
        
                      
                      <?php if (isset($_GET['success_message'])) { ?>
                            <h3 style="color: green;"><?php echo $_GET['success_message']; ?></h3>
                      <?php } ?>
                      
                      <p><?php echo "order id: ". $order_id; ?></p>
                      <p><?php echo "please keep order id in save place for future reference"; ?></p>
                      <p>We will deliver your meals within 45 minutes</p>
                      

            

            </div>
           
        </div>
    </section>



<?php include("partials-user/footer.php"); ?>
