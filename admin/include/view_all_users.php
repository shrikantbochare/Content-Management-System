<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <td>Id</td>
            <td>UserName</td>
            <td>FirstName</td>
            <td>LastName</td>
            <td>Email</td>
            <td>Role</td>
            <td>Approve</td>
            <td>Unapprove</td>
            <td>edit</td>
            <td>Delete</td>
           
        </tr>
    </thead>
    <tbody>
        <?php
         global $conn;
         $sql = "select * from user";
         $disply_users = mysqli_query($conn,$sql);
         while($row = mysqli_fetch_assoc($disply_users))
         {
             $user_id = $row['user_id'];
             $username = $row['username'];
             $user_firstname = $row['user_firstname'];
             $user_lastname = $row['user_lastname'];
             $user_password = $row['user_password'];
             $user_image = $row['user_image'];
             $user_email = $row['user_email'];
             $user_role = $row['user_role'];
        
             echo "<tr>";
             echo "<td> $user_id </td>";
             echo "<td> $username </td>";
              echo "<td>$user_firstname </td>"; 
             echo "<td> $user_lastname</td>";
             echo "<td> $user_email</td>";
             echo "<td>$user_role </td>";
             echo "<td><a href ='users.php?to_admin={$user_id}'>admin </a></td>";
             echo "<td><a href ='users.php?to_sub={$user_id}'>subscriber </a></td>";
             echo "<td><a href ='users.php?source=edit_user&u_id={$user_id}'>edit </a></td>";
             echo "<td><a href ='users.php?delete={$user_id}'>DELETE </a></td>";
             echo "</tr>";
         }                     ?>
    </tbody>

    
</table>

<?php
if(isset($_GET['to_admin']))
{
    $the_user_id = $_GET['to_admin'];
    $sql = "update user set user_role = 'admin' where user_id = {$the_user_id}";
    $approve_query = mysqli_query($conn,$sql);

    confirmQuery($approve_query);
    header("Location:users.php");
   
}
if(isset($_GET['to_sub']))
{
    $the_user_id = $_GET['to_sub'];
    $sql = "update user set user_role = 'subscriber' where user_id = {$the_user_id}";
    $unapprove_query = mysqli_query($conn,$sql);

    confirmQuery($unapprove_query);
    header("Location:users.php");
   
}
if(isset($_GET['delete']))
{
   if(isset($_SESSION['role']) && ($_SESSION['role']== 'admin'))
    {
        $user_id = $_GET['delete'];
        $sql = "delete from user where user_id = {$user_id}";
        $delete_query = mysqli_query($conn,$sql);
    
        confirmQuery($delete_query);
        header("Location:users.php");
    }
}

?>