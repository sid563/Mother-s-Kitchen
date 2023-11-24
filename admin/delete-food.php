<?php
   //Include Constants Page
   include('../config/constants.php');
  
  //echo "Delete Food Page";
  if(isset($_GET['id']) AND isset($_GET['image_name'])) 
  {
      //Process to Delete
      //echo "Process to Delete";

      //1. Get ID and iamge Above
      $id=$_GET['id'];
      $image_name=$_GET['image_name'];
      //2. Remove the image if Available
      //Check whether the image is available or not and Delete only if possible
      if($image_name != "")
      {
        
        //It has image if and need to remove from folder
        //Get the Image Path
        $path = "../images/food/".$image_name;
        //REmove the Image
        $remove = unlink($path);

        //Check whether image is removed or not
        if($remove==false)
        {
            //Failed to remove image
            $_SESSION['upload']="<div class='error'>Failed to remove Image File.</div>";
            //Redirect to manage food
            header('location:'.SITEURL.'admin/manage-food.php');
            //Stop the process of deleting food
            die();
        }
      }
      //3. Delete Food From Database
      $sql="DELETE FROM tbl_food WHERE id=$id";
      //Execute the query
      $res=mysqli_query($conn,$sql);

      //Check whether the query executed or not and set the session message respectively
      //4.Redirect to Manage Food with Session Message
      if($res==true)
      {
         //Food Deleted
         $_SESSION['delete']="<div class='success'>Food Deleted Successfully.</div>";
         header('location:'.SITEURL.'admin/manage-food.php');
      }
      else
      {
        //Failed to delete food
          $_SESSION['delete']="<div class='error'>Failed to Delete Food.</div>";
          header('location:'.SITEURL.'admin/manage-food.php');
      }
      

  }
  else
  {
       //Redirect to Manage Food Page 
       //echo "Redirect"; 
       $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
       header('location:'.SITEURL.'admin/manage-food.php'); 


  }
?>
