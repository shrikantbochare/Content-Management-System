<?php
include "includes/db.php";
include "includes/header.php";

?>

<body>

    <!-- Navigation -->
    <?php

    include "includes/navigation.php"
    ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

                if (isset($_GET['p_id'])) {
                    $post_id = $_GET['p_id'];


                    if (isset($_SESSION['username'])) {
                        $sql = "select posts.post_id,posts.user_id,posts.post_title,posts.post_image,
                        posts.post_date,posts.post_content,user.user_id,user.username from posts 
                        left join user
                        on posts.user_id = user.user_id  where posts.post_id ={$post_id}";
                    } else {
                        $sql = "select posts.post_id,posts.user_id,posts.post_title,posts.post_image,
                        posts.post_date,posts.post_content,user.user_id,user.username from posts 
                        left join user
                        on posts.user_id = user.user_id 
                         where posts.post_id ={$post_id} and posts.post_status = 'published'";
                    }

                    $result = mysqli_query($conn, $sql);
                    $total = mysqli_num_rows($result);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['username'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];


                ?>


                        <h1 class="page-header">
                            Page Heading
                            <small>Secondary Text</small>
                        </h1>

                        <!-- First Blog Post -->
                        <h2>
                            <a href="post.php?p_id=<?php echo $post_id; ?>"> <?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="author_post.php?author=<?php echo $post_author; ?>"> <?php echo $post_author; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?> </p>
                        <hr>
                        <img class="img-responsive" src=" <?php echo "images/" . $post_image ?> " alt="">
                        <hr>
                        <p> <?php echo $post_content; ?> </p>
                        <!-- <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a> -->

                        <hr>
                <?php }
                } else {
                    redirect("index.php");
                } ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php
            include "includes/sidebar.php";
            ?>

        </div>
        <!-- /.row -->

        <!-- Blog Comments -->
        <?php

        if ($total == 0) {
            echo "<h1 class='text-center'> NO POST AVAILABLE </h1>";
        } else {
            $sql2 = "update posts set post_view_count = post_view_count + 1 where post_id = {$post_id}";
            $result2 = mysqli_query($conn, $sql2);
            if (!$result2) {
                die("failed" . mysqli_error($conn));
            }
            create_comment($post_id);


        ?>
            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form role="form" method="post" action="">
                    <?php if(!isLoggedIn()): ?>
                    <div class="form-group">
                        <input type="text" class="form-control" name="comment_author" placeholder="enter name"></input>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="comment_email" placeholder="enter email"></input>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <textarea name="comment_content" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <hr>


            <!-- Posted Comments -->
            <?php

            $sql = "select * from comments where comment_post_id = {$post_id} and
             comment_status = 'approved' order by comment_id desc";
            $comment_result = mysqli_query($conn, $sql);
            confirmQuery($comment_result);

            while ($row = mysqli_fetch_assoc($comment_result)) {
                $comment_author = $row['username'];
                $comment_date = $row['comment_date'];
                $comment_content = $row['comment_content'];

            ?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>


                <!-- Comment -->
        <?php  }
        }
        ?>



        <hr>

        <?php

        include "includes/footer.php"
        ?>