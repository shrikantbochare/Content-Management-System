<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">HOME</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <?php
                $pagename = basename($_SERVER['PHP_SELF']);
                ?>
                <?php if (isLoggedIn()) : ?>
                    <li>
                        <a href="admin">Admin</a>
                    </li>

                    <li>
                        <a href="includes/logout.php">Logout</a>
                    </li>
                <?php else : ?>
                    <li>
                        <a class='<?php echo ($pagename == "login.php" ? "active" : "") ?>' href="login.php">Login</a>
                    </li>
                    <li class='<?php echo ($pagename == "registration.php" ? "active" : "") ?>'>
                        <a href="registration.php">Registration</a>
                    </li>
                <?php endif; ?>

                <li class='<?php echo ($pagename == "contact.php" ? "active" : "") ?>'>
                    <a href="contact.php">Contact</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>