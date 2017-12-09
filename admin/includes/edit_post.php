<?php
  if (isset($_GET['p_id'])) {
    $post_id = $_GET['p_id'];
    $query = "SELECT * FROM `posts` WHERE post_id = {$post_id}";
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die(mysqli_error($connection));
    }
    while ($row = mysqli_fetch_assoc($result)) {
      $post_category_id = $row['post_category_id'];
      $post_title = $row['post_title'];
      $post_author = $row['post_author'];
      $post_image = $row['post_image'];
      $post_content = $row['post_content'];
      $post_tags = $row['post_tags'];
      $post_comment_count = $row['post_comment_count'];
      $post_status = $row['post_status'];
    }
  }
?>
<?php
  if (isset($_POST['update_post'])) {
    $post_category_id = $_POST['post_category_id'];
    $post_title = $_POST['title'];
    $post_title = $post_content = mysqli_real_escape_string($connection, $post_title);
    $post_author = $_POST['author'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $post_content = $_POST['post_content'];
    $post_content = $post_content = mysqli_real_escape_string($connection, $post_content);
    $post_tags = $_POST['post_tags'];
    $post_status = $_POST['post_status'];
    $reset_views = $_POST['reset_views'];

    if ($reset_views == 'yes') {
      $reset_query = "UPDATE posts SET post_views = 0 WHERE post_id = {$post_id}";
      $reset_result = mysqli_query($connection, $reset_query);
      if (!$reset_result) {
        die(mysqli_error($connection));
      }
    }

    $query = "UPDATE posts SET ";
    $query .= "post_category_id={$post_category_id},";
    $query .= "post_title='{$post_title}',";
    $query .= "post_author='{$post_author}',";
    $query .= "post_date=now(),";
    if (empty($post_image)) {
      $image_query = "SELECT post_image FROM posts WHERE post_id = {$post_id}";
      $image_query_result = mysqli_query($connection, $image_query);
      if (!$image_query_result) {
        die(mysqli_error($connection));
      }
      $row = mysqli_fetch_assoc($image_query_result);
      $post_image = $row['post_image'];
    }
    $query .= "post_image='{$post_image}',";
    $query .= "post_content='{$post_content}',";
    $query .= "post_tags='{$post_tags}',";
    $query .= "post_status='{$post_status}'";
    $query .= "WHERE post_id = {$post_id}";

    move_uploaded_file($post_image_temp, "../images/{$post_image}");

    $result = mysqli_query($connection, $query);
    if (!$result) {
      die(mysqli_error($connection));
    }
    echo "
      <div class='col-lg-12'>
        <p class='bg-success' style='padding: 15px 20px; border-radius: 4px;'>The post have been edited. <a href='../post.php?p_id={$post_id}'>View Post</a> | <a href='posts.php'>View All Posts</a></p>
      </div>";
  }
?>
<div class="col-lg-6 col-sm-12">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="title">Post Title</label>
      <input type="text" class="form-control" name="title" value="<?php echo $post_title; ?>">
    </div>
    <div class="form-group">
      <label for="post_category_id">Post Category Id</label>
      <select name="post_category_id" class="form-control" id="">
        <?php
          $query = "SELECT cat_id, cat_title FROM `categories`";
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
      <input type="text" class="form-control" name="author" value="<?php echo $post_author; ?>">
    </div>
    <div class="form-group">
      <label for="post_status">Post Status</label>
      <?php
        $query = "SELECT post_status FROM `posts` WHERE post_id = {$post_id}";
        $result = mysqli_query($connection, $query);
        if (!$result) {
          die(mysqli_error($connection));
        }
        while ($row = mysqli_fetch_assoc($result)) {
          $post_status = $row['post_status'];
        }
      ?>
      <select name="post_status" class="form-control" id="">
        <option value='draft' <?php if ($post_status == 'draft') echo 'selected'; ?>>draft</option>
        <option value='published' <?php if ($post_status == 'published') echo 'selected'; ?>>published</option>
      </select>
    </div>
    <div class="form-group">
      <label for="reset_views">Reset Views</label>
      <select name="reset_views" class="form-control" id="">
        <option value='no' selected>no</option>
        <option value='yes'>yes</option>
      </select>
    </div>
    <div class="form-group">
      <label for="image">Post Image</label><br>
      <img src="../images/<?php echo $post_image; ?>" style="width: 100px;" alt="">
      <input type="file"  name="image">
    </div>
    <div class="form-group">
      <label for="post_tags">Post Tags</label>
      <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>
    <div class="form-group">
      <label for="post_content">Post Content</label>
      <textarea name="post_content" rows="10" cols="30" class="form-control"><?php echo $post_content; ?></textarea>
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-primary" name="update_post" value="Publish Post">
    </div>
  </form>
</div>
