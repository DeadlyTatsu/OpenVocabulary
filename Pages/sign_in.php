<?php
session_start();
?>

<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>OpenVocab - Sign In</title>
        <link rel="stylesheet" type="text/css" href="courses-style.css">
        <link rel="icon" href="../../OpenVocab-master/Icons/book-icon-green.png" />
        <link href="https://fonts.googleapis.com/css?family=Oleo+Script+Swash+Caps|Raleway" rel="stylesheet">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <![endif]-->
    </head>
    
    <body>
       <?php
			$name = $pass = "";
			$nameErr = $passErr = $loginErr = "";
		
			if (isset($_COOKIE['username'])) {
				$name = $_COOKIE['username'];
			}
		
			if (isset($_COOKIE['pass'])) {
				$pass = $_COOKIE['pass'];
			}

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				
				if (empty($_POST["name"])) {
					$nameErr = "Please write a username";
				} else {
					$name = test_input($_POST["name"]);
					if (!preg_match("/^[a-zA-Z0-9 ]*$/",$name)) {
					  $nameErr = "Only letters, numbers and white space allowed"; 
					}		
				}

				if (empty($_POST["pass"])) {
					$passErr = "Please write a password";
				} else {
					$pass = test_input($_POST["pass"]);
					if (!preg_match("/^[a-zA-Z0-9 ]*$/",$name)) {
					  $passErr = "Only letters, numbers and white space allowed"; 
					}
				}
				
                
        		// If all fields have values and there exists no errors, run this js code
				if (empty($nameErr) & empty($passErr) & $name != "" & $pass != "") {	
					require(dirname(dirname(__FILE__)).'/Scripts/dbConnect.php'); 
					
					$sql = "SELECT userId, username, password FROM users WHERE username='$name'";
					$result = $conn->query($sql)->fetch_assoc();
										
					if (password_verify($pass, $result["password"])) 
					{
						$_SESSION["username"] = $result["username"];
						$_SESSION["userId"] = $result["userId"];
						setcookie("username", $name, time() + (86400 * 30), "/"); // 86400 = 1 day	
						
						if (isset($_POST["rememb"])) 
						{ 
							setcookie("pass", $pass, time() + (86400 * 30), "/");
						}

						header("Location:search.php");
					} 
					else 
					{
						$loginErr = "This password and user combination does not excist. Please try again.";	
					}
				}
			}
		
			function test_input($data) 
			{
			  $data = trim($data);
			  $data = stripslashes($data);
			  $data = htmlspecialchars($data);
			  return $data;
			}
		?>
       
        <header>
            <a href="../index.php">
            	<h1>OpenVocabulary</h1>
            </a>
        </header>
        
		<div class="extendedHeader" id="fullscreen">
			<div class="floatingBox">
				<h4>Login</h4>
				<span class="error"><?php echo $loginErr;?></span>
				<form  class="bxInputs" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					
					<div class="bxInputField">
						<label for="username">Username:</label>
						<span class="input"><input id="username" type="text" name="name" value="<?php echo $name;?>"></span>
						<span class="error"> <?php echo $nameErr;?></span>						
					</div>

					<div class="bxInputField">
						<label for="pass">Password:</label>
						<span class="input"><input id="pass" type="password" name="pass" value="<?php echo $pass;?>"></span>
						<span class="error"><?php echo $passErr;?></span>				
					</div>

					<div class="bxInputField">
						<label for="cbxPass">Remember?</label>
						<span class="input"><input id="cbxPass" class="left" type="checkbox" name="rememb"/></span>
					</div>

					<input class="btn" type="submit" value="Submit">
					<h5>No account? <a href="sign_up.php">Sign up</a> then!</h5>
				</form>
			</div>
		</div>
	</body>
</html>
