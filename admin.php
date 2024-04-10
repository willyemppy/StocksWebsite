<?php
session_start();
//Written by Emperor Anuku

// Check if user is logged in and is admin
if (!(isset($_SESSION["username"]) && $_SESSION["username"] == "admin")) {
    header("Location: login.php");
    exit();
} else {
    // Include database connection
    include("db_connection.php");

    // Add user
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {
        $username = $_POST["username"];
        $password = $_POST["password"]; // For simplicity, you should hash the password in a real-world application
        
        // Insert user into database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if (mysqli_query($conn, $sql)) {
            echo "User added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Delete user
    if (isset($_GET["delete_user"])) {
        $id = $_GET["delete_user"];
        
        // Delete user from database
        $sql = "DELETE FROM users WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            echo "User deleted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Fetch all users
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel</h1>
    
    <h2>Add User</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <input type="submit" name="add_user" value="Add User">
    </form>
    
    <h2>Users</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["username"]; ?></td>
                <td><a href="admin.php?delete_user=<?php echo $row["id"]; ?>">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
    
    <br><br>
    <a href="logout.php">Logout</a>
</body>
</html>
