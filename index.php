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

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <?php

                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    $page = ($page - 1) * 5;
                } else {
                    $page = 0;
                }


                $sql = "select * from posts where post_status = 'published'";
                $total_result = mysqli_query($conn, $sql);
                $total_result = mysqli_num_rows($total_result);
                $count = ceil($total_result / 5);
                if ($total_result < 1) {
                    echo "<h1 class='text-center'> NO POST AVAILABLE </h1>";
                } else {


                    $sql = "select posts.post_id,posts.user_id,posts.post_title,posts.post_image,
                    posts.post_date,posts.post_content,user.user_id,user.username from posts 
                    left join user
                    on posts.user_id = user.user_id 
                    where posts.post_status = 'published' order by post_id desc limit  $page,5";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['username'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = mysqli_real_escape_string($conn, substr($row['post_content'], 0, 70));


                ?>



                        <!-- First Blog Post -->
                        <h2>
                            <a href="post.php?p_id=<?php echo $post_id; ?>"> <?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="author_post.php?author=<?php echo $post_author; ?>"> <?php echo $post_author; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?> </p>
                        <hr>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><img class="img-responsive" src=" <?php echo "images/" . $post_image ?> " alt=""></a>
                        <hr>
                        <p> <?php echo $post_content; ?> </p>
                        <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                        <hr>



                <?php }
                } ?>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php
            include "includes/sidebar.php";
            ?>

        </div>
        <!-- /.row -->


        <hr>
        <div>
            <ul class="pager">
                <?php
                for ($i = 1; $i <= $count; $i++) {
                    echo "<li class='page-item'><a class='page-link' href='index.php?page={$i}'>$i</a></li>";
                }
                ?>
            </ul>
        </div>
        <?php

        include "includes/footer.php"
        ?>