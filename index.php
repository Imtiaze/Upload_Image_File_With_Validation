<?php
include 'inc/header.php';
include 'lib/Database.php';
?>
<?php
$db = new Database();

?>
<section class="mainoption">
  <div class="myform">
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      $permitted =  array('jpg','jpeg','png','gif');
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_path = $_FILES['image']['tmp_name'];

      $div = explode('.', $file_name);
      $file_extension = end($div);
      $unique_image = substr(md5(time()), 0,10).'.'.$file_extension;

      $uploaded_image = 'uploads/'.$unique_image;



      move_uploaded_file($file_path, $uploaded_image);

      $sql = "INSERT INTO tbl_image(image) VALUES('$uploaded_image')";
      $insert = $db->insert($sql);
      if($insert){
        echo "<span class='success'>File upload successfull.</span>";

      }
      else {
        echo "<span class='error'>File not uploaded.</span>";
      }
    }
    ?>
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
