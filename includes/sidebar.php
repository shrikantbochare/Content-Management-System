<?php
if (ifItIsMethod('post')) {

	if (isset($_POST['username']) && isset($_POST['password'])) {

		login($_POST['username'], $_POST['password']);
	}
}
?>
<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <div class="well">
        <?php if (isset($_SESSION['username'])) : ?>
            <h4>Logged in as <?php echo $_SESSION['username']; ?></h4>
            <a href="includes/logout.php" class="btn btn-primary">Logout</a>
        <?php else : ?>
            <!-- Blog Search Well -->

            <h4>Login</h4>
            <form action="" method="post">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter username">
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter password">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">Submit</button>
                    </span>
                </div>
                <div class="form-group">
                    <a href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password?</a>
                </div>
            </form>
            <!-- /.input-group -->
        <?php endif ?>
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">
                    <?php
                    $sql = "select * from category";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        echo "<li><a href='category.php?cat_id={$cat_id}'> {$cat_title}  </a></li>";
                    }


                    ?>
                </ul>
            </div>


            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <div class="well">
        <h4>Side Widget Well</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
    </div>

</div>