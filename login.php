
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
            header("Location: userdashboard.php");
            exit();
            if ($username == "admin") {
                $_SESSION["admin"] = true;
            }
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
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body>
<div id="iheader">
    <div id="headerBackground"></div> <!-- Container for the background images -->

    <div id="stockBackground">
        <img src="Picture1.jpg" style="width:100%; " id="backgroundImage"/>
    </div>
    <h1 style="font-size: 250%; padding-top: 20px;"> Easy money</h1>

    <div id="nav">
        <nav class="menu">
            <a class="menulink" href="index.php">Home</a>
            <a class="menulink" href="aboutme.php">About</a>
            <a class="menulink" href="SignUp.php">New Users</a>
            <a class="menulink" href="login.php">Login</a>
        </nav>
    </div>
</div>

<div class="login-container">
    <h2>Login</h2>
    
    
    <?php if (isset($error_message)) echo "<p>$error_message</p>"; ?> <!-- Echo Invalid username or password. or "Username and password are required."  -->

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="loginform">
        <div class="loginform-group">
            <label for="username" class="loginlabel">Username:</label>
            <input type="text" id="username" name="username" required class="logintext-input">
        </div>
        <div class="loginform-group">
            <label for="password" class="loginlabel">Password:</label>
            <input type="password" id="password" name="password" required class="loginpassword-input">
        </div>
        <input type="submit" value="Login" class="loginsubmit-button">
        <a href="SignUp.php" target="_blank" class="loginsignup-button">Dont have an account? Register here</a> <!--Open SignUp page on a new tab -->
    </form>
</div>

<div id="footer">     
  <footer>
      <br><p><strong><A href="aboutme.php">Contact Us</A></strong> <br><br>
          Address: 1385 Woodroffe Ave, Ottawa, ON K2G 1V8<br>
          Phone Number: 1-(888)-888-8888<br>
          Email:<a href="mailto:EasyMoney@gmail.com?subject=From%20About%20Me%20Page"> EasyMoney@gmail.com</a><br>
      </p>
  </footer>  
  </div>
</body>
</html>
