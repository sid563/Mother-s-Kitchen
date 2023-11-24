<?php include('../config/constants.php'); ?>

<html>
<head>
        
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
        <div class="login">
                <h1 class="text-center">Login</h1>
                <br /><br />

                <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
               
                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>

                <!--Login form starts here  -->

                <form action="" method="POST" class="text-center">
                Username:<br />
                <input type="text" name="username" placeholder="Enter Your Username"><br /><br />
                Password:<br />
                <input type="password" name="password" placeholder="Enter Your Password"><br /><br />
                <input type="submit" name="submit" value="Login" class="btn-primary">  
                <br /><br />             
                </form>

                <!--Login form ends here  -->
                <p class="text-center">Created By - <a href="#">Sidharth Singh</a></p>
        </div>
</body>
</html>
<?php
     //Check whether submit button is clicked or not
     if(isset($_POST['submit']))
     {
        //Process for login
        //1.Get the data from login form
        $username=$_POST['username'];
        $password=md5($_POST['password']);

        //2.SQL to check wether the user with username and password exist or not
        $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
        //3.Execute the query
        $res=mysqli_query($conn,$sql);
        //4.Count rows to check whether user Exist or Not
        $count=mysqli_num_rows($res);

        if($count==1)
        {
                // User available and login Success
                $_SESSION['login']="<div class='success'>Login Successfully.</div>";
                $_SESSION['user']=$username;//To check whether user is logged in or not AND Logout will unset it.
                //Redirect to Home Page/ Dashboard
                header('location:'.SITEURL.'admin/');

        }
        else
        {
                // User not available and login fail
                $_SESSION['login']="<div class='error text-center'>Usermane or Password did not match.</div>";
                //Redirect to Home Page/ Dashboard
                header('location:'.SITEURL.'admin/login.php');
        }


     }
?>