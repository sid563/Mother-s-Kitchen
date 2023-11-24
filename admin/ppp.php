<?php include('partials/menu.php');?>

<?php
   //check whethet id is set or not
   if(isset($_GET['id']))
   {
      //Get all the details
      $id=$_GET['id'];

      //SQL Query to get the Selected Food
      $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
      //execute the Query
      $res2=mysqli_query($conn,$sql2);

      //Get the value based on query executed
      $row2=mysqli_fetch_assoc($res2);

      //Get thr Individual value of Selected Food
      $title=$row2['title'];
      $description=$row2['description'];
      $price = $row2['price'];
      $current_image=$row2['image_name'];
      $current_category=$row2['category_id'];
      $featured=$row2['featured'];
      $active=$row2['active'];

   }
   else
   {
       //Redirect to Manage Food
       header('location:'.SETURL.'admin-food.php');
   }
 ?>
<div class="main-content">
    <div class="wrapper">
    <h1> Update Food</h1>
    <br><br>

    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-38">
            <tr>
                <td>Title:</td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Description:</td>
                <td>
                    <textarea name="description" cols="10" rows="5"><?php echo $description; ?></textarea>
                </td>
            </tr>

            <tr>
                <td>Price:</td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image:</td>
                <td>
                    <?php 
                    if($current_image=="")
                    {
                        //image not available
                        echo "<div class='error'>Iamge not available.</div>";
                    }
                    else
                    {
                        //image available
                        ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                        <?php
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td>Select New Image:</td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>
            <tr>
                <td>Category:</td>
                <td>
                    <select name="category">
                        <?php
                        //Query to get active categories
                        $sql="SELECT * FROM tbl_category WHERE active='Yes'";
                        //Execute the query 
                        $res=mysqli_query($conn,$sql);
                        //Count Rows 
                        $count = mysqli_num_rows($res);

                        //check whether category available or not 
                        if($count>0)
                        {
                            //Category Avaialble
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $category_title=$row['title'];
                                $category_id=$row['id'];
                                

                                //echo "<option value='$category_id'>$category_title</option>";
                                ?>
                                <option <?php if($current_category==$category_id){echo "selected";} ?>value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                <?php
                            }
                        }
                        else
                        {
                            //Category not Available
                            echo "<option value='0'>Category Not Available.</option>";
                        }

                        ?>
                        <option value="0">Test Category</option>
                    </select>
                </td>
            </tr>
 
            <tr>
                <td>Featured:</td>
                <td>
                    <input <?php if($featured=="Yes") {echo "checked";} ?>type="radio" name="featured" value="Yes">Yes
                    <input <?php if($featured=="No") {echo "checked";} ?>type="radio" name="featured" value="No">No
                </td>
            </tr>

            <tr>
                <td>Active:</td>
                <td>
                    <input <?php if($active=="Yes") {echo "checked";} ?>type="radio" name="active" value="Yes">Yes
                    <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No">No
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                    <input type="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>
         </table>
    </form>
    <?php
       
       if(isset($_POST['submit']))
       {
          //echo 'Button Clicked';
          //1.Get all the details from the form 
          $id=$_POST['id'];
          $title=$_POST['title'];
          $description=$_POST['description'];
          $price=$_POST['price'];
          $current_image=$_POST['current_iamge'];
          $category=$_POST['category'];

          $featured=$_POST['featured'];
          $active=$_POST['active'];

          //2.Uplaod the image if selected

          //check whether upload button is clicked or not
          if(isset($_FILES['image']['name']))
          {
            //upload button clicked
            $image_name=$_FILES['image']['name']; //New image name

            //check whether file is available or not
            if($image_name!="")
            {
                //image is available
                //rename the image
                $text=end(explode('.',$image_name)); //Gets the extension of the image

                $image_name="Food-Name-".rand(0000,9999).'.'.$text;//this will be renamed image

                //Get the Source Path and Destination path 
                $src_path=$_FILES['image']['tmp_name']; //source path
                $dest_path="../images/food/".$image_name; //destination path

                //upload the image
               // $upload the image 
                $upload=move_uploaded_file($src_path,$dest_path);

                //check whether  image is uploaded or not
                if($upload==false)
                {
                    //Failed to send
                    $_SESSION['upload']="<div class='error'>Failed to uplaod new image</div>";
                    //Redirect to manage food
                    header('location'.SETURL.'admin/manage-food.php');
                    //stop the process
                    die();
                }

                //remove current image if available
                if($current_image!="")
                {
                    //current image is available
                    //remove image
                    $remove_path="../images/food/".$current_image;

                    $remove=unlink($remove_path);
                    //check whether image removed or not
                    if($remove==false)
                    {
                        $_SESSION['remove-failed']="<div class>='error'>Failed to remove current image.</div>";
                        //redirect to manage food
                        header('location'.SETURL.'admin/manage-food.php');
                        //stop process
                        die();

                    }
                }
            }
          }
          else
          {
            $image_name=$current_image;
          }

        

          //4.Update the food in Database,
          $sql3="UPDATE tbl_food SET 
              title ='$title',
              description = '$description',
              price='$price',
              image_name='$image_name',
              category_id='$category',
              featured='$featured',
              active='$active'
              WHERE id=$id
              ";

              //execute sql query 
              $res3=myqli_query($conn,$sql);

              if($res3==true)
              {
                $_SESSION['update']="<div class='success'>Food Updated successfully.</div>";
                header('location:'.SETURL.'admin/manage-food.php');

              }
              else
              {
                $_SESSION['update']="<div class='error'>Failed to Update Food.</div>";
                header('location:'.SETURL.'admin/manage-food.php');
              }

              


          //Redirect to manage food with session message
       }


    ?>
    

    </div>

</div>
<?php include('partials/footer.php'); ?>
