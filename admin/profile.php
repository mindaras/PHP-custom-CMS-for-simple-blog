<?php include './includes/header.php'; ?>

    <div id="wrapper">

      <!-- Navigation -->
      <?php include './includes/navigation.php'; ?>

        <div id="page-wrapper">

            <div class="container-fluid">
              <?php
                if (isset($_SESSION['username'])) {
                  $user_id = $_SESSION['user_id'];

                  $query = "SELECT * FROM users WHERE user_id = '{$user_id}'";
                  $result = mysqli_query($connection, $query);

                  if (!$result) {
                    die(mysqli_error($connection));
                  }

                  $row = mysqli_fetch_assoc($result);

                  $username = $row['username'];
                  $user_firstname = $row['user_firstname'];
                  $user_lastname = $row['user_lastname'];
                  $user_role = $row['user_role'];
                  $user_password = $row['user_password'];
                  $user_email = $row['user_email'];
                  $user_image = $row['user_image'];
                }
              ?>
              <?php
                if (isset($_POST['update_profile'])) {
                  $user_id = $_SESSION['user_id'];
                  $username = $_POST['username'];
                  $user_firstname = $_POST['user_firstname'];
                  $user_lastname = $_POST['user_lastname'];
                  $user_role = $_POST['user_role'];
                  $user_password = $_POST['user_password'];
                  $user_email = $_POST['user_email'];
                  $user_image = $_FILES['image']['name'];
                  $user_image_temp = $_FILES['image']['tmp_name'];

                  move_uploaded_file($user_image_temp, "../images/{$user_image}");

                  $query = "UPDATE `users` SET ";
                  $query .="username = '{$username}', ";
                  $query .="user_firstname = '{$user_firstname}', ";
                  $query .="user_lastname = '{$user_lastname}', ";
                  $query .="user_role = '{$user_role}', ";
                  $query .="user_password = '{$user_password}', ";
                  $query .="user_email = '{$user_email}', ";
                  $query .="user_image = '{$user_image}' ";
                  $query .="WHERE user_id = {$user_id}";

                  $result = mysqli_query($connection, $query);

                  if (!$result) {
                    die(mysqli_error($connection));
                  }
                }
              ?>

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Profile
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                      <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="user_firstname">Firstname</label>
                          <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
                        </div>
                        <div class="form-group">
                          <label for="user_lastname">Lastname</label>
                          <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
                        </div>
                        <div class="form-group">
                          <label for="user_role">Role</label>
                          <select name="user_role" class="form-control" id="">
                            <option value="subscriber" <?php if ($user_role == 'subscriber') echo 'selected'; ?>>Subscriber</option>
                            <option value="admin" <?php if ($user_role == 'admin') echo 'selected'; ?>>Admin</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="username">Username</label>
                          <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                        </div>
                        <div class="form-group">
                          <label for="user_password"></label>
                          <input type="password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
                        </div>
                        <div class="form-group">
                          <label for="user_email"></label>
                          <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
                        </div>
                        <div class="form-group">
                          <img src="../images/<?php echo $user_image; ?>" alt="" style="height: 50px;">
                          <label for="image">Avatar</label>
                          <input type="file"  name="image">
                        </div>
                        <div class="form-group">
                          <input type="submit" class="btn btn-primary" name="update_profile" value="Update Profile">
                        </div>
                      </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include './includes/footer.php'; ?>
