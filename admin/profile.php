<?php
include "include/admin_header.php";
include "include/admin_navigation.php";
?>

<?php
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $stmt12 = mysqli_prepare($conn, "SELECT * FROM user WHERE username = ?");
    mysqli_stmt_bind_param($stmt12, "s", $username);
    mysqli_stmt_execute($stmt12);
    confirmQuery($stmt12);
    $select_user_by_username = mysqli_stmt_get_result($stmt12);


    while ($row = mysqli_fetch_assoc($select_user_by_username)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_password = $row['user_password'];
        //$user_image = $row['user_image'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];
    }
}
?>

<?php


if (isset($_POST['edit_profile'])) {


    $user_firstname   = escape($_POST['user_firstname']);
    $user_lastname    = escape($_POST['user_lastname']);
    $username         = escape($_POST['username']);
    $user_role        = escape($_POST['user_role']);
    $user_password    = escape($_POST['user_password']);
    $user_email       = escape($_POST['user_email']);

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, ['cost' => 10]);

    $stmt13 = mysqli_prepare($conn, "update user set user_firstname = ? ,
                                    user_lastname = ?, username = ? ,
                                    user_password = ? , user_role = ?,
                                    user_email = ? where username = ?");
    mysqli_stmt_bind_param($stmt13, "sssssss", $user_firstname, $user_lastname, $username, $user_password, $user_role, $user_email, $username);
    mysqli_stmt_execute($stmt13);
    confirmQuery($stmt13);
}

?>

<div id="wrapper">

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Blank Page
                        <small>Subheading</small>
                    </h1>

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
                            <input value="<?php echo $username; ?>" type="text" class="form-control" name="username" readonly>
                        </div>
                        <div class="form-group">
                            <label for="user_role">user role</label>
                            <select name="user_role" id="">
                                <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
                                <?php
                                if ($_SESSION['role'] == 'admin') {
                                    if ($user_role == 'admin') {

                                        echo '<option value="subscriber">subscriber</option>';
                                    } else {
                                        echo '<option value="admin">admin</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input value="<?php echo $user_password; ?>" type="password" class="form-control" name="user_password">
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input value="<?php echo $user_email; ?>" type="email" class="form-control" name="user_email">
                        </div>

                        <!-- <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" name="image">
</div> -->


                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" name="edit_profile" value="Update profile">
                        </div>


                    </form>

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