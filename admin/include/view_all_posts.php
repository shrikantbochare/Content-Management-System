<!-- <?php
        if (isset($_POST['checkBoxArray'])) {
            foreach ($_POST['checkBoxArray'] as $postValueId) {
                $bulk_options = $_POST['bulk_options'];
                switch ($bulk_options) {
                    case 'published':
                        $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}  ";
                        $update_to_published_status = mysqli_query($conn, $query);
                        confirmQuery($update_to_published_status);
                        break;
                    case 'draft':
                        $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}  ";
                        $update_to_draft_status = mysqli_query($conn, $query);
                        confirmQuery($update_to_draft_status);
                        break;
                    case 'delete':
                        $query = "DELETE FROM posts WHERE post_id = {$postValueId}  ";
                        $update_to_delete_status = mysqli_query($conn, $query);
                        confirmQuery($update_to_delete_status);
                        break;
                    case 'clone':
                        $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}' ";
                        $select_post_query = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($select_post_query)) {
                            $post_title         = $row['post_title'];
                            $post_category_id   = $row['post_category_id'];
                            $user_id            = $_SESSION['user_id'];
                            $post_date          = $row['post_date'];
                            $post_status        = $row['post_status'];
                            $post_image         = $row['post_image'];
                            $post_tags          = $row['post_tags'];
                            $post_content       = $row['post_content'];
                        }
                        $query = "INSERT INTO posts(post_category_id, post_title, post_date,post_image,post_content,post_tags,post_status,user_id) 
                VALUES({$post_category_id},'{$post_title}',now(),'{$post_image}','{$post_content}','{$post_tags}', '{$post_status}',{$user_id}) ";
                        $copy_query = mysqli_query($conn, $query);

                        if (!$copy_query) {

                            die("QUERY FAILED" . mysqli_error($conn));
                        }
                        break;
                }
            }
        }
        ?> -->

<table class="table table-bordered table-hover">
   
    <thead>
        <tr>
            <!-- <th><input id="selectAllBoxes" type="checkbox"></th> -->
            <td>Id</td>
            <td>Author</td>
            <td>Title</td>
            <td>Category</td>
            <td>Status</td>
            <td>Image</td>
            <td>Tags</td>
            <td>Comments</td>
            <td>Date</td>
            <td>Views</td>
            <td>View post</td>
            <?php  if(!empty($_GET['source']) || $_SESSION['role'] == 'admin'): ?>
            <td>Edit</td>
            <td>Delete</td>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        display_all_posts();                       ?>
    </tbody>


</table>
<!-- </form> -->

<?php

if (isset($_POST['delete'])) {
    $the_post_id = $_POST['post_id'];
    $sql = "delete from posts where post_id = {$the_post_id}";
    $delete_query = mysqli_query($conn, $sql);
    confirmQuery($delete_query);


    $sql = "delete from comments where comment_post_id = {$the_post_id}";
    $delete_comment_query = mysqli_query($conn, $sql);
    confirmQuery($delete_comment_query);
    header("Location:posts.php");
}

?>