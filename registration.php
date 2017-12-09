<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>

    <!-- Navigation -->

    <?php  include "includes/navigation.php"; ?>

    <?php
      if (isset($_POST['submit'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user_role = 'subscriber';

        $username = mysqli_real_escape_string($connection, $username);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);

        if (!empty($username) && !empty($email) && !empty($password)) {
          $check_username_query = "SELECT * FROM users WHERE username = '{$username}'";
          $check_username_result = mysqli_query($connection, $check_username_query);
          $check_username_count = mysqli_num_rows($check_username_result);
          $check_email_query = "SELECT * FROM users WHERE user_email = '{$email}'";
          $check_email_result = mysqli_query($connection, $check_email_query);
          $check_email_count = mysqli_num_rows($check_email_result);
          if ($check_username_count > 0) {
            $message = "The username already exists";
          } elseif ($check_email_count > 0) {
            $message = "This email address is already in use";
          } else {
            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
            $query = "INSERT INTO `users`(`username`, `user_password`, `user_email`, `user_role`) ";
            $query .= "VALUES ('{$username}','{$password}','{$email}','{$user_role}')";
            $result = mysqli_query($connection, $query);
            if (!$result) {
              die(mysqli_error($connection));
            }
            $message = 'User have been registered successfully';
          }
        } else {
          $message = 'Fields cannot be empty';
        }
      }
    ?>

    <!-- Page Content -->
    <div class="container">

      <?php
        if (isset($_SESSION['user_id'])) {
          echo "
            <p>You are already logged in, in order to start new registration process, you need to log out first</p>
            <a href='./admin/includes/logout.php' class='btn btn-primary'>Log out</a>";
        } else {

        ?>

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <p><?php if (!empty($message)) echo $message; ?></p>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" value="<?php echo isset($username) ? $username : ''; ?>">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" value="<?php echo isset($email) ? $email : ''; ?>">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>

                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<?php } //else ?>


        <hr>



<?php include "includes/footer.php";?>
