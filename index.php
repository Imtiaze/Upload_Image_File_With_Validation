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
      $file_extension = strtolower(end($div));
      $unique_image   = substr(md5(time()), 0,10).'.'.$file_extension;
      $uploaded_image = 'uploads/'.$unique_image;

      if(empty($file_name)) {
        echo "<span class='error'>Please insert an image!</span>";
      }
      elseif($file_size > 1048576) {  //1048576 bytes = 1MB
        echo "<span class='error'>File size should be less than 1MB!</span>";
      }
      elseif(in_array($file_extension, $permitted) ===false) {
        echo "<span class='error'>You can upload only :- ".implode(', ',$permitted)."</span>";
      }
      else {
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
    <table style="margin-top:20px;">
      <tr>
        <th width="30%">serial</th>
        <th width="30%">Image</th>
        <th width="30%">Action</th>
      </tr>

      <!-- delete image from server and database -->
      <?php
      if (isset($_GET['delete'])) {
        $id       = $_GET['delete'];
        $query    = "SELECT * FROM tbl_image WHERE id='$id'";
        $getImage = $db->select($query);
        if($getImage){
          while($imageData = $getImage->fetch_object()) {
            $deleteImage = $imageData->image;
            unlink($deleteImage);
          }
        }

        $query  = "DELETE FROM tbl_image WHERE id='$id'";
        $result = $db->delete($query);
        if($result){
          echo "<span class='success'>Image deleted successfully</span>";
        }
        else {
          echo "<span class='error'>Image not deleted</span>";
        }
      }
      ?>

      <!-- showing all the image -->
      <?php
      $query = "SELECT * FROM tbl_image ORDER BY id DESC";
      $select=$db->select($query);
      if($select){
        $i = 0;
        while($image = $select->fetch_assoc()){
          $i++;
          ?>
          <tr>
            <td style="text-align:center;"><?php echo $i; ?></td>
            <td style="text-align:center;"><img src="<?php echo $image['image']; ?>" height="75px" width="100px"alt=""></td>
            <td style="text-align:center;"> <a href="?delete=<?php echo $image['id']; ?>">Delete</a> </td>
          </tr>
          <?php
        }
      }
      ?>
    </table>
  </div>
</section>

<?php include 'inc/footer.php'; ?>
