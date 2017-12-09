<?php include './includes/header.php'; ?>

    <div id="wrapper">

      <!-- Navigation -->
      <?php include './includes/navigation.php'; ?>

        <div id="page-wrapper">

            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                <?php
                  $posts_query = "SELECT * FROM posts";
                  $posts_result = mysqli_query($connection, $posts_query);
                  $posts_count = mysqli_num_rows($posts_result);

                  $comments_query = "SELECT * FROM comments";
                  $comments_result = mysqli_query($connection, $comments_query);
                  $comments_count = mysqli_num_rows($comments_result);

                  $users_query = "SELECT * FROM users";
                  $users_result = mysqli_query($connection, $users_query);
                  $users_count = mysqli_num_rows($users_result);

                  $categories_query = "SELECT * FROM categories";
                  $categories_result = mysqli_query($connection, $categories_query);
                  $categories_count = mysqli_num_rows($categories_result);
                ?>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                  <div class='huge'><?php echo $posts_count; ?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                     <div class='huge'><?php echo $comments_count; ?></div>
                                      <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $users_count; ?></div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo $categories_count; ?></div>
                                         <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
                  $active_posts_query = "SELECT * FROM posts WHERE post_status = 'published'";
                  $active_posts_result = mysqli_query($connection, $active_posts_query);
                  $active_posts_count = mysqli_num_rows($active_posts_result);

                  $draft_posts_query = "SELECT * FROM posts WHERE post_status = 'draft'";
                  $draft_posts_result = mysqli_query($connection, $draft_posts_query);
                  $draft_posts_count = mysqli_num_rows($draft_posts_result);

                  $approved_comments_query = "SELECT * FROM comments WHERE comment_status = 'approved'";
                  $approved_comments_result = mysqli_query($connection, $approved_comments_query);
                  $approved_comments_count = mysqli_num_rows($approved_comments_result);

                  $unapproved_comments_query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
                  $unapproved_comments_result = mysqli_query($connection, $unapproved_comments_query);
                  $unapproved_comments_count = mysqli_num_rows($unapproved_comments_result);

                  $admin_users_query = "SELECT * FROM users WHERE user_role = 'admin'";
                  $admin_users_result = mysqli_query($connection, $admin_users_query);
                  $admin_users_count = mysqli_num_rows($admin_users_result);

                  $subscriber_users_query = "SELECT * FROM users WHERE user_role = 'subscriber'";
                  $subscriber_users_result = mysqli_query($connection, $subscriber_users_query);
                  $subscriber_users_count = mysqli_num_rows($subscriber_users_result);
                ?>
                <script type="text/javascript">
                  google.charts.load('current', {'packages':['bar']});
                  google.charts.setOnLoadCallback(drawChart);

                  function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                      ['Data', 'Count'],
                      <?php
                        $data_labels = ['Active Posts', 'Draft Posts', 'Approved Comments', 'Unapproved Comments', 'Subscribers'];
                        $data = [$active_posts_count, $draft_posts_count, $approved_comments_count, $unapproved_comments_count, $subscriber_users_count];

                        for ($i=0; $i<5; $i++) {
                          echo "['{$data_labels[$i]}'" . "," . "{$data[$i]}],";
                        }
                      ?>
                    ]);

                    var options = {
                      chart: {
                        title: '',
                        subtitle: '',
                      }
                    };

                    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                    chart.draw(data, google.charts.Bar.convertOptions(options));
                  }
                </script>
                <div id="columnchart_material" style="height: 500px;"></div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include './includes/footer.php'; ?>
