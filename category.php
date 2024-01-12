<?php

include "includes/header.php";
include "includes/db.php";
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

                if (isset($_GET['cat_id'])) {
                    $cat_id = $_GET['cat_id'];
                    $status = 'published';
                    $stmt = mysqli_prepare($conn, "select posts.post_id,posts.post_category_id,posts.user_id,posts.post_title,
                                                    posts.post_image,
                                                    posts.post_date,posts.post_content,user.user_id,user.username from posts 
                                                    left join user
                                                    on posts.user_id = user.user_id 
                                                    where posts.post_category_id = ? 
                                                    and
                                                    posts.post_status = ? ");
                    mysqli_stmt_bind_param($stmt, "is", $cat_id, $status);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    // $result = mysqli_query($conn , $sql);

                    if (mysqli_num_rows($result) < 1) {
                        echo "<h1 class='text-center'> NO POST AVAILABLE </h1>";
                    } else {

                        while ($row = mysqli_fetch_assoc($result)) {
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['username'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = mysqli_real_escape_string($conn, substr($row['post_content'], 0, 70));


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
                            <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                            <hr>

                <?php }
                    }
                } else {
                    header("Location:index.php");
                } ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php
            include "includes/sidebar.php";
            ?>

        </div>
        <!-- /.row -->

        <hr>

        <?php

        include "includes/footer.php"
        ?>