<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        
        <br><br>

        <?php
             if(isset($_SESSION['add']))//Checking whether session is set or not
                {
                    echo $_SESSION['add'];//Display the Session Message if Set
                     unset($_SESSION['add']);//Remove Session Message
                }
        ?>
         <?php
             if(isset($_SESSION['upload']))//Checking whether session is set or not
                {
                    echo $_SESSION['upload'];//Display the Session Message if Set
                     unset($_SESSION['upload']);//Remove Session Message
                }
        ?>
         <br><br>

        <!-- Add Category Form Starts --> 
        <form action="" method="POST" enctype="multipart/form-data">

             <table class="tbl-30">
                  <tr>
                      <td>Title: </td>
                      <td>
                        <input type="text" name="title" placeholder="Category Title">
                      </td>
                  </tr>
                  <tr>
                      <td>Select Image: </td>
                      <td>
                        <input type="file" name="image" placeholder="Category Title">
                      </td>
                  </tr>
                  <tr>
                        <td>Featured:</td>
                        <td>
                                <input type="radio" name="featured" value="Yes">Yes
                                <input type="radio" name="featured" value="No">No
                        </td>
                  </tr>
                  <tr>
                        <td>Active:</td>
                        <td>
                                <input type="radio" name="active" value="Yes">Yes
                                <input type="radio" name="active" value="No">No
                        </td>
                  </tr>
                  <tr>
                         <td colspan="2">
                                <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                         </td>
                  </tr>
            </table>
        </form>

        <!-- Add Category Form Ends -->

   </div>

</div>

<?php include('partials/footer.php'); ?>

<?php
//Process the value from Form and Save it in Database

//Check whether the submit button is clicked or not

if(isset($_POST['submit']))
{
        //Button Clicked
       //echo "Button Clicked";

       //1.Get the Data from form
      $title=$_POST['title'];

      //For radio input,we need to check whether any radio button is clicked or not
      if(isset($_POST['featured']))
      {
           //Get the value from form
           $featured=$_POST['featured'];
      }
      else
      {
          //Set the default value
          $feature="No";
      }
      if(isset($_POST['active']))
      {
           //Get the value from form
           $active=$_POST['active'];
      }
      else
      {
          //Set the default value
          $active="No";
      }
      // Check whether image is selected or not and set the value for image name
      //print_r($_FILES['image']);
      // die();//Break the code here
      //Get Ex:  Array ( [name] => gfds.jpeg [full_path] => gfds.jpeg [type] => image/jpeg [tmp_name] => E:\xampp\tmp\php7ED2.tmp [error] => 0 [size] => 165973 ) 
     if(isset($_FILES['image']['name']))
     {
         //Upload the image in database
         //to upload image we need image name, source path and destination path
         $image_name=$_FILES['image']['name'];

        //Auto rename our image
        //Get the extension of our image(jpg, png, gif, jpeg etc) e.g. "food1.jpg","specialfood.jpg"...
        $ext=end(explode('.',$image_name));

        //Rename the image
        $image_name="Food_Category_".rand(000,999).'.'.$ext;  //e.g.  Food_Category_775.jpg


         $source_path=$_FILES['image']['tmp_name'];
         $destination_path="../images/category/".$image_name;

         //Finally upload the Image
         $upload=move_uploaded_file($source_path,$destination_path);

         //Check whether image is uploaded or not
         //And if image is not uploaded then we will stop the process and redirect with error message
         if($upload==false)
         {
                //Set Message
                $_SESSION['upload']="<div class='error'>Failed to Upload Image.</div>";
                //Redirect to add Category page
                header('location:'.SITEURL.'admin/add-category.php');
                //Stop the process
                die();
         }
     }
     else
     {
         //Don't upload the image and set the image_name value as blank
         $image_name="";
     }
     

         //2.SQL Query to save the data into database
         $sql="INSERT INTO tbl_category SET
         title='$title',
         image_name='$image_name',
        featured='$featured',
        active='$active'
       ";
        
        //3.Execute query and save data in database
       $res=mysqli_query($conn, $sql) or die(mysqli_error());

       //4. Check whether the(Query is Executed) data is inserted or not and display appropriate message
       if($res==TRUE)
       {
            //Category Added
            //echo "Data Inserted";
            //Create a Session Variable To Display message
            $_SESSION['add']="<div class='success'>Category Added Successfully.</div>";
            //Redirect page to manage category
            header("location:".SITEURL.'admin/manage-category.php');
       }
       else
       {
        //failed to add category
        //echo "Failed to Add Category";
        //Create a Session Variable To Display message
        $_SESSION['add']="<div class='error'>Failed to Add Category.</div>";
        //Redirect page to manage category
        header("location:".SITEURL.'admin/manage-category.php');
       }
        
}



?>