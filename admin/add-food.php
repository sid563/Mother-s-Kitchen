<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">

            <tr>
                <td>Title: </td>
                <td>
                    <input type ="text" name="title" placeholder="Title of the Food">
                </td>

            </tr>
            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cold="30" rows="5" placeholder="Description of the Food."></textarea>

                </td>
            </tr>

            <tr> 
                <td>Price: </td>
                <td>
                    <input type="number" name="price">
                </td>
            </tr>

            <tr>
                <td>Select image: </td>
                <td>
                    <input type="file" name="image">
                
                </td>
            </tr>

            <tr>
                <td>Category: </td>
                <td>
                    <select name="category">

                    <?php

                      //Create PHP CODE TO DISPLAY CATEGORIES FROM DATABASE
                      //1.CREATE SQL TO GET ALL ACTIVE CATEGORIES FROM DATABASE

                      $sql="SELECT * FROM tbl_category WHERE active='Yes'";

                      //Executing query
                      $res = mysqli_query($conn,$sql);

                      //Count rows to check whether we have categories or not
                      $count=mysqli_num_rows($res);

                      //If count if greater than zero,we have categories else we dont have categories
                      if($count>0)
                      {
                        //we have categories
                        while($row=mysqli_fetch_assoc($res))
                        {
                            //get details of categories
                            $id=$row['id'];
                            $title=$row['title'];
                            ?>
                             
                            <option value="<?php echo $id;?>"><?php echo $title;?></option>

                            <?php
                        }

                      }

                      else
                      {

                      //We do not have a category
                      ?> 
                      <option value="0">No category found</option>
                      <?php
                      }

                      //2.Display on dropdown
                      ?>
                        
                    </select>
                </td>
            </tr>

<tr>
    <td>Featured: </td>
    <td>
        <input type="radio" name="featured" value="Yes">Yes
        <input type="radio" name="featured" value="No">No
    </td>
</tr>

<tr>
    <td>Active: </td>
    <td>
        <input type="radio" name="active" value="Yes">Yes
        <input type="radio" name="active" value="No">No
    </td>
</tr>

<tr>
    <td colspan="2">
        <input type="submit" name="submit" value="Add Food" class="btn-secondary">






</table>
</form>

<?php

//check whether the button is clicked or not
if(isset($_POST['submit']))
{

    //add the food in database
    //echo "clicked";

    //1.Get the data from form
    $title=$_POST['title'];
    $description=$_POST['description'];
    $price=$_POST['price'];
    $category=$_POST['category'];
    
    //check whether radio button for featured and active are checked or not
    if(isset($_POST['featured']))
    {
        $featured=$_POST['featured'];
    }
    else
    {
      $featured="No"; //setting the default value
    }

    if(isset($_POST['active']))
    {
        $active=$_POST['active'];

    }
    else
    {
        $active="No"; //setting default value

    }

    //2.Upload the image if selected
    //check whether the select image is clicked or not and upload the image only if the image is selected
    if(isset($_FILES['image']['name']))
    {

        //get details of selected image
        $image_name=$_FILES['image']['name'];

        //check whether the image is selected or not and upload image only if selected
        if($image_name!="")
        {
        
            //a.rename the image
            //get the extension of selected image(jpg,png,gif,etc.)
            $ext=end(explode('.',$image_name));

            //create new name for image
            $image_name="Food-Name-".rand(0000,9999).".".$ext;//new image name may be "food-name-657.jpg"

            //b.upload the image
            //get the src path and destination path

            //source path is the current location of the image
            $src=$_FILES['image']['tmp_name'];

            //destination path for the image to be uploaded
            $dst="../images/food/".$image_name;


            //Finally upload the food image
            $upload=move_uploaded_file($src,$dst);

            //check whether image uploaded or not
            if($upload==false)
            {
                //failed to uplaod the image
                //redirect to add food page with error message
                $_SESSION['upload']="<div class='error'>Failed to uplaod image.</div>";
                header('location: '.SITEURL.'admin/add-food.php');
                //STOP the process
                die();
            }
        }
    }
    else
    {
        $image_name ="";//setting deafult value as blank
    }

    //3.insert into database
    
    //create a sql query to save or add food
    //for numerical we do not need to pass value inside quotes but for strings we do 
    $sql2="INSERT INTO tbl_food SET
          title='$title',
          description='$description',
          price=$price,
          image_name='$image_name',
          category_id=$category,
          featured='$featured',
          active='$active'
          ";

          //execute the query
          $res2 = mysqli_query($conn,$sql2);
          //check whether data is inserted or not

             //4.redirect with message to manage food page

             if($res2 == true)
             {

                //data inserted successfully
                $_Session['add'] = "<div class='success'>Food added successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
             }
             else
             {
                //Failed to insert data
                $_SESSION['add'] ="<div class='error'>Failed to add food..</div>";
                header('location:'.SITEURL.'admin/manage-food.php');

             }



}
?>

</div>
</div>

<?php include('partials/footer.php'); ?>