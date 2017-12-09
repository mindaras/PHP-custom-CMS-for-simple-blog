<?php include './includes/header.php'; ?>

<?php
  if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] !== 'admin') {
      header('Location: index.php');
    }
  }
?>

    <div id="wrapper">

      <!-- Navigation -->
      <?php include './includes/navigation.php'; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Categories
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
                    </div>
                    <div class="col-lg-6">
                      <?php insert_categories(); ?>
                      <form action="" method="post">
                        <label for="">Add Category</label>
                        <div class="form-group">
                          <input type="text" class="form-control" name="cat_title">
                        </div>
                        <div class="form-group">
                          <input name="submit" type="submit" class="btn btn-primary">
                        </div>
                      </form>
                      <?php // update categories
                        if (isset($_GET['edit'])) {
                          $cat_id = $_GET['edit'];
                          include './includes/update_categories.php';
                        }
                      ?>
                    </div> <!-- col-lg-6 -->
                    <div class="col-lg-6">
                      <table class="table table-bordered table-hover">
                        <thead>
                          <th>Id</th>
                          <th>Category Title</th>
                          <th>Edit</th>
                          <th>Delete</th>
                        </thead>
                        <tbody>
                          <?php find_all_categories(); ?>
                          <?php delete_categories(); ?>
                        </tbody>
                      </table>
                    </div> <!-- col-lg-6 -->
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include './includes/footer.php'; ?>
