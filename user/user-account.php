<?php 
require_once '../config/functions.php';
logged_only();



if(!empty($_POST)){
    
    if(!empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        
        $_SESSION['flash']['error'] = "Les mots de passe ne correspondent pas";
    } else {
        $user_id = $_SESSION['auth']['id'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        require_once '../config/constants.php';
        
        $sql = "UPDATE tbl_users SET password = '$password'"; // utiliser prepare() voir user-forget.php
        $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour";
    }
    
    
}

require_once 'partials-user/header.php'; 
//var_dump($_SESSION['auth']);
?>

<div id="anim" class="container ">
    <div>
        <h1>Content de vous revoir <?= $_SESSION['auth']['username']; ?></h1>
    </div>
    <br>
    
    <section class="">
        <!-- Tab links -->
        <div class="tab">
          <button class="tablinks" onclick="openTab(event, 'Orders')" id="">Orders</button>
          <button class="tablinks" onclick="openTab(event, 'Information')">Personal Information</button>
        </div>
        
        <!-- Tab content -->
        <div id="Orders" class="tabcontent">
          <h4>Orders:</h4>
          <br>
            <table class="">
                <tr class="orangered">
                <th>items</th>
                <th>Prix</th>
                <th>Etat</th>
                <th>Date</th>
                <th>Quantity</th>
                <th>Subtotal</th>
        <!--                <th >total</th>-->
                </tr>

            <?php 
                if (isset($_SESSION['auth'])) { 

                $user_id = $_SESSION['auth']['id'];

                /*utiliser prepare()*/
                $sql2 = "SELECT tbl_order.*, order_items.product_name, order_items.product_price, order_items.product_quantity FROM order_items
                INNER JOIN tbl_order
                    ON order_items.order_id = tbl_order.order_id
                WHERE (tbl_order.user_id = $user_id) AND (order_items.order_id = tbl_order.order_id)"; // 

                $res2 = mysqli_query($conn, $sql2);

                // check whether this user has orders in the DB
                $count2 = mysqli_num_rows($res2);

                
            ?>

                  <?php 

                    if($count2 > 0) {
                    // get values 
                    while($rows = mysqli_fetch_assoc($res2)) {

                        $order_id = $rows['order_id'];
                        $product_price = $rows['product_price'];
                        $order_status = $rows['order_status'];
                        $order_date = $rows['order_date'];
                        $product_name = $rows['product_name'];
                        $product_quantity = $rows['product_quantity'];
                        $total = $rows['order_cost'];

        //                print_r($row);


                    ?>

                <tr rowspan="2 ">

                    <td class="orange">
                      <p><?php echo $product_name; ?></p>
                    </td>
                    <td class="orange">
                      <p><?php echo $product_price; ?></p>
                    </td>
                    <td class="orange">
                      <p><?php echo $order_status; ?></p>
                    </td>

                    <td class="orange">
                      <p><?php echo $order_date; ?></p>
                    </td>

                    <td class="orange">
                      <p class=""><?php echo $product_quantity; ?></p>
                    </td>

                    <td class="orange">
                      <p class=""><?php echo $product_quantity * $product_price; ?></p>
                    </td>

                  </tr>
                  <?php } ?>


            </table>

           <br>


           <table>
               <tr>
                   <th class="orangered">total</th>
                   <td class="orange">$<?php echo $total; ?></td>
               </tr>
           </table>
           <br>

                <?php } ?>


                <?php 
                    

                    }else {
                            $_SESSION['flash']['error'] = "Veuillez vous connecter pour acceder à cette page";
                        } 
                ?>

            <?php  ?>

            
        </div>

        <div id="Information" class="tabcontent ">
            <br>
            <div class="row">
                
                <div class="col-25">
                <h4>Personal Information:</h4>
                <br>
                <form action="" method="POST" id="infoForm">
                    <?php /*foreach($_SESSION['auth'] as $key => $value) { */
                                // debug($value);
                ?>
                    <div class="order-label">
                        <label for="">Pseudo</label>
                        <input type="text" placeholder="<?= $_SESSION['auth']['username']; ?>" name="username" class="input-register" />
                    </div>
<!--
                    
                    <div class="order-label">
                        <label for="">First Name</label>
                        <input type="text" name="firstname" class="input-register" />
                    </div>
                    <div class="order-label">
                        <label for="">Last Name</label>
                        <input type="text" name="lastname" class="input-register" />
                    </div>
-->

                    <div class="order-label">
                        <label for="">Address</label>
                        <input type="text" placeholder="<?= $_SESSION['auth']['user_address']; ?>" name="address" placeholder="address" class="input-register" />
                    </div>

                    <div class="order-label">
                        <label for="">Email</label>
                        <input type="text" placeholder="<?= $_SESSION['auth']['email']; ?>" name="email" class="input-register" />
                    </div>

                    <div class="order-label">
                        <label for="">Phone number</label>
                        <input type="tel" placeholder="<?= $_SESSION['auth']['phone']; ?>" name="username" class="input-register" />
                    </div>

<!--
                    <div class="order-label">
                        <label for="">Date of birthday</label>
                        <input type="date" name="username" class="input-register" />
                    </div>
-->
                    
                    <div class="order-label">
                        <input class="btn" type="submit" name="submit" value="UPDATE">
                   </div>
                    
                <?php //} ?>
                </form>
                </div>
                
                <div class="col-25">
                    <h4>Changement de mot de passe: </h4>
                    <br><br>
                <form action="" method="POST">
                    
                    <div class="form-group">
                        <input class="input-register" type="password" name="password" placeholder="Changer de mot de passe">
                    </div>
                    <div class="form-group">
                        <input class="input-register" type="password" name="password_confirm" placeholder="Confirmation du mot de passe">
                    </div>
                    <br>
                    <div class="order-label">
                        <div class="col-25"></div>
                        <div class="col-50">
                            <input class="btn" type="submit" name="submit" value="Change Password">
                        </div>
                        <div class="col-25"></div>
                    </div>
                    
                </form>
                </div>
                
                
            </div>
            
        </div>
        
        
    </section>
    <br>
    
</div>

<?php require 'partials-user/footer.php'; ?>