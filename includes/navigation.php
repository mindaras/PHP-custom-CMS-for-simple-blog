
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">Home Page</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                  $query = "SELECT * FROM categories";
                  $result = mysqli_query($connection, $query);

                  while ($row = mysqli_fetch_assoc($result)) {
                    $title = $row['cat_title'];
                    $cat_id = $row['cat_id'];
                    if (isset($_GET['category'])) {
                      $get_id = $_GET['category'];
                      if ($get_id == $cat_id) {
                        echo "<li class='active'><a href='category.php?category={$cat_id}'>{$title}</a></li>";
                      } else {
                        echo "<li><a href='category.php?category={$cat_id}'>{$title}</a></li>";
                      }
                    } else {
                      echo "<li><a href='category.php?category={$cat_id}'>{$title}</a></li>";
                    }
                  }

                  $pageName = basename($_SERVER['PHP_SELF']);
                  if ($pageName == 'registration.php') {
                    echo "<li class='active'><a href='./registration'>Registration</a></li>";
                  } else {
                    echo "<li><a href='./registration'>Registration</a></li>";
                  }
                ?>
                <li><a href="./admin">Admin</a></li>
                <?php
                  if (isset($_SESSION['user_id'])) {
                    if (isset($_GET['p_id'])) {
                      $post_id = $_GET['p_id'];
                      echo "<li><a href='./admin/posts.php?source=edit_post&p_id={$post_id}'>Edit Post</a></li>";
                    }
                  }
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
