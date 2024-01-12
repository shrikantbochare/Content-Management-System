<div class="col-xs-12">
        <a class="btn btn-info" href="categories.php">All Comments</a>
        <a class="btn btn-primary" href="categories.php?source=MyCategories">My Comments</a>
    </div>
<div class="col-xs-6">
    <?php insert_category_query(); ?>
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