
<?php

//Written by Emperor Anuku

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $username1 = trim($_POST["username"]); //trim to eliminate whitespace
    $password1 = trim($_POST["password"]);

    // Uncomment For debugging
        //echo "Username: $username1<br>";
        //echo "Password: $password1<br>";

    // Check if username and password are not empty
    if (!empty($username1) && !empty($password1)) {
        // Include the PHP script that connects to the backend
        include("db_connection.php");

        // Prepare SQL statement to fetch user with provided credentials
        $stmt = $conn->prepare("SELECT * FROM Users WHERE username=? AND Securepassword=?");
        $stmt->bind_param("ss", $username1, $password1);
        $stmt->execute();
        $result = $stmt->get_result();

    // Uncomment For debugging
        //echo "Username: $username1<br>";
        //echo "Password: $password1<br>";

        // Check if a user with provided credentials exists
        if ($result->num_rows > 0) {
            // User exists, store user information in session variables
            $row = $result->fetch_row();
            $_SESSION["userID"] = $row[0]; // userID is the first column in the query result
            $_SESSION["username"] = $row[1]; //username is the second column in the query result

            var_dump($row);

            // Redirect the user to the dashboard or home page
            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid credentials, display error message
            $error_message = "Invalid username or password.";
        }

        // Close database connection
        $conn->close();
    } else {
        // If username or password is empty, display an error message
        $error_message = "Username and password are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>
<div >
    <h2>Login</h2>
        <a href="SignUp.php" target="_blank" class="loginsignup-button">Sign Up</a> <!--Open SignUp page on a new tab -->
    </div>
    <?php if (isset($error_message)) echo "<p>$error_message</p>"; ?> <!-- Echo Invalid username or password. or "Username and password are required."  -->
    <div class="loginmain">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="loginform"> <!-- POST credentials to this file itself -->
            <div class="loginform-group">
                <label for="username" class="loginlabel">Username:</label>
                <input type="text" id="username" name="username" required class="logintext-input">
            </div>
            <div class="loginform-group">
                <label for="password" class="loginlabel">Password:</label>
                <input type="password" id="password" name="password" required class="loginpassword-input">
            </div>
            <input type="submit" value="Login" class="loginsubmit-button">
        </form>
    </div>
</body>
</html>
