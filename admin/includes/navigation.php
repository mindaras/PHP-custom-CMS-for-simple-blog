<?php
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_firstname = $_SESSION['user_firstname'];
    $user_lastname = $_SESSION['user_lastname'];
  }
?>

<?php
  $session = session_id();
  $time = time();
  $time_out_in_seconds = 60;
  $time_out = $time - $time_out_in_seconds;

  $query = "SELECT * FROM users_online WHERE session = '{$session}'";
  $result = mysqli_query($connection, $query);
  $users_count = mysqli_num_rows($result);

  if ($users_count == NULL) {
    $insert_query = "INSERT INTO `users_online`(`session`, `time`) VALUES ('{$session}','{$time}')";
    $insert_result = mysqli_query($connection, $insert_query);
  } else {
    $update_query = "UPDATE `users_online` SET `time`='{$time}' WHERE session = '{$session}'";
    $update_result = mysqli_query($connection, $update_query);
    if (!$update_result) {
      die(mysqli_error($connection));
    }
  }

  $users_query = "SELECT * FROM `users_online` WHERE `time` > '{$time_out}'";
  $users_result = mysqli_query($connection, $users_query);
  $users_count = mysqli_num_rows($users_result);
?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./">Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li><a href="">Users Online: <?php echo $users_count; ?></a></li>
        <li><a href="../">Home page</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $user_firstname . ' ' . $user_lastname; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="./profile"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
          <?php
            if (isset($_SESSION['user_role'])) {
              if ($_SESSION['user_role'] == 'admin') {

              ?>
            <li>
                <a href="./"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="posts_dropdown" class="collapse">
                    <li>
                        <a href="./posts">View All Posts</a>
                    </li>
                    <li>
                        <a href="posts.php?source=add_post">Add Post</a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="./categories"><i class="fa fa-fw fa-table"></i> Categories</a>
            </li>
            <li>
                <a href="./comments"><i class="fa fa-fw fa-table"></i> Comments</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo" class="collapse">
                    <li>
                        <a href="./users">View All Users</a>
                    </li>
                    <li>
                        <a href="users.php?source=add_user">Add User</a>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="./profile"><i class="fa fa-fw fa-file"></i> Profile</a>
            </li>
            <?php
              } else {

              ?>
                <li>
                    <a href="./"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="posts_dropdown" class="collapse">
                        <li>
                            <a href="posts.php?source=add_post">Add Post</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="./profile"><i class="fa fa-fw fa-file"></i> Profile</a>
                </li>
            <?php
                }
              }
            ?>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>
