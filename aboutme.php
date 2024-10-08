<!-- Emperor Anuku - Worked on all the php code on this page
Boris and David - Worked on the front end, and visual aspects of page -->
<?php 
session_start(); 
if (!isset($_SESSION["userID"])) {
  header("Location: login.php");
  exit();
}
 ?>
<!DOCTYPE html>
<html>
<head lang="en">
<script>
  window.onload = function() { 
    var images = [
        'url("Picture1.jpg")',
        'url("Picture2.jpg")',
        'url("Picture3.jpg")'
        
    ];

    var currentIndex = 0;
    var header = document.getElementById('iheader');
    setInterval(function() {
        header.style.opacity = 0; // Start fading out

        // Change image after fade out completes
        setTimeout(function() {
            currentIndex = (currentIndex + 1) % images.length; // Cycle through the images
            header.style.backgroundImage = images[currentIndex];
            header.style.opacity = 1; // Fade back in
        }, 1500); // This matches the CSS transition time
    }, 10000); // Adjust overall interval as needed
};
</script>
<title>Easy money</title>
<meta name="author" content="Boris">
<meta name="index" content="index">
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>

<body onload = "startTimer()">
  <div id="iheader" >
    <div id="headerBackground"></div> <!-- Container for the background images -->
    
      <!-- <div id="stockBackground">
        <img src="Picture1.jpg" style="width:100%; " id="backgroundImage"/>
      </div> -->
      <h1 style="font-size: 250%; padding-top: 20px;"> Easy money</h1>
      
      <!--David Fallows - did the nav bar-->
      <div id="nav">
        <nav class="menu">
            <a class="menulink" href="index.php">Home</a>
            <a class="menulink" href="aboutme.php">About</a>
            <a class="menulink" href="SignUp.php">New Users</a>
            <a class="menulink" href="Login.php">Login</a>
        </nav>
      </div>
        </div>
<div id="hinfo">
<div id="aboutus">
<h2>About Us</h2>
<h3>Navigating the Pulse of the Market</h3>
At Easy Money, we're your eyes on the ever-pulsating heart of the stock market. Our mission is clear: to provide real-time insights and the flow of the market at your fingertips. We believe that timely, accurate data is the cornerstone of effective investment decisions.
</div>

<div id="story">
<h2>Our Story</h2>
Founded in 2024, With Easy Money, you're not just observing the market; you're engaging with it. We're committed to delivering a constant stream of market data, empowering you to spot opportunities as they arise and make decisions with confidence. Stay ahead of the curve with us — where the market's current is always clear and within reach. 
</div>
<div id="mission">
<h2>Our Mission</h2>
Our dedicated team of four is the driving force behind the seamless stream of market data. Together, we form a formidable team that transforms complex market data into clear, actionable information for traders and investors alike.
</div>
<div id="apart">
  <div id="apartHeading">
<h2>Meet the Guardians of the Ticker Tape</h2>
</div>
<div id="apartContent">
<div id="Raj Nasit" class="apartElements">
<h3 >Raj Nasit</h3>
<img src="RajIcon.jpg"  class="teamIcon">
Step into stoic bookstore and feel the cozy ambiance that invites you to linger. Enjoy a cup of coffee as you explore our shelves, find a quiet corner to dive into a new book, or engage in conversations with fellow book enthusiasts.
</div>
<div id="David Fallows" class="apartElements">
<h3 >David Fallows</h3>
<img src="David.jpg"  class="teamIcon">
Step into stoic bookstore and feel the cozy ambiance that invites you to linger. Enjoy a cup of coffee as you explore our shelves, find a quiet corner to dive into a new book, or engage in conversations with fellow book enthusiasts.
</div>
<div id="Emperor Anuku" class="apartElements">
<h3>Emperor Anuku</h3>
<img src="EmperorIcon.jpeg"  class="teamIcon">
Step into stoic bookstore and feel the cozy ambiance that invites you to linger. Enjoy a cup of coffee as you explore our shelves, find a quiet corner to dive into a new book, or engage in conversations with fellow book enthusiasts.
</div>
<div id="Boris Ng" class="apartElements">
<h3 >Boris Ng</h3>
<img src="BorisIcon.jpg" class="teamIcon">
My Name is Boris, I am an international student that enrolled in the BIT Net program, I have studied in Canada for 4 years, overall the program is very enagaging and the Professors are very enthusiastic. I am currently working with David, Raj and Emperor for some projects, here is one of the Website that we developed and I mostly focus on the front end design. 
</div>
</div>

</div>
</div>


<!--David Fallows - wrote the footer-->
<div id="footer">     
  <footer>
      <br><p><strong><A href="aboutme.php">Contact Us</A></strong> <br><br>
          Address: 1385 Woodroffe Ave, Ottawa, ON K2G 1V8<br>
          Phone Number: 1-(888)-888-8888<br>
          Email:<a href="mailto:EasyMoney@gmail.com?subject=From%20About%20Me%20Page"> EasyMoney@gmail.com</a><br>
      </p>
  </footer>  
  </div>
</div>
</body>
</html>
