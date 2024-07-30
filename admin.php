<?php

@include 'config2.php';

if(isset($_POST['add_class'])){
   $class_name = $_POST['class_name'];
   $class_price = $_POST['class_price'];
   $class_image = $_FILES['class_image']['name'];
   $class_image_tmp_name = $_FILES['class_image']['tmp_name'];
   $class_image_folder = 'uploaded_img/'.$class_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `classes`(name, price, image) VALUES('$class_name', '$class_price', '$class_image')") or die('query failed');

   if($insert_query){
      move_uploaded_file($class_image_tmp_name, $class_image_folder);
      $message[] = 'class added succesfully';
   }else{
      $message[] = 'could not add the class';
   }
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `classes` WHERE id = $delete_id ") or die('query failed');
   if($delete_query){
      header('location:admin.php');
      $message[] = 'class has been deleted';
   }else{
      header('location:admin.php');
      $message[] = 'class could not be deleted';
   };
};

if(isset($_POST['update_class'])){
   $update_class_id = $_POST['update_class_id'];
   $update_class_name = $_POST['update_class_name'];
   $update_class_price = $_POST['update_class_price'];
   $update_class_image = $_FILES['update_class_image']['name'];
   $update_class_image_tmp_name = $_FILES['update_class_image']['tmp_name'];
   $update_class_image_folder = 'uploaded_img/'.$update_class_image;

   $update_query = mysqli_query($conn, "UPDATE `classes` SET name = '$update_class_name', price = '$update_class_price', image = '$update_class_image' WHERE id = '$update_class_id'");

   if($update_query){
      move_uploaded_file($update_class_image_tmp_name, $update_class_image_folder);
      $message[] = 'class updated succesfully';
      header('location:admin.php');
   }else{
      $message[] = 'class could not be updated';
      header('location:admin.php');
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style4.css">

</head>
<body>
   
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>

<?php include 'header.php'; ?>

<div class="container">

<section>

<form action="" method="post" class="add-class-form" enctype="multipart/form-data">
   <h3>add a new class</h3>
   <input type="text" name="class_name" placeholder="enter the class name" class="box" required>
   <input type="number" name="class_price" min="0" placeholder="enter the class price" class="box" required>
   <input type="file" name="class_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
   <input type="submit" value="add the class" name="add_class" class="btn">
</form>

</section>

<section class="display-class-table">

   <table>

      <thead>
         <th>Class image</th>
         <th>Class name</th>
         <th>Class price</th>
         <th>action</th>
      </thead>

      <tbody>
         <?php
         
            $select_classes = mysqli_query($conn, "SELECT * FROM `classes`");
            if(mysqli_num_rows($select_classes) > 0){
               while($row = mysqli_fetch_assoc($select_classes)){
         ?>

         <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td>$<?php echo $row['price']; ?>/-</td>
            <td>
               <a href="admin.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('are your sure you want to delete this?');"> <i class="fas fa-trash"></i> delete </a>
               <a href="admin.php?edit=<?php echo $row['id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> update </a>
            </td>
         </tr>

         <?php
            };    
            }else{
               echo "<div class='empty'>no class added</div>";
            };
         ?>
      </tbody>
   </table>

</section>

<section class="edit-form-container">

   <?php
   
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM `classes` WHERE id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
      <input type="hidden" name="update_class_id" value="<?php echo $fetch_edit['id']; ?>">
      <input type="text" class="box" required name="update_class_name" value="<?php echo $fetch_edit['name']; ?>">
      <input type="number" min="0" class="box" required name="update_class_price" value="<?php echo $fetch_edit['price']; ?>">
      <input type="file" class="box" required name="update_class_image" accept="image/png, image/jpg, image/jpeg">
      <input type="submit" value="update the class" name="update_class" class="btn">
      <input type="reset" value="cancel" id="close-edit" class="option-btn">
   </form>

   <?php
            };
         };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

</section>

</div>




<!-- custom js file link  -->
<script src="script.js"></script>

</body>
</html>