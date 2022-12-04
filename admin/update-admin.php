<?php include'partials/menu.php' ?>

<div class="main-content">
    
    <div class="wrapper">
        <h1>Update Admin</h1>
        
        <br /><br>
        
        <?php 
            // Get the ID of selected Admin
            $id = $_GET['id'];
    
            // SQL query to get the details
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";

            $res = mysqli_query($conn, $sql);
    
            if($res == true){ // Verifier si la req est executee ou non
                
                // checker s'il ya des admin enregistres ou non
                $count = mysqli_num_rows($res);
                if($count == 1) {
                    // get the details
                    $row = mysqli_fetch_assoc($res);
                    
                    $full_name = mysqli_real_escape_string($conn, $row['full_name']);
                    $username = mysqli_real_escape_string($conn, $row['username']);
                } else {
                    // redirect to Manage Admin page
                    header('location:'.SITEURL.'admin/manage-admin.php'); 
                }
            } 
                        
        ?>
                <br><br><br>
        
        
        
    <form action="" method="POST">
        
        <table class="tbl-30">
            <tr>
                <td>Full Name: </td>
                <td>
                    <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                </td>
            </tr>
            <tr>
                <td>Userame: </td>
                <td>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                </td>
            </tr>
        </table>
        
    </form>
        
        
    </div>
    
</div>


<?php 
// checker si le btn submit est cliquE ou non
if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    
    // SQL query to update Admin
    $sql = "UPDATE tbl_admin SET
            full_name = '$full_name',
            username = '$username'
            WHERE id='$id'
            ";
    // execute 
    $res = mysqli_query($conn, $sql);
    
    if($res == true){ // if query executed and Admin updated
        
        $_SESSION['update'] = "<div class='success'>Admin Updated Successfully</div>";
        
        header('location:'.SITEURL.'admin/manage-admin.php');
    } else {
        
        $_SESSION['update'] = "<div class='error'>Failed to  Updated Admin</div>";
        
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
}

?>


<?php include'partials/footer.php'; ?>