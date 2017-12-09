<form action="" method="post">
  <label for="">Edit Category</label>
  <div class="form-group">
    <?php
      if (isset($_GET['edit'])) {
        $cat_id = $_GET['edit'];
        $query = "SELECT cat_title FROM categories WHERE cat_id = {$cat_id}";
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        if (!$result) {
          die($connection);
        }
      ?>
      <input type="text" class="form-control" name="cat_title" value="<?php echo $row['cat_title'] ?>">

    <?php } //if ?>
    <?php // update category
      if (isset($_POST['update_category'])) {
        $cat_title = $_POST['cat_title'];
        $query = "UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id = {$cat_id}";
        $result = mysqli_query($connection, $query);
        if (!$result) {
          die(mysqli_error($connection));
        }
        header('Location: categories.php');
      }
    ?>
  </div>
  <div class="form-group">
    <input name="update_category" type="submit" class="btn btn-primary" value="Update">
  </div>
</form>
