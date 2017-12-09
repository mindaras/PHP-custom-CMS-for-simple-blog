<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Username</th>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Email</th>
      <th>Image</th>
      <th>Role</th>
      <th>Admin</th>
      <th>Subscriber</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
<?php
  $query = "SELECT * FROM users";
  $result = mysqli_query($connection, $query);
  if (!$result) {
    die(mysqli_error($connection));
  }
  while ($row = mysqli_fetch_assoc($result)) {
    $user_id = $row['user_id'];
    $username = $row['username'];
    $user_password = $row['user_password'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
    $user_image = $row['user_image'];
    $user_role = $row['user_role'];
    $randSalt = $row['randSalt'];
    echo "
    <tr>
      <td>{$user_id}</td>
      <td>{$username}</td>
      <td>{$user_firstname}</td>
      <td>{$user_lastname}</td>
      <td>{$user_email}</td>
      <td><img src='../images/{$user_image}' style='height: 25px;'></td>
      <td>{$user_role}</td>
      <td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>
      <td><a href='users.php?change_to_sub={$user_id}'>Subscriber</a></td>
      <td><a href='users.php?source=edit_user&u_id={$user_id}'>Edit</a></td>
      <td><a onClick=\"javascript: return confirm('Are you sure you want to delete this user?'); \" href='users.php?delete={$user_id}'>Delete</a></td>
    </tr>";
  }
?>
  </tbody>
</table>

<?php
if (isset($_GET['delete']) && isset($_SESSION['user_role'])) {
  $user_id = $_GET['delete'];
  $query = "DELETE FROM `users` WHERE user_id = {$user_id}";
  $result = mysqli_query($connection, $query);
  if (!$result) {
    die(mysqli_query($connection));
  }
  header('Location: users.php');
}
?>

<?php
if (isset($_GET['change_to_admin'])) {
  $user_id = $_GET['change_to_admin'];
  $query = "UPDATE `users` SET `user_role`='admin' WHERE user_id = {$user_id}";
  $result = mysqli_query($connection, $query);
  if (!$result) {
    die(mysqli_query($connection));
  }
  header('Location: users.php');
}
?>

<?php
if (isset($_GET['change_to_sub'])) {
  $user_id = $_GET['change_to_sub'];
  $query = "UPDATE `users` SET `user_role`='subscriber' WHERE user_id = {$user_id}";
  $result = mysqli_query($connection, $query);
  if (!$result) {
    die(mysqli_query($connection));
  }
  header('Location: users.php');
}
?>
