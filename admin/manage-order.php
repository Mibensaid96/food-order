<?php include 'partials/menu.php'; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>
        
            <br><br>
            
                <?php 
                    if(isset($_SESSION['update'])){
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    } 
                    
                    if(isset($_SESSION['flash'])){
                        echo $_SESSION['flash'];
                        unset($_SESSION['flash']);
                    }
                    
                ?>
        
                 <br><br>

                <table class="tbl-full">
                    <tr>
                        <th>S.N</th>
                        <th>Food</th>
                        <th>Price</th>
                        <th>Qty.</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Customer Name</th>
                        <th>Customer Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        // get all orders from DB
                        $sql = "SELECT tbl_order.*, order_items.item_id, order_items.product_name, order_items.product_price, order_items.product_quantity 
                                FROM order_items
                                    INNER JOIN tbl_order
                                ON order_items.order_id = tbl_order.order_id
                                ORDER BY tbl_order.order_id DESC"; // display latest order at first

                        $res = mysqli_query($conn, $sql);

                        $sn = 1; // Serial Number

                        $count = mysqli_num_rows($res);

                        if($count > 0){
                            //
                            while($row = mysqli_fetch_assoc($res)){
                                $order_id = $row['order_id'];
                                $item_id = $row['item_id'];
                                $food = $row['product_name'];
                                $price = $row['product_price'];
                                $qty = $row['product_quantity'];
                                $total = $row['order_cost'];
                                $order_date = $row['order_date'];
                                $status = $row['order_status'];
                                $customer_name = $row['user_name'];
                                $customer_contact = $row['user_phone'];
                                $customer_email = $row['user_email'];
                                $customer_address = $row['user_city'];
                            ?>
                      
                    <tr>
                        <td><?php echo $sn++; ?>.</td>
                        <td><?php echo $food; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $qty; ?></td>
                        <td><?php echo $total; ?></td>
                        <td><?php echo $order_date; ?></td>
                        <td>
                            <?php 
                                if($status == "Ordered"){ // Ordered, On Delivery, Delivered, Cancelled
                                    echo "<label>$status</label>";

                                } elseif($status == "On Delivery") {
                                    echo "<label style='color: orange'>$status</label>";
                                } elseif($status == "Delivered") {
                                    echo "<label style='color: green'>$status</label>";
                                } elseif($status == "Cancelled") {
                                    echo "<label style='color: red'>$status</label>";
                                }
                            ?>
                        </td>
                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $customer_contact; ?></td>
                        <td><?php echo $customer_email; ?></td>
                        <td><?php echo $customer_address; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-order.php?order_id=<?php echo $order_id; ?>&item_id=<?php echo $item_id; ?>" class="btn-secondary">Update Order</a>
                        </td>
                    </tr>
                    
                            <?php
                            }
                        } else {
                            //
                            echo "<tr><td colspan='12' class='error'>Orders not Available</td></tr>";
                        }

                    ?>
                    
                </table>
    </div>
</div>



<?php include 'partials/footer.php'; ?>
