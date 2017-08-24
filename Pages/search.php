<?php
session_start();
?>

<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>OpenVocab - Home</title>
        <link rel="stylesheet" type="text/css" href="courses-style.css">
        <link rel="icon" href="../Icons/book-icon-green.png" />
        <link href="https://fonts.googleapis.com/css?family=Oleo+Script+Swash+Caps|Raleway" rel="stylesheet">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <![endif]-->
    </head>
    
    <body>
       	<?php
			$error = "";
						
			// Check if user is logged in before allowing to create a new list.
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				 if (isset($_POST['edit'])) {
					$_SESSION['listId'] = $_POST["listId"];
					header("Location:list.php");
				} else if (isset($_POST['train'])) {
					$_SESSION['listId'] = $_POST['listId'];
					header("Location:glossary.php");
				} else if (isset($_POST['list'])) {
					if (!empty($_SESSION["username"])) {
						$_SESSION["listId"] = "";
						header("Location:list.php");
					} else {
						$error = "You must be logged in to do that. Please <a href=\"sign_in.php\">Login</a> or <a href=\"sign_up.php\">Sign up</a>!";
					}
				} else if (isset($_POST['logOut'])) {
					header("Location:/public_html/Scripts/sign_out.php");
				}
			}
			include('../Pages/header.php');
		?>
               
        <div id="searchHeader" class="extendedHeader">
            <div class="floatingBox">
                <form id="frmSearch" method="post">
                    <h4 id="lblSearch" class="left">Search lists:</h4>
                    <input id="searchMobile" class="search" name="search" type="search" onKeyUp="getLists()" placeholder="Search List..."/>
                    <input type="submit" id="btnNewList" name="list" class="btn right yellow" value="New List">  
					<span class="input"><input id="search" class="search" name="search" type="search" onKeyUp="getLists()" placeholder="Search List Name Here..." autofocus /></span>
					<?php
						if(!empty($_SESSION["username"])) {
							echo '<input id="btnLogOut2" name="logOut" class="btn pink" type="submit" value="Log Out"/>';
						}
					?>
                	<span class="error"><?php echo($error);?></span>
                </form>
            </div>
        </div>
        
        <div id="listBox" class="bxContent">
            <div id="userLists"></div>
			<div id="publicLists">Lists are loading... Please wait a bit.</div>
        </div>
        
        <script>
			function getLists() {
				if(screen.width > 980) {
					var searchInput = document.getElementById("search").value;
					//alert ("normal");
				} else {
					var searchInput = document.getElementById("searchMobile").value;
					//alert ("mobile");
				}
				
				if (window.XMLHttpRequest) {
					xmlhttp = new XMLHttpRequest(); // code for IE7+, Firefox, Chrome, Opera, Safari
				} else {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); // code for IE6, IE5
				}

				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("userLists").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("GET","load_Lists.php?q="+searchInput+"&x=true",true);
				xmlhttp.send();
				
				if (window.XMLHttpRequest) {
					xmlhttp2 = new XMLHttpRequest(); // code for IE7+, Firefox, Chrome, Opera, Safari
				} else {
					xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP"); // code for IE6, IE5
				}
				
				xmlhttp2.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("publicLists").innerHTML = this.responseText;
					}
				};
				xmlhttp2.open("GET","load_Lists.php?q="+searchInput+"&x=false",true);
				xmlhttp2.send();
			}
			
			// Load list's when homepage is fist loaded
			getLists();
		
        </script>
    </body>
</html>