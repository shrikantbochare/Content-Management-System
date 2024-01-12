<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>


<!-- Navigation -->

<?php include "includes/navigation.php"; ?>


<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $username = escape($_POST['username']);
    $email = escape($_POST['email']);
    $password = escape($_POST['password']);
    
    $error = [
        'username' => '',
        'email' => '',
        'password' => ''
    ];

    if(strlen($username)<5)
    {
        $error['username'] = "username too short";
    }
    if(empty($username))
    {
        $error['username'] = "username cannot be empty";
    }
   if(user_exists($username))
    {
        $error['username'] = "username not availabe";
    }
    if(empty($email))
    {
        $error['email'] = "email cannot be empty";
    }
    if(email_exists($email))
    {
        $error['email'] = "email already registered <a href='index.php'>login</a>";
    }
   if(empty($password))
    {
        $error['password'] = "password cannot be empty";
    }


    foreach($error as $key=>$value)
    {
        if(empty($value))
        {
            unset($error[$key]);
        }
    }

    if(empty($error))
    {
        $message = registration($username,$email,$password);
    }
}



?>


<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <h6 class="text-center"><?php echo isset($message)? $message: ""; ?></h6>
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                                <p><?php echo isset($error['username']) ?  $error['username'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                                <p><?php echo isset($error['email']) ?  $error['email'] : "" ?></p>
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                <p><?php echo isset($error['password']) ?  $error['password'] : "" ?></p>
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>