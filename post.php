<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>

<?php
  if (isset($_GET['p_id'])) {
    $post_id = $_GET['p_id'];
    $query = "SELECT * FROM posts WHERE post_id = {$post_id}";
    $result = mysqli_query($connection, $query);
    if (!$result) {
      die(mysqli_error($connection));
    }
    $row = mysqli_fetch_assoc($result);
    $post_title = $row['post_title'];
    $post_author = $row['post_author'];
    $post_date = $row['post_date'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];

    $views_query = "UPDATE `posts` SET `post_views` = post_views + 1 WHERE post_id = {$post_id}";
    $views_result = mysqli_query($connection, $views_query);
  ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?php echo $post_title; ?></h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="author.php?p_author=<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="./images/<?php echo $post_image; ?>" alt="">

                <hr>

                <!-- Post Content -->
                <p><?php echo $post_content; ?></p>

                <hr>

                <!-- Blog Comments -->
                <?php
                  if (isset($_POST['comment_submit'])) {
                    $comment_post_id = $_GET['p_id'];
                    $comment_author = $_POST['comment_author'];
                    $comment_email = $_POST['comment_email'];
                    $comment_content = $_POST['comment_content'];
                    $comment_content = mysqli_real_escape_string($connection, $comment_content);
                    $comment_status = "unapproved";

                    if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                      $query = "INSERT INTO comments (`comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) ";
                      $query .= "VALUES ({$comment_post_id},'{$comment_author}','{$comment_email}','{$comment_content}','{$comment_status}',now())";
                      $result = mysqli_query($connection, $query);
                      if (!$result) {
                        die(mysqli_error($connection));
                      }
                    } else {
                      echo "<script>alert('Fields cannot be empty')</script>";
                    }
                  }
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post">
                      <div class="form-group">
                          <input type="text" class="form-control" name="comment_author" placeholder="Author">
                      </div>
                      <div class="form-group">
                          <input type="email" class="form-control" name="comment_email" placeholder="Email">
                      </div>
                      <div class="form-group">
                          <textarea class="form-control" name="comment_content" rows="3"></textarea>
                      </div>
                      <button type="submit" name="comment_submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php
                  $post_id = $_GET['p_id'];
                  $query = "SELECT `comment_author`, `comment_content`, `comment_date` FROM `comments` ";
                  $query .= "WHERE comment_post_id = {$post_id} AND comment_status = 'approved' ORDER BY comment_id DESC";
                  $result = mysqli_query($connection, $query);
                  if (!$result) {
                    die(mysqli_error($connection));
                  }
                  while ($row = mysqli_fetch_assoc($result)) {
                    $comment_author = $row['comment_author'];
                    $comment_date = $row['comment_date'];
                    $comment_content = $row['comment_content'];
                ?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>
                <?php
                  } // while
                ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'; ?>


        </div>
        <!-- /.row -->

        <?php
          } else {
            header('Location: index.php');
          }
        ?>

        <hr>

  <?php include 'includes/footer.php'; ?>
