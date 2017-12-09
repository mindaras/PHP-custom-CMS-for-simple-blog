<?php
  if (isset($_POST['create_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];
    $user_image = $_FILES['image']['name'];
    $user_image_temp = $_FILES['image']['tmp_name'];
    move_uploaded_file($user_image_temp, "../images/{$user_image}");

    $user_firstname = mysqli_real_escape_string($connection, $user_firstname);
    $user_lastname = mysqli_real_escape_string($connection, $user_lastname);
    $username = mysqli_real_escape_string($connection, $username);
    $user_password = mysqli_real_escape_string($connection, $user_password);

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "INSERT INTO `users`(`username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`) ";
    $query .= "VALUES ('{$username}','{$user_password}','{$user_firstname}','{$user_lastname}','{$user_email}','{$user_image}','{$user_role}')";

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
      <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
      <label for="user_lastname">Lastname</label>
      <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
      <label for="user_role">Role</label>
      <select name="user_role" class="form-control" id="">
        <option value="subscriber">Subscriber</option>
        <option value="admin">Admin</option>
      </select>
    </div>
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
      <label for="user_password">Password</label>
      <input type="password" class="form-control" name="user_password">
    </div>
    <div class="form-group">
      <label for="user_email">Email</label>
      <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
      <label for="image">Avatar</label>
      <input type="file"  name="image">
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" name="create_user" value="Create User">
    </div>
  </form>
</div>
