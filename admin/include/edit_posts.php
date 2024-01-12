<?php

    if(isset($_GET['p_id'])){
    
    $the_post_id =$_GET['p_id'];

    }


    $query = "select posts.post_id,posts.user_id,posts.post_title,posts.post_image,
    posts.post_date,posts.post_content,posts.post_category_id,posts.post_status,
    posts.post_tags,posts.post_comment_count,user.user_id,user.username from posts 
    left join user
    on posts.user_id = user.user_id 
     WHERE posts.post_id = $the_post_id  ";
    $select_posts_by_id = mysqli_query($conn,$query);  

    while($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id            = $row['post_id'];
        $post_title         = $row['post_title'];
        $post_category_id   = $row['post_category_id'];
        $post_status        = $row['post_status'];
        $post_image         = $row['post_image'];
        $post_content       = $row['post_content'];
        $post_tags          = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date          = $row['post_date'];
        
         }


    if(isset($_POST['update_post'])) {
        $post_title          =  escape($_POST['title']);
        $post_category_id    =  escape($_POST['post_category']);
        $post_status         =  escape($_POST['post_status']);
        $post_content        =  escape($_POST['post_content']);
        $post_tags           =  escape($_POST['post_tags']);
        $post_image          = ($_FILES['image']['name']);
        $post_image_temp     =($_FILES['image']['tmp_name']);


        move_uploaded_file($post_image_temp,"../Images/$post_image");
        
        
        
        if(empty($post_image)) {
        
        $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
        $select_image = mysqli_query($conn,$query);
            
        while($row = mysqli_fetch_array($select_image)) {
            
           $post_image = $row['post_image'];
        
        }
        
        
}
        // $post_title = mysqli_real_escape_string($conn, $post_title);

        
          $query = "UPDATE posts SET ";
          $query .="post_title  = '{$post_title}', ";
          $query .="post_category_id = '{$post_category_id}', ";
          $query .="post_date   =  now(), ";
          $query .="post_status = '{$post_status}', ";
          $query .="post_tags   = '{$post_tags}', ";
          $query .="post_content= '{$post_content}', ";
          $query .="post_image  = '{$post_image}' ";
          $query .= "WHERE post_id = {$the_post_id} ";
        
        $update_post = mysqli_query($conn,$query);
        
        confirmQuery($update_post);
        
        echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></p>";
        

    
    
    }



?>
   

   
   
<form action="" method="post" enctype="multipart/form-data">


<div class="form-group">
    <label for="title">Post Title</label>
    <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title">
</div>

<div class="form-group">
    <label for="category">Category</label>
   <select name="post_category" id="post_category">
   <?php
     $sql = "select * from category ";

     $edit_category = mysqli_query($conn, $sql);
      confirmQuery($edit_category);
     while ($row = mysqli_fetch_assoc($edit_category)) {
         $cat_id = $row['cat_id'];
         $cat_title = $row['cat_title'];

         if($cat_id == $post_category_id)
         {
            echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
         }
         else
         {
            echo "<option value='{$cat_id}'>{$cat_title}</option>";
         }

     }
     ?>
   </select>

</div>

<div class="form-group">
    <select name="post_status" id="">
        <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
       <?php
        if($post_status == 'published')
        {
           
           echo '<option value="draft">Draft</option>';
        }
        else
        {
            echo '<option value="published">Published</option>';
        }
       ?>
    </select>
</div>



<div class="form-group">
    <img  width="100" src="../<?php echo $post_image; ?>" alt="">
    <label for="post_image">Post Image</label>
        <input type="file" name="image">
</div>

<div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
</div>

<div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control " name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?>
     </textarea>
</div>



<div class="form-group">
    <input class="btn btn-primary" type="submit" name="update_post" value="update Post">
</div>


</form>