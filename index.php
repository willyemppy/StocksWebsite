<?php 
session_start(); 
 ?>
<!doctype html>

<html>

<head>

<script>
// const sqlite3 = require('sqlite3').verbose();
// const db = new sqlite3.Database('./db.sqlite');

// db.serialize(() => {           
//   db.run("DROP TABLE Stocks");
//   db.run("CREATE TABLE Stocks");
//   db.run("INSERT INTO Stocks (AMD, MSFT, TSLA)");
// });
const alphaKey = "OWC8EWIQ70MN3O8O"

const socket = new WebSocket('wss://ws.finnhub.io?token=cnkd071r01qiclq83k4gcnkd071r01qiclq83k50');
const socket1 = new WebSocket('wss://ws.finnhub.io?token=co1hgb9r01qgulhr8dr0co1hgb9r01qgulhr8drg');
 
/// Connection opened -> Subscribe
socket.addEventListener('open', function (event) {
    socket.send(JSON.stringify({'type':'trade', 'symbol': 'AAPL'}))
});

// Listen for messages
socket.addEventListener('message', function (event) {
    document.getElementById("test").innerHTML = "Messages: <br>" +  event.data;
    console.log('Message from server ', event.data);
});

// Unsubscribe
 var unsubscribe = function(symbol) {
    socket.send(JSON.stringify({'type':'unsubscribe','symbol': symbol}))
}

fetch("https://finnhub.io/api/v1/news?category=general&token=cnkd071r01qiclq83k4gcnkd071r01qiclq83k50")
.then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    data.forEach(element => {
      let div = document.createElement("div");
        div.className = "newsblocks"
        div.innerHTML += "<h2>" + element["headline"] +"</h2>"
        if( element["image"] != ""){
          div.innerHTML += "<img src='" + element["image"] + "' style=\"max-width: 400px;\">";
        }
        div.innerHTML += "<br>" + element["summary"] +"<br>"
        document.getElementById("news").appendChild(div);
    });
  })
  .catch(error => {
    console.error('Error:', error);
  });


  fetch("https://www.alphavantage.co/query?function=TOP_GAINERS_LOSERS&apikey=demo")
.then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    // for(let i = 0; i<30;i++){
    //   let div = document.createElement("div");
    //     div.className = "stockblocks"
    //     div.innerHTML += "<h2>" + i +"</h2>"
    //     div.innerHTML += "<h2>$" + i +"(+" +i+ ")</h2>"
    //     div.innerHTML += "<h2  style=\"color: green;\">" + i +"</h2>"
    //     document.getElementById("stocks").appendChild(div);
    // }
    console.log("Stock data: ")
    console.log(data);
    console.log(data["most_actively_traded"]);
    data["top_gainers"].forEach(element => {
        let div = document.createElement("div");
        div.className = "stockblocks"
        div.innerHTML += "<h2>" + element["ticker"] +"</h2>"
        div.innerHTML += "<h2>$" + element["price"] +"(+<span style=\"color: green;\">" +element["change_amount"]+ "</span>)</h2>"
        div.innerHTML += "<h2  style=\"color: green;\">" + element["change_percentage"] +"</h2>"
        document.getElementById("topstockcotainers").appendChild(div);
        console.log(element);
    });
    
    data["top_losers"].forEach(element => {
      let div = document.createElement("div");
        div.className = "stockblocks"
        div.innerHTML += "<h2>" + element["ticker"] +"</h2>"
        div.innerHTML += "<h2>$" + element["price"]+"(<span style=\"color: red;\">" +element["change_amount"]+ "</span>)</h2>"
       div.innerHTML += "<h2  style=\"color: red;\">" + element["change_percentage"] +"</h2>"
       document.getElementById("worststockscotainers").appendChild(div);
        
        console.log(element);
    });

    data["most_actively_traded"].forEach(element => {
      let div = document.createElement("div");
        div.className = "stockblocks"
        div.innerHTML += "<h2>" + element["ticker"] +"</h2>"
        if(element["change_amount"].includes("-")){
          div.innerHTML += "<h2>$" + element["price"]+"(<span style=\"color: red;\">" +element["change_amount"]+ "</span>)</h2>"
       div.innerHTML += "<h2  style=\"color: red;\">" + element["change_percentage"] +"</h2>"
        }else{
          div.innerHTML += "<h2>$" + element["price"] +"(+<span style=\"color: green;\">" +element["change_amount"]+ "</span>)</h2>"
        div.innerHTML += "<h2  style=\"color: green;\">" + element["change_percentage"] +"</h2>"
        }
       document.getElementById("activestockscotainers").appendChild(div);
        
        console.log(element);
    });

  })
  .catch(error => {
    console.error('Error:', error);
  });
window.setInterval(()=>{

}, 5000);

window.onload = function() { //Boris
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

document.addEventListener('DOMContentLoaded', function() {
  const container = document.getElementById('topstockcotainers');
  const nextBtn = document.querySelector('#topstocks .next');
  const prevBtn = document.querySelector('#topstocks .prev');

  function smoothScrollBy(distance, duration) { //distance is the num of pixels to scroll 
    let initialPosition = container.scrollLeft; //and duration is the time in ms over which the scroll should occur
    let startTime = null;

    function animation(currentTime) {
      if (startTime === null) startTime = currentTime;
      let timeElapsed = currentTime - startTime;
      let progress = Math.min(timeElapsed / duration, 1); //it will calculate the current scroll position

      container.scrollLeft = initialPosition + (distance * progress);

      if (timeElapsed < duration) window.requestAnimationFrame(animation);
    }

    window.requestAnimationFrame(animation); //for smooth animations
  }

  nextBtn.addEventListener('click', () => {
    smoothScrollBy(container.clientWidth, 700); // Scroll right smoothly over 700ms
  });

  prevBtn.addEventListener('click', () => {
    smoothScrollBy(-container.clientWidth, 700); // Scroll left smoothly over 700ms
  });
});



</script>

<title>Example</title>
<link rel="stylesheet" type="text/css" href="style.css"/>
</head>

<body>
  <div id="iheader" >
  <div id="headerBackground"></div> <!-- Container for the background images -->
  
    <!-- <div id="stockBackground">
      <img src="Picture1.jpg" style="width:100%; " id="backgroundImage"/>
    </div> -->
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

<div id="stoks"> <!-- Boris -->
  
  
    <div class="stock-section" id="topstocks">
    <h1>Top preformas</h1>
    <div class="stock-container" id="topstockcotainers"></div>
    <button class="prev" aria-label="Scroll to previous stocks">&#10094;
    </button> <!-- Left arrow for previous 6 stocks -->
    <button class="next" aria-label="Scroll to next stocks">&#10095;
    </button> <!-- Right arrow for next 6 stocks -->
    </div>

    <div class="stock-section" id="worststocks">
      <h1>Worst preformas</h1>
      <div class="stock-container" id="worststockscotainers"></div>
    </div>
    <div class="stock-section" id="activestocks">
      <h1>Most active</h1>
      <div class="stock-container" id="activestockscotainers"></div>
    </div>
</div>

<div id="news" >
 
</div>

<div id="footer">     
  <footer>
      <br><p><strong><A href="aboutme.html">Contact Us</A></strong> <br><br>
          Address: 1385 Woodroffe Ave, Ottawa, ON K2G 1V8<br>
          Phone Number: 1-(888)-888-8888<br>
          Email:<a href="mailto:EasyMoney@gmail.com?subject=From%20About%20Me%20Page"> EasyMoney@gmail.com</a><br>
      </p>
  </footer>  
  </div>

</body>

</html>