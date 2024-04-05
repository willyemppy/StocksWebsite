<?php 
//Emperor Anuku
session_start(); 
if (!isset($_SESSION["userID"])) {
    header("Location: login.php");
    exit();
}
$admin_usernames = array("admin"); // admin usernames is added
$is_admin = in_array($_SESSION["username"], $admin_usernames);
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>User Dashbord</title>
<meta name="author" content="Raj Nasit">
<meta name="description" content="About me page">
<link rel="stylesheet" type="text/css" href="style.css"/>
<script>
    const socket = new WebSocket('wss://ws.finnhub.io?token=co1hgb9r01qgulhr8dr0co1hgb9r01qgulhr8drg');
    // Connection opened -> Subscribe
socket.addEventListener('open', function (event) {
    // socket.send(JSON.stringify({'type':'subscribe', 'symbol': 'AAPL'}))
    // socket.send(JSON.stringify({'type':'subscribe', 'symbol': 'BINANCE:BTCUSDT'}))
    // socket.send(JSON.stringify({'type':'subscribe', 'symbol': 'IC MARKETS:1'}))
});
    var lastStock = "";
    socket.addEventListener('message', function (event) {
        console.log('Message from server ', event.data);
            var stock = document.getElementById("stockdetails");
           // stock.innerText = JSON.stringify(JSON.parse(event.data)["data"]);
           console.log(event.data);
           var list = (JSON.parse(event.data)["data"]);
           console.log(list);
           list.forEach(element=>{
            console.log(element);
            let stockid = element["s"];
            let stockprice = element["p"];
            stock.innerHTML = "";
            stock.innerHTML +=  stockid + ": "+ stockprice 
           
           });
           
            // div.innerHTML += "<h2  style=\"color: green;\">" + element["change_percentage"] +"</h2>"
            // document.getElementById("topstockcotainers").appendChild(div);
            // console.log(element);
        });
    function getCompanyDetails(){
        console.log("in getcompanydetails function");
       console.log("LastStock:", lastStock)
        if(lastStock != ""){
            socket.send(JSON.stringify({'type':'unsubscribe','symbol': lastStock}))
        }

        var company = document.getElementById("company").value;
        
        if(company == ""){
            return;
        }
        console.log(company);
        lastStock = company;
        var stock = document.getElementById("stockdetails");
        stock.innerHTML = "";
        socket.send(JSON.stringify({'type':'subscribe', 'symbol': company}));


        // Listen for messages
        // socket.addEventListener('message', function (event) {
        //     console.log('Message from server ', event.data);
        //     // var stock = document.getElementById("stockdetails");
        //     // let div = document.getElementById()
        //     // let div = document.createElement("div");
        //     // div.className = "stockblocks"
        //     // div.innerHTML += "<h2>" + element["ticker"] +"</h2>"
        //     // div.innerHTML += "<h2>$" + element["price"] +"(+<span style=\"color: green;\">" +element["change_amount"]+ "</span>)</h2>"
        //     // div.innerHTML += "<h2  style=\"color: green;\">" + element["change_percentage"] +"</h2>"
        //     // document.getElementById("topstockcotainers").appendChild(div);
        //     // console.log(element);
        // });

        
        
        fetch("https://finnhub.io/api/v1/stock/profile2?symbol=" + company + "&token=cnkd071r01qiclq83k4gcnkd071r01qiclq83k50")
            .then(response => {
                if (!response.ok) {
                throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                var imageDiv = document.getElementById('companyPhoto');
                var profileDiv = document.getElementById('companiesprofile');
                var otherStockDetails = document.getElementById('companyStockdetails');
                var stock = document.getElementById("stockdetails");
                imageDiv.innerHTML = "";
                otherStockDetails.innerHTML = "";
                profileDiv.innerHTML = "";
                imageDiv.innerHTML += "<img src=\"" + data["logo"]+"\" width=\"400\" height=\"500\"><br>";
                
                var span = document.createElement("div");
                span.innerHTML = data["name"]+ "<br>";
                profileDiv.appendChild(span);
                span = document.createElement("span");
                span.innerHTML += "Contry: "  +data["country"]+ "(" + data["currency"] +")<br>";
                profileDiv.appendChild(span);
                span = document.createElement("span");
                span.innerHTML += "Field: "  +data["finnhubIndustry"] +" <br>";
                profileDiv.appendChild(span);
                span = document.createElement("span");
                span.innerHTML += " IPO: " + data["ipo"] +" <br>";
                profileDiv.appendChild(span);
                span = document.createElement("span");
                span.innerHTML += " URL: <a href=\"" + data["weburl"] +"\">Company's Website</a>  <br>";
                profileDiv.appendChild(span);

                profileDiv.appendChild(stock)
                span = document.createElement("span");
                span.innerHTML += "Market Capitalization: "  +data["marketCapitalization"] + "<br>";
                profileDiv.appendChild(span);
                span = document.createElement("span");
                span.innerHTML += "Share Outstanding: "  +data["shareOutstanding"] + "<br>";
                profileDiv.appendChild(span);

                otherStockDetails.innerHTML = '<iframe width="100%" frameborder="0" height="400" src="https://widget.finnhub.io/widgets/recommendation?symbol=' + company + '"></iframe>'
                

            })
            .catch(error => { console.error('Error:', error);
            });


             
       

            fetch("https://finnhub.io/api/v1/company-news?symbol=" + company + "&from=2023-07-03&to=2024-04-03&token=cnkd071r01qiclq83k4gcnkd071r01qiclq83k50")
            .then(response => {
                if (!response.ok) {
                throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById("companyNews").innerHTML = "";
                data.forEach(element => {
                let div = document.createElement("div");
                    div.className = "newsblocks"
                    div.innerHTML += "<h2>" + element["headline"] +"</h2>"
                    if( element["image"] != ""){
                    div.innerHTML += "<img src='" + element["image"] + "' width=\"200\" height=\"200\">";
                    }
                    div.innerHTML += "<br>" + element["summary"] +"<br>"
                    document.getElementById("companyNews").appendChild(div);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>
</head>
<body>
<div>
    <div id="iheader" >
        <div id="headerBackground"></div> <!-- Container for the background images -->
        
          <!-- <div id="stockBackground">
            <img src="Picture1.jpg" style="width:100%; " id="backgroundImage"/>
          </div> -->
          <h1 style="font-size: 250%; padding-top: 20px;"> Easy money</h1>
          <h1>Welcome to Your Dashboard, <?php echo $_SESSION["username"]; //Emperor Anuku?>!</h1>
          <div id="nav">
            <nav class="menu">
                <a class="menulink" href="index.php">Home</a>
                <a class="menulink" href="aboutme.php">About</a>
                <a class="menulink" href="registrationForm.php">New Users</a>
                <a class="menulink" href="login.php">Login</a>
                <!-- Link to admin panel -->
                <?php if ($is_admin) { ?>
                        <a class="menulink" href="admin.php">Admin Panel</a>
                    <?php } ?>
            </nav>
            <div>
                <form action="logout.php" method="post">
                    <button type="submit" name="logout" class="loginsignup-button">Logout</button>
                </form>
            </div>
          
          </div>
            </div>
    <div  class="search-container">
    <form onsubmit="event.preventDefault(); getCompanyDetails();">
        <input placeholder="Search.." list="companies" id="company" class="search-input" placeholder="Search...">
        <datalist id="companies"></datalist>

        <script>
            fetch("https://finnhub.io/api/v1/stock/symbol?exchange=US&token=cnkd071r01qiclq83k4gcnkd071r01qiclq83k50")
            .then(response => {
                if (!response.ok) {
                throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                var list = document.getElementById('companies');
                data.forEach(element => {
                    //console.log(element);
                    var option = document.createElement('option');
                    option.text = element["description"];
                    option.value = element["symbol"];
                    list.appendChild(option);
                });
            })
            .catch(error => { console.error('Error:', error);
            });
            

        </script>
        <input type="submit" class="search-button">
    </form>
</div>
    
</div>
<div id="companieInfo">
    <div id="companyPhoto"></div>
<div >
   
</div>

<div id="companiesprofile">
<div id="stockdetails"></div>
</div>
<div id="companyStockdetails">
    
</div>
</div>

<div id="companyNews"></div>
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
