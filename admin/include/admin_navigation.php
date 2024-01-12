<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">CMS Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <?php $page = basename($_SERVER['PHP_SELF']); ?>
        <li><a href="../index.php">HOME</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>

                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <?php if ($_SESSION['role'] == 'admin') : ?>
                <li class='<?php echo ($page == 'dashboard.php') ? "active" : "" ?>'>
                    <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
            <?php endif; ?>
            <li class='<?php echo ($page == 'index.php') ? "active" : "" ?>'>
                <a href="index.php"><i class="fa fa-fw fa-dashboard"></i>My Data</a>
            </li>

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts_dropdown" class="collapse">
                    <?php if ($_SESSION['role'] == 'admin') : ?>
                        <li>
                            <a href="posts.php">View All Posts</a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="posts.php?source=Myposts">My Posts </a>
                    </li>
                    <li>
                        <a href="posts.php?source=add_post">Add post</a>
                    </li>
                </ul>
            </li>

            <li class='<?php echo ($page == 'categories.php') ? "active" : "" ?>'>
                <a href="categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
            </li>

            <li class='<?php echo ($page == 'comments.php') ? "active" : "" ?>'>
                <a href="comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
            </li>
            <?php if ($_SESSION['role'] == 'admin') : ?>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo" class="collapse">
                        <li>
                            <a href="users.php">View all users</a>
                        </li>
                        <li>
                            <a href="users.php?source=add_user">add user</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <li class='<?php echo ($page == 'profile.php') ? "active" : "" ?>'>
                <a href="profile.php"><i class="fa fa-fw fa-file"></i> Profile</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>