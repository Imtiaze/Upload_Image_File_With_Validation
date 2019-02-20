<?php
include 'inc/header.php';
include 'lib/Database.php';
?>
<?php
  $db = new Database();
?>
<section class="mainoption">
  <div class="myform">
    <form class="" action="" method="post" enctype="multipart/form-data">
      <table>
        <tr>
          <td>Select Image</td>
          <td><input type="file" name="image" value=""></td>
        </tr>
        <tr>
          <td></td>
          <td> <input type="submit" name="submit" value="Upload Image">  </td>
        </tr>
      </table>
    </form>
  </div>
</section>
<?php include 'inc/footer.php'; ?>
