<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Author</th>
      <th>Comment</th>
      <th>Email</th>
      <th>Status</th>
      <th>In Response to</th>
      <th>Date</th>
      <th>Approve</th>
      <th>Unapprove</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
<?php
  $query = "SELECT * FROM comments";
  $result = mysqli_query($connection, $query);
  if (!$result) {
    die(mysqli_error($connection));
  }
  while ($row = mysqli_fetch_assoc($result)) {
    $comment_id = $row['comment_id'];
    $comment_post_id = $row['comment_post_id'];
    $comment_author = $row['comment_author'];
    $comment_email = $row['comment_email'];
    $comment_content = $row['comment_content'];
    $comment_status = $row['comment_status'];
    $comment_date = $row['comment_date'];
    $post_title_query = "SELECT `post_title` FROM `posts` WHERE post_id = {$comment_post_id}";
    $post_title_result = mysqli_query($connection, $post_title_query);
    if (!$post_title_result) {
      die(mysqli_error($connection));
    }
    $post_title_row = mysqli_fetch_assoc($post_title_result);
    $post_title = $post_title_row['post_title'];
    echo "
    <tr>
      <td>{$comment_id}</td>
      <td>{$comment_author}</td>
      <td>{$comment_content}</td>
      <td>{$comment_email}</td>
      <td>{$comment_status}</td>
      <td><a href='../post.php?p_id={$comment_post_id}'>{$post_title}</a></td>
      <td>{$comment_date}</td>
      <td><a href='comments.php?approve={$comment_id}'>Approve</a></td>
      <td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>
      <td><a href='comments.php?delete={$comment_id}'>Delete</a></td>
    </tr>";
  }
?>
  </tbody>
</table>

<?php
if (isset($_GET['delete'])) {
  $comment_id = $_GET['delete'];
  $query = "DELETE FROM `comments` WHERE comment_id = {$comment_id}";
  $result = mysqli_query($connection, $query);
  if (!$result) {
    die(mysqli_query($connection));
  }
  header('Location: comments.php');
}
?>

<?php
if (isset($_GET['approve'])) {
  $comment_id = $_GET['approve'];
  $query = "UPDATE `comments` SET `comment_status`='approved' WHERE comment_id = {$comment_id}";
  $result = mysqli_query($connection, $query);
  if (!$result) {
    die(mysqli_query($connection));
  }
  header('Location: comments.php');
}
?>

<?php
if (isset($_GET['unapprove'])) {
  $comment_id = $_GET['unapprove'];
  $query = "UPDATE `comments` SET `comment_status`='unapproved' WHERE comment_id = {$comment_id}";
  $result = mysqli_query($connection, $query);
  if (!$result) {
    die(mysqli_query($connection));
  }
  header('Location: comments.php');
}
?>
