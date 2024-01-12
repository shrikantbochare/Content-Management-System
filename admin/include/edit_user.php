
<?php

    if(isset($_GET['u_id'])){
    
    $the_user_id =$_GET['u_id'];

    


    $query = "SELECT * FROM user WHERE user_id = $the_user_id  ";
    $select_user_by_id = mysqli_query($conn,$query);  

    while($row = mysqli_fetch_assoc($select_user_by_id)) {
        $user_firstname            = $row['user_firstname'];
        $user_lastname         = $row['user_lastname'];
        $username         = $row['username'];
        $user_role   = $row['user_role'];
        $user_password        = $row['user_password'];
        $user_email         = $row['user_email'];
    
        
         }


    if(isset($_POST['edit_user'])) {
        
        
        $user_firstname            = $_POST['user_firstname'];
        $user_lastname         = $_POST['user_lastname'];
        $username         = $_POST['username'];
        $user_role   = $_POST['user_role'];
        $user_password        = $_POST['user_password'];
        $user_email         = $_POST['user_email'];
        
        // move_uploaded_file($post_image_temp, "../$post_image"); 
        
        // if(empty($post_image)) {
        
        // $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
        // $select_image = mysqli_query($conn,$query);
            
        // while($row = mysqli_fetch_array($select_image)) {
            
        //    $post_image = $row['post_image'];}
        
        // }
       if(!empty($user_password))
       {
        $sql = "select user_password from user where user_id = $the_user_id";
        $get_pass = mysqli_query($conn,$sql);
        confirmQuery($get_pass);
        $row = mysqli_fetch_assoc($get_pass);
        $password = $row['user_password'];
        if($user_password != $password)
        {
            $user_password = password_hash($user_password,PASSWORD_BCRYPT,['cost'=> 10]);
        }
       }
        
}
       

        
          $query = "UPDATE user SET ";
          $query .="user_firstname  = '{$user_firstname}', ";
          $query .="user_lastname = '{$user_lastname}', ";
          $query .="username   =  '{$username}', ";
          $query .="user_password = '{$user_password}', ";
          $query .="user_role = '{$user_role}', ";
          $query .="user_email   = '{$user_email}' where user_id ={$the_user_id}";
          
        
        $update_user = mysqli_query($conn,$query);
        
        confirmQuery($update_user);
        
        //echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></p>";
        

    
    
    }   



?>
   

<form action="" method="post" enctype="multipart/form-data">


    <div class="form-group">
        <label for="firstname">First Name</label>
        <input value="<?php echo $user_firstname; ?>" type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="lastname">Last Name</label>
        <input value="<?php echo $user_lastname; ?>" type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="username">User Name</label>
        <input value="<?php echo $username; ?>" type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="user_role">user role</label>
        <select name="user_role" id="">
        <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
           <?php
            if($user_role == 'admin')
            {
                
               echo '<option value="subscriber">subscriber</option>';
            }
            else
            {
                echo '<option value="admin">admin</option>';
            }
           ?>
        </select>
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input value="" type="password" class="form-control" name="user_password">
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input value="<?php echo $user_email; ?>" type="email" class="form-control" name="user_email">
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
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update user">
    </div>


</form>