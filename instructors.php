<?php
session_start();
include "config.php"; // Make sure this file contains your database connection details


function safeEcho($message, $type) {
    echo "<div class='{$type}'>" . htmlspecialchars($message) . "</div>";
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $bio = mysqli_real_escape_string($con, $_POST['bio']);

        $sql = "INSERT INTO instructors (name, bio) VALUES ('$name', '$bio')";
        if (mysqli_query($con, $sql)) {
            safeEcho("New instructor added successfully", "success");
        } else {
            safeEcho("Error: " . $sql . "<br>" . mysqli_error($con), "error");
        }
    } elseif (isset($_POST['delete'])) {
        $id = mysqli_real_escape_string($con, $_POST['delete']);
        $sql = "DELETE FROM instructors WHERE id = '$id'";
        mysqli_query($con, $sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author Manager</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        h1, h2 { color: grey; }
        form { margin-bottom: 20px; }
        label { display: block; margin-top: 10px; }
        input[type="text"], textarea { width: 100%; padding: 5px; }
        input[type="submit"] { margin-top: 10px; padding: 5px 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #E6B0AA; color:white; }
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
        <h1 align="center">Our Instructors</h1>
        
        <h2>Add New Instructor</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="name">Instructor Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="bio">Biography:</label>
            <textarea id="bio" name="bio" rows="4"></textarea>
            
            <input type="submit" name="add" value="Add Instructor">
        </form>

        <h2>Instructor List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Biography</th>
                    <th class="action-column">Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM instructors";
            $result = mysqli_query($con, $sql);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars(substr($row['bio'], 0, 100)) . "...</td>";
                    echo "<td class='action-column'>
                            <form method='post' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' onsubmit='return confirm(\"Are you sure you want to delete this instructor?\");'>
                                <input type='hidden' name='delete' value='" . $row['id'] . "'>
                                <input type='submit' value='Delete' class='action-btn'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Error fetching instructors: " . mysqli_error($con) . "</td></tr>";
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
