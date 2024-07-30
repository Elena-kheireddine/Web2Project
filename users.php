<?php
session_start();
include "config.php"; // Make sure this file contains your database connection details

function safeEcho($message, $type) {
    echo "<div class='{$type}'>" . htmlspecialchars($message) . "</div>";
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $role = mysqli_real_escape_string($con, $_POST['role']);

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (email, password, role) VALUES ('$email', '$hashed_password', '$role')";
        if (mysqli_query($con, $sql)) {
            safeEcho("New user added successfully", "success");
        } else {
            safeEcho("Error: " . $sql . "<br>" . mysqli_error($con), "error");
        }
    } elseif (isset($_POST['delete'])) {
        $email = mysqli_real_escape_string($con, $_POST['delete']);
        $sql = "DELETE FROM user WHERE email = '$email'";
        mysqli_query($con, $sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Manager</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        h1, h2 { color: gray; }
        form { margin-bottom: 20px; }
        label { display: block; margin-top: 10px; }
        input[type="text"], input[type="email"], input[type="password"], select { width: 100%; padding: 5px; }
        input[type="submit"] { margin-top: 10px; padding: 5px 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #E6B0AA; color:white;}
        .action-column { width: 100px; }
        .action-btn { padding: 5px 10px; }
        .success { color: green; }
        .error { color: red; }
        .navbar {
            background-color: #E6B0AA;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: antiquewhite;
            color: grey;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="instructors.php">Instructors</a>
        <a href="classes.php">Classes</a>
        <a href="users.php">Users</a>
    </div>
    
    <div class="content">
        <h1>User Manager</h1>
        
        <h2>Add New User</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="1">Admin</option>
                <option value="2">Instructor</option>
                <option value="3">User</option>
            </select>
            
            <input type="submit" name="add" value="Add User">
        </form>

        <h2>User List</h2>
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="action-column">Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT u.email, r.description AS role_description FROM user u JOIN role r ON u.role = r.roleId";
            $result = mysqli_query($con, $sql);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['role_description']) . "</td>";
                    echo "<td class='action-column'>
                            <form method='post' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' onsubmit='return confirm(\"Are you sure you want to delete this user?\");'>
                                <input type='hidden' name='delete' value='" . htmlspecialchars($row['email']) . "'>
                                <input type='submit' value='Delete' class='action-btn'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Error fetching users: " . mysqli_error($con) . "</td></tr>";
            }
            ?>
            </tbody>
        </table>
        <?php
        // Close the database connection
        mysqli_close($con);
        safeEcho("Database connection closed.", "info");
        ?>
    </div>
</body>
</html>
