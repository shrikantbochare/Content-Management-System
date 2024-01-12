<?php

function redirect($location){
    header("Location:" . $location);
    exit;
}
function confirmQuery($result)
{
    global $conn;
    if(!$result)
    {
        die("failed ". mysqli_error($conn) );
    }

}

function insert_category_query()
{
    global $conn;
    if (isset($_POST['submit'])) {
        if (empty($_POST['cat_title'])) {
            echo "please enter data";
        } else {
            $title = $_POST['cat_title'];
            $u_id = $_SESSION['user_id'];
            $stmt2 = mysqli_prepare($conn,"insert into category (cat_title,user_id) values (?,?)");
            mysqli_stmt_bind_param($stmt2,'si',$title, $u_id);
            mysqli_stmt_execute($stmt2);
            confirmQuery($stmt2);
        }
    }
}

function all_categories($source)
{
    global $conn;
    if(empty($source))
    {
        $sql = "select c.cat_title, c.cat_id, c.user_id, u.user_id, u.username
        from category c
        left join user u
        on c.user_id = u.user_id ";
    }
    else
    {
        $sql = "select c.cat_title, c.cat_id, c.user_id, u.user_id, u.username
        from category c
        left join user u
        on c.user_id = u.user_id 
        where u.user_id = {$_SESSION['user_id']}";
    }
    $mysqli_category = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($mysqli_category)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        $username = $row['username'];
        $user_id = $row['user_id'];
        echo "<tr>";
        // echo "<td> {$cat_id} </td>";
        echo "<td> {$cat_title} </td>";
        echo "<td> {$username} </td>";
        if(!empty($source)|| $_SESSION['role'] == 'admin')
        {
            echo "<td> <a href='categories.php?delete={$cat_id}'>DELETE</a> </td>";
            echo "<td> <a href='categories.php?edit={$cat_id}&source={$source}'>EDIT</a> </td>";
        }
        
        echo "</tr>";
    }

}

function delete_categories()
{
    global $conn;
    if (isset($_GET['delete'])) {
        $id_delete = $_GET['delete'];
        $stmt3 = mysqli_prepare($conn,"delete from category where cat_id = ?");
        mysqli_stmt_bind_param($stmt3,'i',$id_delete);
        mysqli_stmt_execute($stmt3);
       confirmQuery($stmt3);
        header("Location:categories.php");
    }
}

function  display_all_posts()
{
    global $conn;
   if(empty($_GET['source']))
   {
    $sql = "select posts.post_id,posts.user_id,posts.post_title,posts.post_category_id,posts.post_status,posts.post_image,
    posts.post_tags,posts.post_comment_count,posts.post_date,posts.post_view_count,category.cat_id,category.cat_title,user.user_id,user.username
    from posts 
    left join category
    on posts.post_category_id = category.cat_id
    left join user
    on posts.user_id = user.user_id";
   }
   else
   {
    $sql = "select posts.post_id,posts.user_id,posts.post_title,posts.post_category_id,posts.post_status,posts.post_image,
    posts.post_tags,posts.post_comment_count,posts.post_date,posts.post_view_count,category.cat_id,category.cat_title,user.user_id,user.username
    from posts 
    left join category
    on posts.post_category_id = category.cat_id
    left join user
    on posts.user_id = user.user_id  
    where posts.user_id =". $_SESSION['user_id'] ;
   }
    $disply_posts = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($disply_posts))
    {
        $post_id = $row['post_id'];
        $post_author = $row['username'];
        $post_title = $row['post_title'];
        //$post_category = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_view_count       = $row['post_view_count'];
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        

        echo "<tr>";
        ?>
        <?php  if(!empty($_GET['source'])): ?>
        <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
        <?php endif; ?>
        <?php
        echo "<td> $post_id </td>";
        echo "<td>$post_author </td>";
        echo "<td> $post_title</td>";
        echo "<td> $cat_title</td>"; //get_category_name($post_category);
        echo "<td>$post_status </td>";
        echo "<td> <img width ='100'  src ='../Images/{$post_image}' ></td>";
        echo "<td> $post_tags</td>";
        echo "<td><a href ='post_comments.php?p_id={$post_id}'>{$post_comment}</a></td>";
        echo "<td>$post_date </td>";
        echo "<td> $post_view_count  </td>";
        echo "<td><a href ='../post.php?p_id={$post_id}'>view post </a></td>";
        if(!empty($_GET['source']) || $_SESSION['role'] == 'admin'){
        echo "<td><a  href ='posts.php?source=edit_post&p_id={$post_id}'>EDIT </a></td>";
        ?>
        <form action="" method="post">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
        <?php 
        echo "<td><input class='btn btn-danger' type='submit' name='delete' value='Delete'></td>";
        }
        ?>
        
        </form>
        <?php
       
        echo "</tr>";
        
    }
}

function create_comment($post_id)
{
    global $conn;
    if(isset($_POST['create_comment']))
    {

        if(isLoggedIn())
        {
            $comment_author = $_SESSION['username'];
            $comment_email = $_SESSION['email'];
            $comment_user_id = $_SESSION['user_id'];
        }
        else{
            $comment_author = $_POST['comment_author'];
            $comment_email = $_POST['comment_email'];
            $comment_user_id = 0;
        }
            $comment_content = $_POST['comment_content'];
            $comment_post_id = $post_id;
            $comment_status = "Unapproved";
          
            if(!empty($comment_author) && !empty(  $comment_email ) && !empty( $comment_content ))
           {
            $stmt6 = mysqli_prepare($conn,"insert into comments (username,user_id,comment_content,comment_email,
                                            comment_status,comment_post_id,comment_date) values (?,?,?,?,?,?,now())");
            mysqli_stmt_bind_param($stmt6,"sisssi",$comment_author,$comment_user_id,$comment_content,
                                            $comment_email,$comment_status,$comment_post_id);
            mysqli_stmt_execute($stmt6);
            confirmQuery($stmt6);

            $stmt7 = mysqli_prepare($conn,"update posts set post_comment_count = post_comment_count +
                                             1 where post_id = ?");
            mysqli_stmt_bind_param($stmt7,"i",$post_id);
            mysqli_stmt_execute($stmt7);
            confirmQuery($stmt7);
           }
           
    }
   
   
}
function get_postName_userName($comment_post_id)
{
    global $conn;
    $sql = "select * from posts where post_id ={$comment_post_id}";
    $result = mysqli_query($conn,$sql);
    confirmQuery($conn);
    $row = mysqli_fetch_array($result);
   
        $post_title = $row['post_title'];
        $post_id = $row['post_id'];
        $user__id  = $row['user_id'];
        echo "<td><a href='../post.php?p_id={$post_id}'> $post_title </a></td>";
        return $user__id;   
}


function ifItIsMethod($method=null){

    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){

        return true;

    }

    return false;

}

function isLoggedIn(){
    if(isset($_SESSION['role'])){
        return true;
    }
   return false;
}

function checkIfUserIsLoggedInAndRedirect($redirect=null)
{
    if(isLoggedIn())
    {
        redirect($redirect);
    }
}

function login($username,$password)
{
    global $conn;
    $username = $username;
    $user_password = $password;

    $username =trim( mysqli_real_escape_string($conn,$username));
    $user_password = trim(mysqli_real_escape_string($conn,$user_password));

    $stmt = $conn->prepare("select * from user where username = ?");
    $stmt->bind_param('s',$username);
    $stmt->execute();
    $select_user = $stmt->get_result();
    confirmQuery($select_user);

    $row = mysqli_fetch_array($select_user);

        $u_id = $row['user_id'];
        $u_firstname = $row['user_firstname'];
        $u_lastname = $row['user_lastname'];
        $u_username = $row['username'];
        $u_password = $row['user_password'];
        $u_role = $row['user_role'];
        $u_email = $row['user_email'];
        if(password_verify($user_password,$u_password))
        {
            $_SESSION['user_id']  = $u_id;
            $_SESSION['username']  = $u_username;
            $_SESSION['firstname']  = $u_firstname;
            $_SESSION['lastname']  = $u_lastname;
            $_SESSION['role']  = $u_role;
            $_SESSION['email'] =   $u_email;
            header("Location:admin/index.php");
        }
   
    else
    {
        header("Location:".$_SERVER['PHP_SELF']);
    }
}


?>