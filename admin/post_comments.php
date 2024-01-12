<?php
include "include/admin_header.php";
?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "include/admin_navigation.php";
    ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Blank Page
                        <small>Subheading</small>
                    </h1>
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
                            if(isset($_GET['p_id']))
                            {
                                $post_id = $_GET['p_id'];
                            
                            global $conn;
                            $sql = "select * from comments where comment_post_id = {$post_id}";
                            $disply_comments = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($disply_comments)) {
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
                                echo "<td><a href ='post_comments.php?approve={$comment_id}&p_id=" .$_GET['p_id']."'>Approve </a> </td>";
                                echo "<td><a href ='post_comments.php?unapprove={$comment_id}&p_id=" .$_GET['p_id']."'>UnApprove </a> </td>";

                                echo "<td><a href ='post_comments.php?delete={$comment_id}&p_id=" .$_GET['p_id']."'>DELETE </a></td>";
                                echo "</tr>";
                            }    
                                         }                 ?>
                        </tbody>


                    </table>


                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>

<?php
if(isset($_GET['approve']))
{
    $the_comment_id = $_GET['approve'];
    $stmt8 = mysqli_prepare($conn,"update comments set comment_status = 'approved' where comment_id = ?");
    mysqli_stmt_bind_param($stmt8,"i",$the_comment_id);
    mysqli_stmt_execute($stmt8);
    confirmQuery($stmt8);
    redirect("post_comments.php?p_id=" .$_GET['p_id']."");
   
}
if(isset($_GET['unapprove']))
{
    $the_comment_id = $_GET['unapprove'];
    $stmt9 = mysqli_prepare($conn,"update comments set comment_status = 'unapproved' where comment_id = ?");
    mysqli_stmt_bind_param($stmt9,"i",$the_comment_id);
    mysqli_stmt_execute($stmt9);
    confirmQuery($stmt9);
    redirect("post_comments.php?p_id=" .$_GET['p_id']."");
   
}
if(isset($_GET['delete']))
{
    $the_comment_id = $_GET['delete'];
    $comment_post_id = $_GET['p_id'];
    $stmt10 = mysqli_prepare($conn,"delete from comments where comment_id = ?");
    mysqli_stmt_bind_param($stmt10,"i",$the_comment_id);
    mysqli_stmt_execute($stmt10);
    confirmQuery($stmt10);
   
    $stmt11 = mysqli_prepare($conn,"update posts set post_comment_count = post_comment_count - 1 where post_id = ?");
    mysqli_stmt_bind_param($stmt11,"i",$comment_post_id);
    mysqli_stmt_execute($stmt11);
    confirmQuery($stmt11);
    redirect("post_comments.php?p_id=" .$_GET['p_id']."");
   
}

?>