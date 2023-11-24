<?php include('partials/menu.php'); ?>
<!-- Main Content Section starts -->
<div class="main-content">
                <div class="wrapper">
                    <h1>Manage Category</h1>
                    <br /><br />

                <?php
                    if(isset($_SESSION['add']))//Checking whether session is set or not
                    {
                       echo $_SESSION['add'];//Display the Session Message if Set
                       unset($_SESSION['add']);//Remove Session Message
                    }
                    if(isset($_SESSION['remove']))//Checking whether session is set or not
                    {
                       echo $_SESSION['remove'];//Display the Session Message if Set
                       unset($_SESSION['remove']);//Remove Session Message
                    }
                    if(isset($_SESSION['delete']))//Checking whether session is set or not
                    {
                       echo $_SESSION['delete'];//Display the Session Message if Set
                       unset($_SESSION['delete']);//Remove Session Message
                    }
                    if(isset($_SESSION['update']))//Checking whether session is set or not
                    {
                       echo $_SESSION['update'];//Display the Session Message if Set
                       unset($_SESSION['update']);//Remove Session Message
                    }
                ?>
                    <br /><br />
                    <!-- Button to Add Admin -->
                    <a href="<?php echo SITEURL;?>admin/add-category.php" class="btn-primary">Add Category</a>
                    <br /><br /><br />
                    <table class="tbl-full">
                        <tr>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Featured</th>
                            <th>Active</th>
                            <th>Actions</th>
                        </tr>
                        <?php
                             //Query to get all Categories from database
                             $sql="SELECT * FROM tbl_category";

                             //Execute Query
                             $res=mysqli_query($conn,$sql);

                             //Count Rows
                             $count=mysqli_num_rows($res);

                             //Create Serial Number Variable and assign value as 1.
                             $sn=1;

                             //Check whether we have database or not
                             if($count>0)
                             {
                                //We have data in database
                                //get the data and display
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $id=$row['id'];
                                    $title=$row['title'];
                                    $image_name=$row['image_name'];
                                    $featured=$row['featured'];
                                    $active=$row['active'];

                                    ?>
                                     <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $title; ?></td>

                                        <td>
                                            <?php 
                                                //Check whether image name is available or not
                                                if($image_name!="")
                                                {
                                                    //Display the image
                                                    ?>
                                                         <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name;?>" width="100px">
                                                    <?php
                                                }
                                                else
                                                {
                                                    //Display the message
                                                    echo"<div class='error'>Image not Added.</div>";
                                                }
                                            
                                            
                                            ?>
                                        </td>

                                        <td><?php echo $featured; ?></td>
                                        <td><?php echo $active; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name;?>" class="btn-danger">Delete Category</a>
                                        </td>
                                    </tr>
                                       

                                   <?php
                                }

                             }
                             else
                             {
                                //We don't have data
                                //We will display the message inside table
                                ?>
                                    <tr>
                                        <td colspan="6"><div class="error">No Category Added.</div></td>
                                        </td>
                                    </tr>
                                <?php
                             }
                        ?>
                        
                        
                    </table>
                </div>
            </div>

<!-- Main Content setion Ends: -->


<?php include('partials/footer.php'); ?>