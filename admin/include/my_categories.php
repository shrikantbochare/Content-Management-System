"include/admin_header.php";
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

                    <div class="col-xs-6">
                        <?php insert_category_query(); ?>

                        <div class="col-xs-4">
                            <a class="btn btn-info" href="categories.php">All Comments</a>
                            <a class="btn btn-primary" href="categories.php?source=MyCategories">My Comments</a>
                        </div>
                        <form action="categories.php" method="post">
                            <div class="form-group">
                                <label for="cat_title"> Add Category</label>
                                <input type="text" class="form-control" name="cat_title">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                            </div>
                        </form>


                        <?php
                        if (isset($_GET['edit'])) {
                            include "include/update_categories.php";
                        }   ?>
                    </div>

                    <div class="col-xs-6">

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Category Title</th>
                                    <th>OWNER</th>
                                    <th>DELETE</th>
                                    <th>EDIT</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php all_categories();      ?>
                                <?php delete_categories(); ?>
                            </tbody>
                        </table>
                    </div>
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