<?php
  if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] !== 'admin') {
      header('Location: index.php');
    }
  }
?>

<?php
  if (isset($_POST['checkboxArray'])) {
    if (isset($_POST['bulk_option'])) {
      $bulk_option = $_POST['bulk_option'];
      $checkboxArray = $_POST['checkboxArray'];
      foreach ($checkboxArray as $checkbox) {
        switch ($bulk_option) {
          case 'publish':
            $query = "UPDATE `posts` SET `post_status`='published' WHERE post_id = {$checkbox}";
            $result = mysqli_query($connection, $query);
            if (!$result) {
              die(mysqli_error($connection));
            }
            break;
          case 'draft':
            $query = "UPDATE `posts` SET `post_status`='draft' WHERE post_id = {$checkbox}";
            $result = mysqli_query($connection, $query);
            if (!$result) {
              die(mysqli_error($connection));
            }
            break;
          case 'clone':
            $query = "SELECT * FROM `posts` WHERE post_id = {$checkbox}";
            $result = mysqli_query($connection, $query);
            if (!$result) {
              die(mysqli_error($connection));
            }
            $row = mysqli_fetch_assoc($result);
            $post_category_id = $row['post_category_id'];
            $post_title = $row['post_title'];
            $post_author = $row['post_author'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_status = $row['post_status'];
            $post_date = date('d-m-y');

            $post_title = mysqli_real_escape_string($connection, $post_title);
            $post_author = mysqli_real_escape_string($connection, $post_author);
            $post_content = mysqli_real_escape_string($connection, $post_content);
            $post_tags = mysqli_real_escape_string($connection, $post_tags);

            $insert_query = "INSERT INTO `posts`(`post_category_id`, `post_title`, `post_author`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_status`) ";
            $insert_query .= "VALUES ({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";
            $insert_result = mysqli_query($connection, $insert_query);
            if (!$insert_result) {
              die(mysqli_error($connection));
            }
            break;
          case 'delete':
            $query = "DELETE FROM `posts` WHERE post_id = {$checkbox}";
            $result = mysqli_query($connection, $query);
            if (!$result) {
              die(mysqli_error($connection));
            }
            break;
        }
      }
    }
  }
?>
<form action="" method="post">
  <div id="bulkOptionsContainer" style="margin-bottom: 20px;">
    <h4>Bulk Options</h4>
    <div class="col-xs-4" style="padding-left: 0;">
      <div class="form-group">
        <select class="form-control" name="bulk_option">
          <option value="default" disabled selected>Select Options</option>
          <option value="publish">Publish</option>
          <option value="draft">Draft</option>
          <option value="clone">Clone</option>
          <option value="delete">Delete</option>
        </select>
      </div>
    </div>
    <button name="submitBulk" type="submit" class="btn btn-success">Apply</button>
    <a href="./posts.php?source=add_post" class="btn btn-primary">Add New</a>
  </div>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th><input type="checkbox" id="allCheckboxes"></th>
        <th>Id</th>
        <th>Author</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Views</th>
        <th>Comments</th>
        <th>Date</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
  <?php
    $query = "SELECT * FROM posts ORDER BY post_id DESC";
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die(mysqli_error($connection));
    }
    while ($row = mysqli_fetch_assoc($result)) {
      $post_id = $row['post_id'];
      $post_author = $row['post_author'];
      $post_title = $row['post_title'];
      $post_category = $row['post_category_id'];
      $post_author = $row['post_author'];
      $post_date = $row['post_date'];
      $post_image = $row['post_image'];
      $post_content = $row['post_content'];
      $post_tags = $row['post_tags'];
      $post_views = $row['post_views'];
      $post_comment_count_query = "SELECT comment_id FROM comments WHERE comment_post_id = {$post_id}";
      $post_comment_count_result = mysqli_query($connection, $post_comment_count_query);
      $post_comment_count = mysqli_num_rows($post_comment_count_result);
      $post_status = $row['post_status'];
      $post_cat_query = "SELECT * FROM categories WHERE cat_id = {$post_category}";
      $post_cat_result = mysqli_query($connection, $post_cat_query);
      if (!$post_cat_result) {
        die(mysqli_error($connection));
      }
      $post_cat_row = mysqli_fetch_assoc($post_cat_result);
      $post_category = $post_cat_row['cat_title'];
      echo "
      <tr>
        <td><input type='checkbox' class='checkboxes' name='checkboxArray[]' value='{$post_id}' /></td>
        <td>{$post_id}</td>
        <td>{$post_author}</td>
        <td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>
        <td>{$post_category}</td>
        <td>{$post_status}</td>
        <td><img src='../images/{$post_image}' style='width:100px'></td>
        <td>{$post_tags}</td>
        <td>{$post_views}</td>
        <td>{$post_comment_count}</td>
        <td>{$post_date}</td>
        <td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>
        <td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?'); \" href='posts.php?delete={$post_id}' id='deletePost'>Delete</a></td>
      </tr>";
    }
  ?>
  <?php
    if (isset($_GET['delete']) && isset($_SESSION['user_role'])) {
      $post_id =   $_GET['delete'];
      $query = "DELETE FROM `posts` WHERE post_id = {$post_id}";
      $result = mysqli_query($connection, $query);
      if (!$result) {
        die(mysqli_query($connection));
      }
      header('Location: posts.php');
    }
  ?>
    </tbody>
  </table>
</form>
