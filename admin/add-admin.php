<?php include'partials/menu.php'; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        
        <br />
        
        <?php 
            if(isset($_SESSION['add'])){ // Verifier si la session est definie
                echo $_SESSION['add'];
                unset($_SESSION['add']); // retirer le msg apres chargmt de la page
            } 
                        
        ?>
                <br><br><br>
                
        <form action="" method="POST">
            
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name"  placeholder="Enter Your Name"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username"  placeholder="Enter Your Username"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password"  placeholder="Enter Your Password"></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit"  value="Add Admin" class="btn-secondary">
                    </td>
                    
                </tr>
                
            </table>
        </form>
    </div>
</div>


<?php include'partials/footer.php'; ?>


<?php
// Process the value from Form and save it in DB

// Check whther the submit btn is clicked or not

if(isset($_POST['submit'])) {
    
    // get the data from Form
    
    
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']); // fct protègeant les caractères spéciaux d'une chaîne pour l'utiliser dans une requête SQL
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    
    $raw_password = md5($_POST['password']); 
    $password = mysqli_real_escape_string($conn, $raw_password);
    
    // SQL Query save the data into tbl_admin
    $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'";
    
    // Execute Query and save data in DB
    $res = mysqli_query($conn, $sql) or die(mysqli_error());
    
    // Check whther the data is insrted or not and display appropriate msg
    if ($res == TRUE) {
        //	echo " Data inserted";
        
        $_SESSION['add'] = "Admin Added Successfully";
        header("location:".SITEURL.'admin/manage-admin.php'); // redirect Page to Manage Admin;
    } else {
        //  echo "Faile to insert Data";
        
        $_SESSION['add'] = "Failed to Add Admin";
        header("location:".SITEURL.'admin/add-admin.php'); // redirect Page to Add Admin;
    }


} 

?>

