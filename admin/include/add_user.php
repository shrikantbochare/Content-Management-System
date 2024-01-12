<?php


insert_new_user();




?>

<form action="" method="post" enctype="multipart/form-data">


    <div class="form-group">
        <label for="firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="username">User Name</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_role">user role</label>
        <select name="user_role" id="">
        <option value="subscriber">select option</option>
            <option value="admin">admin</option>
            <option value="subscriber">subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <!-- <div class="form-group">
        <label for="category">Category</label>
     <select name="post_category" id="post_category"> -->
     <!-- <?php
     $sql = "select * from category ";

     $edit_category = mysqli_query($conn, $sql);
      confirmQuery($edit_category);
     while ($row = mysqli_fetch_assoc($edit_category)) {
         $cat_id = $row['cat_id'];
         $cat_title = $row['cat_title'];

         echo "<option value='{$cat_id}'>{$cat_title}</option>";

     }
     ?> -->

     <!-- </select>
    </div> -->

    <!-- <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">
    </div> -->


    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="add_user" value="Add user">
    </div>


</form>