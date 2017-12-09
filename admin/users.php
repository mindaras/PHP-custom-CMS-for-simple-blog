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
                            Users
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
                    </div>
                      <?php
                        if (isset($_GET['source'])) {
                          $source = $_GET['source'];
                        } else {
                          $source = '';
                        }
                        switch($source) {
                          case 'add_user':
                            include './includes/add_user.php';
                            break;
                          case 'edit_user':
                            include './includes/edit_user.php';
                            break;
                          default:
                            include './includes/view_all_users.php';
                        }
                      ?>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include './includes/footer.php'; ?>
