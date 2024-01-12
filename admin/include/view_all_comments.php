<div class="col-xs-4">
            <a class="btn btn-info" href="comments.php">All Comments</a>
            <a class="btn btn-primary" href="comments.php?source=Mycomments">My Comments</a>
            <a class="btn btn-info" href="comments.php?source=PostComments">My Post Comments</a>
        </div>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <td>Id</td>
            <td>Author</td>
            <td>Comment</td>
            <td>Email</td>
            <td>Status</td>
            <td>In response to</td>
            <td>Date</td>
            <td>Approve</td>
            <td>Unapprove</td> 
            <td>Delete</td>
        </tr>
    </thead>
    <tbody>
        <?php
         global $conn;
         $sql = "select * from comments";
         $disply_comments = mysqli_query($conn,$sql);
         while($row = mysqli_fetch_assoc($disply_comments))
         {
             $comment_id = $row['comment_id'];
             $comment_post_id = $row['comment_post_id'];
             $comment_author = $row['username'];
             
             $comment_content = $row['comment_content'];
             $comment_email = $row['comment_email'];
             $comment_status = $row['comment_status'];
             $comment_date = $row['comment_date'];
            
             echo "<tr>";
             echo "<td> $comment_id </td>";
             echo "<td>$comment_author </td>";
             
             echo "<td> $comment_content</td>";
             echo "<td> $comment_email</td>";
            
             echo "<td>$comment_status </td>";
             $user__id = get_postName_userName($comment_post_id );
             echo "<td>$comment_date </td>";
             if( $_SESSION['role'] == 'admin')
            {
                echo "<td><a href ='comments.php?approve={$comment_id}'>Approve </a> </td>";
                echo "<td><a href ='comments.php?unapprove={$comment_id}'>UnApprove </a> </td>";
                echo "<td><a href ='comments.php?delete={$comment_id}&post_id={$comment_post_id}'>DELETE </a></td>";
            }
             echo "</tr>";
         }                     ?>
    </tbody>

    
</table>

<?php
if(isset($_GET['approve']))
{
    $the_comment_id = $_GET['approve'];
    $stmt8 = mysqli_prepare($conn,"update comments set comment_status = 'approved' where comment_id = ?");
    mysqli_stmt_bind_param($stmt8,"i",$the_comment_id);
    mysqli_stmt_execute($stmt8);
    confirmQuery($stmt8);
    header("Location:comments.php");
   
}
if(isset($_GET['unapprove']))
{
    $the_comment_id = $_GET['unapprove'];
    $stmt9 = mysqli_prepare($conn,"update comments set comment_status = 'unapproved' where comment_id = ?");
    mysqli_stmt_bind_param($stmt9,"i",$the_comment_id);
    mysqli_stmt_execute($stmt9);
    confirmQuery($stmt9);
    header("Location:comments.php");
   
}
if(isset($_GET['delete']))
{
    $the_comment_id = $_GET['delete'];
    $comment_post_id = $_GET['post_id'];
    $stmt10 = mysqli_prepare($conn,"delete from comments where comment_id = ?");
    mysqli_stmt_bind_param($stmt10,"i",$the_comment_id);
    mysqli_stmt_execute($stmt10);
    confirmQuery($stmt10);
   
    $stmt11 = mysqli_prepare($conn,"update posts set post_comment_count = post_comment_count - 1 where post_id = ?");
    mysqli_stmt_bind_param($stmt11,"i",$comment_post_id);
    mysqli_stmt_execute($stmt11);
    confirmQuery($stmt11);
    header("Location:comments.php");
   
}

?>