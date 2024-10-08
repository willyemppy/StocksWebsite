<?php
session_start();
//Emperor Anuku - Wrote PHP code to get input from HTML forms, validate input, and send to with database 
//Emperor Anuku - Wrote the Javascript code to perform input validation on the form entries, using functions and regex

/*David Fallows - Worked on the HTML part/front end, created the UI, nav, footer, and header  and CSS for all those. Used Emperor's php and 
validation (for password, email, username verification).*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form is submitted, process the data
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);
    
    // Basic form validation
    if (empty($username) || empty($password)) {
        echo "Username and password are required.";
        exit;
    }
    
    // Include database connection file
    include("db_connection.php");

    // Assign permission level
    $permission = 2;

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind parameters to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO Users (username, Securepassword, permissions) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $hashedpassword, $permission);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Data inserted successfully
        echo "Registration successful!";
        
    } else {
        // Error occurred
        echo "Error: " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
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
            <a class="menulink" href="Login.php">Login</a>
        </nav>
    </div>
</div>
    
<div class="login-container">
        <h2>Sign Up</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"> <!-- PHP written by Emperor Anuku -->
            <div class="loginform-group">
                <label for="username" class="loginlabel">Username:</label>
                <input type="text" id="username" name="username" class="logintext-input" required>
                <span class="error" id="userNameError"></span>
            </div>
            <div class="loginform-group">
                <label for="email" class="loginlabel">Email:</label>
                <input type="email" id="email" name="email" class="logintext-input loginemail-input" required>
                <span class="error" id="emailError"></span>
            </div>
            <div class="loginform-group">
                <label for="password" class="loginlabel">Password (8-10 characters):</label>
                <input type="password" id="password" name="password" class="loginpassword-input" minlength="8" maxlength="10" required>
                <span class="error" id="passwordError"></span>
            </div>
            <button type="submit" onclick="validateForm()" class="loginsubmit-button">Sign Up</button>
        
        <a href="login.php" class="loginsignup-button">Already have an account? Log in</a>
    </form>
</div>


<h2 class="registration-form">Registration Form</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"> <!-- PHP Written by Emperor Anuku -->
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <span class="error" id="userNameError"></span>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <span class="error" id="emailError"></span>
        <br>

        <label for="password">Password (8-10 characters):</label>
        <input type="password" id="password" name="password" minlength="8" maxlength="10">
        <span class="error" id="passwordError"></span>
        <br>

        <button type="submit" onclick="validateForm()">Submit</button>
    </form>

    <script>
        //Javascript written by Emperor Anuku
        function validateForm() {
            //const realName = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (username.trim() === '') {
                document.getElementById('userNameError').innerText = 'Please enter your username';
            } else {
                document.getElementById('userNameError').innerText = '';
            }

            if (email.trim() === '') {
                document.getElementById('emailError').innerText = 'Please enter your email';
            } else if (!isValidEmail(email)) {
                document.getElementById('emailError').innerText = 'Please enter a valid email address';
            } else {
                document.getElementById('emailError').innerText = '';
            }

            if (password.trim() === '') {
                document.getElementById('passwordError').innerText = 'Please enter a password';
            } else if (password.length < 8 || password.length > 10) {
                document.getElementById('passwordError').innerText = 'Password must be between 8 and 10 characters';
            } else {
                document.getElementById('passwordError').innerText = '';
            }
        }

        function isValidEmail(email) {
            // Regular expression for basic email validation
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return emailRegex.test(email);
        }
    </script>
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
