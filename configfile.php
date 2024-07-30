<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'yoga');

function safeEcho($message, $type) {
    echo "<div class='{$type}'>" . htmlspecialchars($message) . "</div>\n";
}

// Attempt to establish a connection to the MySQL server
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
if (!$con) {
    die("Failed to connect to the server: " . mysqli_connect_error());
}
safeEcho("Successfully connected to the MySQL server.", "success");

// Check if the database exists
$db_selected = mysqli_select_db($con, DB_NAME);
if (!$db_selected) {
    // Database doesn't exist, so create it
    $sql = "CREATE DATABASE " . DB_NAME;
    if (mysqli_query($con, $sql)) {
        safeEcho("Database " . DB_NAME . " created successfully.", "success");
    } else {
        safeEcho("Error creating database: " . mysqli_error($con), "error");
        mysqli_close($con);
        die();
    }
}

// Select the database
mysqli_select_db($con, DB_NAME);
safeEcho("Connected to database: " . DB_NAME, "success");

// Drop existing tables if they exist
$drop_tables = array('instructors', 'user', 'role');
foreach ($drop_tables as $table) {
    $sql = "DROP TABLE IF EXISTS $table";
    if (mysqli_query($con, $sql)) {
        safeEcho("Table '$table' dropped successfully.", "success");
    } else {
        safeEcho("Error dropping table '$table': " . mysqli_error($con), "error");
    }
}

// Create table for instructors
$sql = "CREATE TABLE instructors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    bio TEXT
)";
if (mysqli_query($con, $sql)) {
    safeEcho("Table 'instructors' created successfully.", "success");
} else {
    safeEcho("Error creating table: " . mysqli_error($con), "error");
}

// Create table for classes
//$sql = "CREATE TABLE classes (
  //  id INT AUTO_INCREMENT PRIMARY KEY,
    //title VARCHAR(255) NOT NULL,
    //instructor_id INT NOT NULL,
    //price INT,
    //class_date DATE,
    //is_full BOOLEAN NOT NULL DEFAULT 1,
    //FOREIGN KEY (instructor_id) REFERENCES instructors(id) ON DELETE CASCADE ON UPDATE CASCADE
//)";
//if (mysqli_query($con, $sql)) {
  //  safeEcho("Table 'classes' created successfully.", "success");
//} else {
  //  safeEcho("Error creating table: " . mysqli_error($con), "error");
//}

// Create role table
$sql = "CREATE TABLE role (
    roleId INT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(50)
)";
if (mysqli_query($con, $sql)) {
    safeEcho("Table 'role' created successfully.", "success");
} else {
    safeEcho("Error creating table 'role': " . mysqli_error($con), "error");
}

// Create user table
$sql = "CREATE TABLE user (
    email VARCHAR(50) PRIMARY KEY,
    password VARCHAR(50),
    role INT,
    FOREIGN KEY (role) REFERENCES role (roleId)
)";
if (mysqli_query($con, $sql)) {
    safeEcho("Table 'user' created successfully.", "success");
} else {
    safeEcho("Error creating table 'user': " . mysqli_error($con), "error");
}

// Insert mock data into instructors table
$sql = "INSERT INTO instructors (name, bio) VALUES
    ('Helana Hazimi', 'Certified Yoga and aerial instructor.'),
    ('Sarah Shaib', 'Certified dance instructor.'),
    ('Noura Mossleh', 'Certified bunjee jump intructor and fitness.'),
    ('Elyana Mili', 'Certified aerial instructor.')";
if (mysqli_query($con, $sql)) {
    safeEcho("Mock data inserted into 'instructors' table successfully.", "success");
} else {
    safeEcho("Error inserting data into 'instructors' table: " . mysqli_error($con), "error");
}

// Insert mock data into classes table
//$sql = "INSERT INTO classes (title, instructor_id, price, class_date, is_full) VALUES
  //  ('Aerial adults', 1, 10, '1997-06-26', 1),
    //('Aerial kids', 4, 5, '1997-06-26', 1),
    //('Bunjee jump', 3, 7, '1997-06-26', 1),
    //('kids yoga', 1, 5, '1997-06-26', 1),
    //('Dance', 2, 7, '1986-09-15', 1)";
//if (mysqli_query($con, $sql)) {
  //  safeEcho("Mock data inserted into 'classes' table successfully.", "success");
//} else {
  //  safeEcho("Error inserting data into 'classes' table: " . mysqli_error($con), "error");
//s}

// Insert mock data into role table
$sql = "INSERT INTO role (roleId, description) VALUES
    (1, 'admin'),
    (2, 'instructor'),
    (3, 'user')";
if (mysqli_query($con, $sql)) {
    safeEcho("Mock data inserted into 'role' table successfully.", "success");
} else {
    safeEcho("Error inserting data into 'role' table: " . mysqli_error($con), "error");
}

// Insert mock data into user table
$sql = "INSERT INTO user (email, password, role) VALUES
    ('admin@yoga.com', 'adminpass', 1),
    ('helana@yoga.com', 'instructorpass', 2),
    ('sarah@yoga.com', 'instructorpass', 2),
    ('noura@yoga.com', 'instructorpass', 2),
    ('elyana@yoga.com', 'instructorpass', 2),
    ('rima@yoga.com', 'userpass', 3),
    ('rania@yoga.com', 'userpass', 3),
    ('wafaa@yoga.com', 'userpass', 3)";
if (mysqli_query($con, $sql)) {
    safeEcho("Mock data inserted into 'user' table successfully.", "success");
} else {
    safeEcho("Error inserting data into 'user' table: " . mysqli_error($con), "error");
}

// Close the connection
mysqli_close($con);
?>
