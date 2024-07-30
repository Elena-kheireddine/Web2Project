<?php
session_start(); // Starting Session
define('SALT', 'd#f453dd');
include "config.php"; // Make sure this file contains your database connection details
$_SESSION['start'] = time();
$_SESSION['expire'] = $_SESSION['start'] + (1 * 10) ; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bookstore Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 300px;
      margin: 100px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: grey;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
    }
    input[type="submit"] {
      width: 100%;
      background-color: #E6B0AA;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background-color: antiquewhite;
      color:gray;
    }
  </style>
</head>
<body> 
  <div class="container">
    <h2>Login</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <input id="email" name="email" placeholder="Email" type="text">
      <input id="password" name="password" placeholder="Password" type="password">
      <input name="submit" type="submit" value="Login">
    </form>
  </div>

<?php
if (isset($_POST['submit'])) 
{
  if (empty($_POST['email']) || empty($_POST['password']))
  {
    echo '<script type="text/javascript">alert("No email or password provided");</script>';  	
  }
  else
  {
    $email = stripslashes($_POST['email']);
    $password = stripslashes($_POST['password']);
    
    $sql = "SELECT password, role FROM user WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
      //if (md5(SALT . $password) == $row['password'])
      if ($password == $row['password'])
      { 
        $_SESSION['user'] = $email;
        $_SESSION['role'] = $row['role'];
        
        switch ($row['role']) {
          case 1: // Admin
            header("location: classes.php");
            break;
          case 2: // Instructor
            header("location: instructors.php");
            break;
          case 3: // User
            header("location: users.php");
            break;
          default:
            echo '<script type="text/javascript">alert("Invalid role");</script>';
        }
      } 
      else 
      {
        echo '<script type="text/javascript">alert("Incorrect password");</script>';			
      }
    }
    else 
    {
      echo '<script type="text/javascript">alert("Email not found");</script>';			
    }
    mysqli_stmt_close($stmt);
  }
}
mysqli_close($con); // Closing Connection
?>                 
</body>
</html>
