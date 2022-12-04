<?php include 'partials/menu.php'; ?>

		<!-- Main Content section Starts-->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Admin</h1>
                
                <br />
                
                <?php 
                    if(isset($_SESSION['add'])){ // check whether the session for adding Amin is set or not
                        echo $_SESSION['add'];
                        unset($_SESSION['add']); // retirer le msg apres chargmt de la page
                    } 
                
                    if(isset($_SESSION['delete'])){ // check whether the session for deleting Admin is set or not
                        
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }
                
                    if(isset($_SESSION['update'])){ // check whether the session for updating Admin is set or not
                        
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                
                    if(isset($_SESSION['user-not-found'])){ // Si l'admin n'existe pas 
                        
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                    }
                
                    if(isset($_SESSION['pwd-not-match'])){ // Si le nvx pwd n'est pas identique a la confirmation
                        
                        echo $_SESSION['pwd-not-match'];
                        unset($_SESSION['pwd-not-match']);
                    }
                
                    if(isset($_SESSION['change-pwd'])){ // Si l'admin tout est correct 
                        
                        echo $_SESSION['change-pwd'];
                        unset($_SESSION['change-pwd']);
                    }
                ?>
                <br><br><br>
                
                <!-- Button to Add Admin    -->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>
                
                <br /><br />
                
                <table class="tbl-full">
                    <tr>
                        <th>S.N</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>
                    
                <?php
                    $sql = "SELECT * FROM tbl_admin"; // get all Admin
                    $res = mysqli_query($conn, $sql);
                        
                    if($res == TRUE){
                        // count Rows to check whether we have data in DB or not
                        $count = mysqli_num_rows($res); // fct to get all the rows in tbl
                        
                        $sn = 1; // pour enumerer les admin
                            
                        if($count > 0) {
                            // we have data in DB
                            while($rows = mysqli_fetch_assoc($res)){
                                    
                                // get individual data
                                $id = $rows['id'];
                                $full_name = $rows['full_name'];
                                $username = $rows['username'];
                                    
                    // display the value in our tbl
                ?>
                    
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $full_name; ?></td>
                        <td><?php echo $username; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a> 
                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delate Admin</a> 
                        </td>
                    </tr>

                <?php       
                                }
                        } else {
                            // we don't have data in DB
                        }
                    }
                ?>
                    
                    
                </table>
                
            </div>
        </div>

		<!-- Main Content section Ends -->


<?php include 'partials/footer.php'; ?>
