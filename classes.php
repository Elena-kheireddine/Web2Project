<?php

@include 'config2.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

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

<section class="classes">

   <h1 class="heading">Classes</h1>

   <div class="box-container">

      <?php
      
      $select_classes = mysqli_query($conn, "SELECT * FROM `classes`");
      if(mysqli_num_rows($select_classes) > 0){
         while($fetch_class = mysqli_fetch_assoc($select_classes)){
      ?>

      <form action="" method="post">
         <div class="box">
            <img src="uploaded_img/<?php echo $fetch_class['image'];?>" alt="">
            <h3><?php echo $fetch_class['name']; ?></h3>
            <div class="price">$<?php echo $fetch_class['price']; ?>/-</div>
            <input type="hidden" name="class_name" value="<?php echo $fetch_class['name']; ?>">
            <input type="hidden" name="class_price" value="<?php echo $fetch_class['price']; ?>">
            <input type="hidden" name="class_image" value="<?php echo $fetch_class['image']; ?>">
         </div>
      </form>

      <?php
         };
      };
      ?>

   </div>

</section>

</div>

<!-- custom js file link  -->
<script src="script.js"></script>

</body>
</html>