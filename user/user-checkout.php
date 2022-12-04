<?php

include 'partials-user/header.php';

if (!isset($_SESSION['order']) || empty($_SESSION['order'])) { // si user n'a pas de cmd 
	header('location: ../index.php'); // rediriger a l'acceuil
} elseif (!$_SESSION['auth']) { // s'il n'est pas connecter
    header('location: user-login.php'); // rediriger a la page de login
    exit();
}


?>

  <?php  ?>


  <!-- end header section -->

  </div>

  <!-- food section -->

  <section class="food_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Checkout
        </h2>
      </div>

   

       <!-- Checkout -->
    <section class="my-2 py-3 checkout">

        <div class="mx-auto container">
            
            <form id="checkout-form" action="place_order.php" method="POST">
                <div class="form-group checkout-small-element">
                    <label for="">Name</label>
                    <input type="text" class="form-control" id="checkout-name" name="name" placeholder="name" required>
                </div>

                <div class="form-group checkout-small-element">
                    <label for="">Email</label>
                    <input type="email" class="form-control" id="checkout-email" name="email" placeholder="email address" required>
                </div>

                <div class="form-group checkout-small-element">
                    <label for="">Phone</label>
                    <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="phone number" required>
                </div>

                <div class="form-group checkout-small-element">
                    <label for="">City</label>
                    <input type="text" class="form-control" id="checkout-city" name="city" placeholder="city" required>
                </div>


                <div class="form-group checkout-small-element">
                    <label for="">Address</label>
                    <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Delivery address" required>
                </div>


                <div class="form-group checkout-btn-container">
                    <p>Total amount: <?php echo "$". $_SESSION['total']; ?></p>
                    
                    <input type="hidden" name="order" value="<?php echo $_SESSION['order']; ?>">
                    
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['auth']['id']; ?>">
                    
                    <input type="submit" class="btn" id="checkout-btn" name="checkout_btn" value="Checkout">
                </div>
   
            </form>
        </div>
    </section>



    </div>
  </section>

  <!-- end food section -->



  <?php include 'partials-user/footer.php'; ?>
