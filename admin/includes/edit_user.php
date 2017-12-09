<?php
  if (isset($_GET['u_id'])) {
    $user_id = $_GET['u_id'];
    $query = "SELECT * FROM users WHERE user_id = {$user_id}";
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die(mysqli_error($connection));
    }
    $row = mysqli_fetch_assoc($result);
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_role = $row['user_role'];
    $username = $row['username'];
    $user_password = $row['user_password'];
    $user_email = $row['user_email'];
    $user_image = $row['user_image'];
  }
?>

<?php
  if (isset($_POST['update_user'])) {
    $user_id = $_GET['u_id'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];
    $user_image = $_FILES['image']['name'];
    $user_image_temp = $_FILES['image']['tmp_name'];

    $user_firstname = mysqli_real_escape_string($connection, $user_firstname);
    $user_lastname = mysqli_real_escape_string($connection, $user_lastname);
    $username = mysqli_real_escape_string($connection, $username);
    $user_password = mysqli_real_escape_string($connection, $user_password);
    $user_email = mysqli_real_escape_string($connection, $user_email);

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "UPDATE `users` SET ";
    $query .= "`username`='{$username}',";
    $query .= "`user_password`='{$user_password}',";
    $query .= "`user_firstname`='{$user_firstname}',";
    $query .= "`user_lastname`='{$user_lastname}',";
    $query .= "`user_email`='{$user_email}',";
    if (empty($user_image)) {
      $image_query = "SELECT user_image FROM users WHERE user_id = {$user_id}";
      $image_query_result = mysqli_query($connection, $image_query);
      if (!$image_query_result) {
        die(mysqli_error($connection));
      }
      $row = mysqli_fetch_assoc($image_query_result);
      $user_image = $row['user_image'];
    }
    $query .= "`user_image`='{$user_image}',";
    $query .="`user_role`='{$user_role}' ";
    $query .= "WHERE user_id = {$user_id}";

    move_uploaded_file($user_image_temp, "../images/{$user_image}");

    $result = mysqli_query($connection, $query);
    if (!$result) {
      die(mysqli_error($connection));
    }
    header("Location: users.php");
  }
?>

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
      <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
    </div>
  </form>
</div>
