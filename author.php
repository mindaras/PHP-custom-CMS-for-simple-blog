<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

    <!-- Navigation -->
    <?php include 'includes/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
              <h1 class="page-header">
                  Blog Posts
                  <small>Written by Authors</small>
              </h1>

              <?php
                if (isset($_GET['p_author'])) {
                  $post_author = $_GET['p_author'];

                  $query = "SELECT * FROM posts WHERE post_author = '{$post_author}'";
                  $result = mysqli_query($connection, $query);
                  if (!mysqli_num_rows($result)) {
                    echo "<h1>There are no posts created by this author</h1>";
                  } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                      $post_id = $row['post_id'];
                      $post_title = $row['post_title'];
                      $post_author = $row['post_author'];
                      $post_date= $row['post_date'];
                      $post_image = $row['post_image'];
                      $post_content = $row['post_content'];
                      $post_content = substr($post_content, 100);
                ?>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                  <img class="img-responsive" src="./images/<?php echo $post_image; ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php
                      } // while
                    } // else
                  } // if
                ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include 'includes/footer.php'; ?>
