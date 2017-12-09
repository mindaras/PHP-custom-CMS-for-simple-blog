<?php
  function insert_categories() {
    global $connection;
    if (isset($_POST['submit'])) {
      $cat_title = $_POST['cat_title'];
      if ($cat_title = "" || empty($cat_title)) {
        echo 'This field should not be empty';
      } else {
        $cat_title = $_POST['cat_title'];
        $query = "INSERT INTO `categories`(`cat_title`) VALUES ('{$cat_title}')";
        $result = mysqli_query($connection, $query);
        if (!$result) {
          die(mysqli_error($connection));
        }
      }
    }
  }

  function find_all_categories() {
    global $connection;

    $query = "SELECT * FROM categories";
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)) {
      $cat_id = $row['cat_id'];
      $cat_title = $row['cat_title'];
      echo "
        <tr>
          <td>{$cat_id}</td>
          <td>{$cat_title}</td>
          <td><a href='categories.php?edit={$cat_id}'>Edit</a></td>
          <td><a href='categories.php?delete={$cat_id}'>Delete</a></td>
        </tr>";
    }
  }

  function delete_categories() {
    global $connection;

    if (isset($_GET['delete'])) {
      $cat_id = $_GET['delete'];
      $query = "DELETE FROM `categories` WHERE `cat_id` = ${cat_id}";
      $result = mysqli_query($connection, $query);
      header('Location: categories.php');
      if (!$result) {
        die(mysqli_error($connection));
      }
    }
  }
?>
