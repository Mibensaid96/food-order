<?php include 'partials/menu.php'; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>
        
        <?php
            if(isset($_GET['order_id'])){
                
                $order_id = $_GET['order_id'];
                $item_id = $_GET['item_id'];
                
                // Query to get order details
                $req1 = "SELECT order_items.product_name, order_items.product_price, order_items.product_quantity, tbl_order.order_status FROM order_items
                INNER JOIN tbl_order
                    ON order_items.order_id = tbl_order.order_id 
                WHERE tbl_order.order_id=$order_id AND order_items.item_id=$item_id";
                
                $res_req1 = mysqli_query($conn, $req1);

                $count_req1 = mysqli_num_rows($res_req1);
                
                $req2 = "SELECT tbl_users.user_address, tbl_order.user_name, tbl_order.user_email, tbl_order.user_phone FROM tbl_users
                INNER JOIN tbl_order
                    ON tbl_users.id = tbl_order.user_id
                WHERE tbl_order.order_id=$order_id";
                
                $res_req2 = mysqli_query($conn, $req2);

                $count_req2 = mysqli_num_rows($res_req2);

                if($count_req1 == 1 && $count_req2 == 1) {
                    // 
                    $row1 = mysqli_fetch_assoc($res_req1);
                    
                    
                    $food = $row1['product_name'];
                    $price = $row1['product_price'];
                    $qty = $row1['product_quantity'];
                    $status = $row1['order_status'];
                    
                    
                    $row2 = mysqli_fetch_assoc($res_req2);
                    
                    $customer_name = $row2['user_name'];
                    $customer_contact = $row2['user_phone'];
                    $customer_email = $row2['user_email'];
                    $customer_address = $row2['user_address'];
                    
                    
                } else {
	                // Redirect to Manage order page
                    $_SESSION['update'] = "<div class='col-3 error'>La requete a echoué.</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');

                }
                
                $order_id = $_GET['order_id'];
                $item_id = $_GET['item_id'];
            } else {
                //
                $_SESSION['update'] = "<div class='col-3 error'>order_id non defini.</div>";
                header('location:'.SITEURL.'admin/manage-order.php');
            }
        
        ?>
        
        <form action="" method="POST">
            
            <table class="tbl-30">
                <tr>
                    <td>Food Name</td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><b>$<?php echo $price; ?></b></td>
                </tr>
                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){ echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="On Delivery"){ echo "selected";} ?> value="On Delivery">On Delivery</option>
                            <option <?php if($status=="Delivered"){ echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled"){ echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Customer Name: </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Contact: </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Email: </td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Address: </td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
                
            </table>
            
        </form>
        
        <?php
        
        if (isset($_POST['submit'])) {
	        // get all values from form>
            $order_id = $_POST['order_id'];
            $item_id = $_POST['item_id'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];

            $total = $price * $qty;

            $status = $_POST['status'];

            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];

            // update values utiliser prepare()
            $sql2 = "UPDATE tbl_order SET
                     order_status='$status' 
                     WHERE order_id=$order_id 
                    ";
            
            $res2 = mysqli_query($conn, $sql2);
            
            
            // Redirect to Manage Order with msg
            
            if($res2 == true){
                $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-order.php');
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                header('location:'.SITEURL.'admin/manage-order.php');
            }

            $count2 = mysqli_num_rows($res2);


        }
        
        ?>
        
    </div>
</div>


<?php include 'partials/footer.php'; ?>
