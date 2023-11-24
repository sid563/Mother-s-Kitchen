<?php include('partials/menu.php'); ?>

<div class="main-content">
        <div class="wrapper">
                <h1>Change Password</h1>
                <br /><br />
                <?php
                        if(isset($_GET['id']))
                        {
                                $id=$_GET['id'];
                        }
                ?>
                

                <form action="" method="POST">
                
                        <table class="tbl-30">
                                <tr>
                                        <td>Current Password:</td>
                                        <td>
                                                <input type="password" name="current_password" placeholder="Old Password">
                                        </td>
                                </tr>
                                <tr>
                                        <td>New Password:</td>
                                        <td>
                                                <input type="password" name="new_password" placeholder="New Password">
                                        </td>
                                </tr>
                                <tr>
                                        <td>Conform Password:</td>
                                        <td>
                                                <input type="password" name="conform_password" placeholder="Conform Password">
                                        </td>
                                </tr>         
                                <tr>
                                        <td colspan="2">
                                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                                <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                                        </td>
                                </tr>  

</table>
</form>


        </div>
</div>     

<?php
        //check whether submit button is clicked or not
        if(isset($_POST['submit']))
        {
            //echo "Button Clicked";

            //1.Get the data from form
            $id=$_POST['id'];
            $current_password=md5($_POST['current_password']);
            $new_password=md5($_POST['new_password']);
            $conform_password=md5($_POST['conform_password']);
            //2.Check whether the user with current ID and Current Password is Exist or not
            $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";
            //Execute the Query
            $res= mysqli_query($conn,$sql);
            if($res==true)
            {
                //check whether data is available or not
                $count=mysqli_num_rows($res);

                if($count==1)
                {
                        //User Exist and password can be changed
                       // echo "User Found";
                       //Check whether the New Password and Conform Password Match or not
                       if($new_password==$conform_password)
                       {
                           //Update the password
                           //echo "pass match";
                           $sql2="UPDATE tbl_admin SET
                           password='$new_password'
                           WHERE id=$id";

                           //Execute the query
                           $res2=mysqli_query($conn,$sql2);

                           //check whether query is executed or not
                           if($res2==true)
                           {
                                //Display success Message
                                //Redirect to manage admin page with error message
                           $_SESSION['change-pwd']= "<div class='success'>Password changed Successfully.</div>";
                           header('location:'.SITEURL.'admin/manage-admin.php');
                           }
                           else
                           {
                                //Redirect to manage admin page with error message
                           $_SESSION['change-pwd']= "<div class='error'>Password didn't change.</div>";
                           header('location:'.SITEURL.'admin/manage-admin.php');
                           }
                       }
                       else
                       {
                           //Redirect to manage admin page with error message
                           $_SESSION['pwd-not-match']= "<div class='error'>Password didn't match.</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');
                       }

                }
                else
                {
                        //User doesn't exist, Set Message and Redirect
                        $_SESSION['user-not-found']= "<div class='error'>User Not Found.</div>";
                        header('location:'.SITEURL.'admin/manage-admin.php');

                }
            }
            
            //3.Check whether the New Password and Conform Password Match or not

            //4.Change Password if all above is true
        }
?>


<?php include('partials/footer.php'); ?>