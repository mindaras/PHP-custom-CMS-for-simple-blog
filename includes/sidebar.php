<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="./search" method="post">
          <div class="input-group">
              <input name="search" type="text" class="form-control">
              <span class="input-group-btn">
                  <button name="submit" class="btn btn-default" type="submit">
                      <span class="glyphicon glyphicon-search"></span>
              </button>
              </span>
          </div>
          <!-- /.input-group -->
        </form> <!-- search-form -->
    </div>

    <!-- Blog Search Well -->
    <div class="well">
        <?php
          if (isset($_SESSION['user_id'])) {
            $username = $_SESSION['username'];
            echo "
              <h4>Logged in as {$username}</h4>
              <a href='./admin/includes/logout.php' class='btn btn-primary'>Log out</a>";
          } else {
            echo "
              <h4>Login</h4>
              <form action='includes/login.php' method='post'>
                <div class='form-group'>
                  <input type='text' class='form-control' name='username' placeholder='Enter Username'>
                </div>
                <div class='input-group'>
                  <input type='password' class='form-control' name='password' placeholder='Enter Password'>
                  <div class='input-group-btn'>
                    <button class='btn btn-primary' type='submit' name='login'>Submit</button>
                  </div>
                </div>
                <!-- /.input-group -->
              </form> <!-- search-form -->
              <a href='./registration' style='display:block;margin-top:10px;'>Register</a>";
            }
          ?>
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                  <?php
                    $query = "SELECT * FROM categories";
                    $result = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                      $cat_id = $row['cat_id'];
                      $cat_title = $row['cat_title'];
                      echo "<li><a href='category.php?category={$cat_id}'>$cat_title</a></li>";
                    }
                  ?>
                </ul>
            </div>
        </div>
        <!-- /.row -->
    </div>

</div>
