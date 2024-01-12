<form action="" method="post">
    <div class="form-group">
        <label for="cat_title"> edit Category</label>

        <?php
        $cat_id = $_GET['edit'];
        if (isset($_POST['update_cat'])) {
            $cat_title = escape($_POST['cat_title']);
            if (empty($cat_title)) {
                $message = "Title cannot be empty";
            } else {
                $stmt5 = mysqli_prepare($conn, "UPDATE category SET cat_title = ?  WHERE cat_id = ?");
                mysqli_stmt_bind_param($stmt5, 'si', $cat_title, $cat_id);
                mysqli_stmt_execute($stmt5);
                confirmQuery($stmt5);
                if(empty($_GET['source']))
                {
                    redirect("categories.php");
                }
                else{
                    redirect("categories.php?source=Mycategories");
                }
            }
        }
        ?>
        <?php
        if (isset($_GET['edit'])) {
            $cat_id = $_GET['edit'];
            $stmt4 = mysqli_prepare($conn, "select * from category where cat_id = ?");
            mysqli_stmt_bind_param($stmt4, 'i', $cat_id);
            mysqli_stmt_execute($stmt4);
            confirmQuery($stmt4);
            $edit_category = mysqli_stmt_get_result($stmt4);

            $row = mysqli_fetch_array($edit_category);
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
        }
        ?>
            <input value="<?php echo isset($cat_title) ? $cat_title : ''; ?>" type="text" class="form-control" name="cat_title">
            <h6 class="text-center"><?php echo isset($message) ? $message : ""; ?></h6>

    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_cat" value="update Category">
    </div>
</form>