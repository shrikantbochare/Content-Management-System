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

                if (isset($_POST['submit'])) {
                    $search = $_POST['search'];
                    $search = "%" . $search . "%";
                    $stmt = mysqli_prepare($conn, "select * from posts where post_tags like ? ");
                    mysqli_stmt_bind_param($stmt, 's', $search);
                    mysqli_stmt_execute($stmt);
                    $result2 = mysqli_stmt_get_result($stmt);
                    $count = mysqli_num_rows($result2);

                    confirmQuery($result2);
                    if ($count == 0) {
                        echo "no result";
                    } else {
                        while ($row = mysqli_fetch_assoc($result2)) {
                            $post_id = $row['post_id'];
                            $post_title = $row['post_title'];
                            $post_author = $row['post_author'];
                            $post_date = $row['post_date'];
                            $post_image = $row['post_image'];
                            $post_content = $row['post_content'];


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
                    }
                }
                ?>


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