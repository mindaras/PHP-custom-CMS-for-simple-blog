<?php
  if (isset($_POST['create_post'])) {
    $post_title = $_POST['title'];
    $post_title = $post_content = mysqli_real_escape_string($connection, $post_title);
    $post_category_id = $_POST['post_category_id'];
    $post_author = $_POST['author'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_content = mysqli_real_escape_string($connection, $post_content);
    $post_date = date('d-m-y');

    move_uploaded_file($post_image_temp, "../images/{$post_image}");

    $query = "INSERT INTO `posts`(`post_category_id`, `post_title`, `post_author`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_status`) ";
    $query .= "VALUES ({$post_category_id},'{$post_title}','{$post_author}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die(mysqli_error($connection));
    }
    $post_id = mysqli_insert_id($connection);
    echo "
      <div class='col-lg-12'>
        <p class='bg-success' style='padding: 15px 20px; border-radius: 4px;'>The post have been created. <a href='../post.php?p_id={$post_id}'>View Post</a> | <a href='posts.php'>View All Posts</a></p>
      </div>";
  }
?>

<div class="col-lg-6 col-sm-12">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="title">Post Title</label>
      <input type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
      <label for="post_category_id">Post Category Id</label>
      <select name="post_category_id" class="form-control" id="">
        <?php
          $query = "SELECT * FROM `categories`";
          $result = mysqli_query($connection, $query);
          if (!$result) {
            die(mysqli_error($connection));
          }
          while ($row = mysqli_fetch_assoc($result)) {
            $cat_title = $row['cat_title'];
            $cat_id = $row['cat_id'];
            echo "
            <option value='{$cat_id}'>{$cat_title}</option>";
          }
        ?>
      </select>
    </div>
    <div class="form-group">
      <label for="author">Post Author</label>
      <input type="text" class="form-control" name="author">
    </div>
    <div class="form-group">
      <label for="post_status">Post Status</label>
      <select name="post_status" class="form-control" id="">
        <option value="draft">draft</option>
        <option value="published">published</option>
      </select>
    </div>
    <div class="form-group">
      <label for="image">Post Image</label>
      <input type="file"  name="image">
    </div>
    <div class="form-group">
      <label for="post_tags">Post Tags</label>
      <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
      <label for="post_content">Post Content</label>
      <textarea name="post_content" rows="10" cols="30" class="form-control"></textarea>
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
    </div>
  </form>
</div>
