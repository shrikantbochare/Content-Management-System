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
                <?php
               if(admin($_SESSION['username']))
                    {   ?>
                        <div class="col-lg-12">
                    <h1 class="page-header">
                        Blank Page
                        <small>Subheading</small>
                    </h1>

                    <?php
                    if (isset($_GET['source'])) {
                        $source = $_GET['source'];
                    } 
                    else {
                        $source = '';
                    }

                    switch ($source) {
                        case 'add_user':
                                require "include/add_user.php";
                            break; 
                        case 'edit_user':
                            include "include/edit_user.php";
                            break;

                        default:
                            
                                require "include/view_all_users.php";
                          
                               
                           
                            break;
                    }
                    ?>

                </div>
                   <?php }
                    else
                    {
                        echo "<h2 class='text-center'>ONLY ADMIN CAN ACCESS THE PAGE</h2>";
                    }
                    ?>
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