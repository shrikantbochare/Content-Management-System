<?php

function escape($string)
{
    global $conn;
    return trim(mysqli_real_escape_string($conn,$string));
}
function insert_new_post()
{
global $conn;
    
if (isset($_POST['create_post'])) {

    $post_title        = escape($_POST['title']);
    $post_author       = $_SESSION['user_id'];
    $post_category_id  = escape($_POST['post_category']);
    $post_status       = escape($_POST['post_status']);
    $post_tags         = escape($_POST['post_tags']);
    $post_content      = escape($_POST['post_content']);
    $post_image        = ($_FILES['image']['name']);
    $post_image_temp   = ($_FILES['image']['tmp_name']);

    move_uploaded_file($post_image_temp,"../Images/$post_image");

    $query = "INSERT INTO posts(post_category_id, post_title, user_id, post_date,post_image,post_content,post_tags,post_status) ";

    $query .= "VALUES({$post_category_id},'{$post_title}',{$post_author},now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}') ";

    $create_post_query = mysqli_query($conn, $query);

    confirmQuery($create_post_query);

    $the_post_id = mysqli_insert_id($conn);


    echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php?source=Myposts'>Edit More Posts</a></p>";
}
}

function insert_new_user(){
global $conn;
    
if (isset($_POST['add_user'])) {

    $user_firstname        = ($_POST['user_firstname']);
    $user_lastname         = ($_POST['user_lastname']);
    $username  = ($_POST['username']);
    $user_email       = ($_POST['user_email']);

    // $post_image        = ($_FILES['image']['name']);
    // $post_image_temp   = ($_FILES['image']['tmp_name']);


    $user_password         = ($_POST['user_password']);
    $user_role      = ($_POST['user_role']);
   


    // move_uploaded_file($post_image_temp, "../$post_image");

    $user_password = password_hash($user_password,PASSWORD_BCRYPT,['cost'=> 10]);
    $query = "INSERT INTO user(user_firstname,user_lastname,username,user_email,user_password,user_role) ";

    $query .= "VALUES('{$user_firstname}','{$user_lastname}','{$username}','{$user_email}','{$user_password}','{$user_role}') ";

    $add_user_query = mysqli_query($conn, $query);

    confirmQuery($add_user_query);

    


    echo "<p class='bg-success'>user Created. <a href='../admin/users.php'>View users </a> </p>";
}
}

function record_count($tableName)
{
    global $conn;
    $sql = "select * from ".$tableName;
    $total = mysqli_query($conn,$sql);    
    confirmQuery($total);
    return mysqli_num_rows($total);

}
function user_record_count($tableName,$id)
{
    global $conn;
    $sql = "select * from ".$tableName." where user_id = ".$id;
    $total = mysqli_query($conn,$sql);    
    confirmQuery($total);
    return mysqli_num_rows($total);

}

function admin($username)
{
    global $conn;
    $sql = "select user_role from user where username = '$username'";
    $result = mysqli_query($conn,$sql);
    confirmQuery($sql);
    $row = mysqli_fetch_assoc($result);

    if($row['user_role'] == 'admin')
    {
        return true;
    }
    else
    {
        return false;
    }
}

function user_exists($username)
{
    global $conn;
    $sql = "select username from user where username = '$username'";
    $result = mysqli_query($conn,$sql);
    confirmQuery($sql);

    if(mysqli_num_rows($result) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}
function email_exists($email)
{
    global $conn;
    $sql = "select user_email from user where user_email = '$email'";
    $result = mysqli_query($conn,$sql);
    confirmQuery($sql);

    if(mysqli_num_rows($result) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function registration($username,$email,$password)
{
    global $conn;
            $username =  $username;
            $user_email =  $email;
            $user_password = $password;
            $role   = 'subscriber';

            $user_password = password_hash($user_password, PASSWORD_BCRYPT, ['cost' => 10]);
            $stmt = mysqli_prepare($conn,"insert into user (username, user_email, user_password,user_role ) 
            values (?,?,?,?)");
            mysqli_stmt_bind_param($stmt,'ssss',$username,$user_email,$user_password,$role);
            mysqli_stmt_execute($stmt);
            confirmQuery($stmt);

            $message = "<h3>User registered successfully <a href='login.php'>Login</a></h3>";
            return $message;
}


?>
