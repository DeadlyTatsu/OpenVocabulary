<?php
	session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>OpenVocab - Sign Up</title>
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
			$name = $email = $pass = "";
			$nameErr = $emailErr = $passErr = $serverErr = "";
		
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				
				if (empty($_POST["name"])) {
					$nameErr = "Username is required";
				} else {
					$name = test_input($_POST["name"]);
					
					if (!preg_match("/^[a-zA-Z0-9 ]*$/",$name)) {
					  $nameErr = "Only letters, numbers and white space allowed"; 
					}
					
					if (empty($nameErr)) {
						require('../Scripts/dbConnect.php');
						
						$sql = "SELECT username FROM users";
						$result = $conn->query($sql);
						
						while($row = $result->fetch_assoc()) {
							if ($row["username"] == $name) {
								$nameErr = "Username is already taken by another user.";
							}
						}
					}
				}

				if (empty($_POST["email"])) {
					$emailErr = "E-mail is required";
				} else {
					$email = test_input($_POST["email"]);
					
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					  	$emailErr = "Invalid email format"; 
					}
					
					if (empty($emailErr)) {
						require('../Scripts/dbConnect.php');
						
						$sql = "SELECT email FROM users";
						$result = $conn->query($sql);
						
						while($row = $result->fetch_assoc()) {
							if ($row["email"] == $email) {
								$emailErr = "Email is already in use by another user.";
							}
						}
					}
				}

				if (empty($_POST["pass"])) {
					$passErr = "Password is required";
				} else {
					$pass = test_input($_POST["pass"]);
					
					if (!preg_match("/^[a-zA-Z0-9 ]*$/",$pass)) {
						$passErr = "Only letters, numbers and white space allowed"; 
					} else if (!preg_match("/[A-Z]/", $pass)) {
						$passErr = "Password requires at least one capital letter and one number.";
					} else if (!preg_match("/[0-9]/", $pass)) {
						$passErr = "Password requires at least one capital letter and one number.";
					} else if (strlen($pass) < 6) {
						$passErr = "The password needs to contain at least 6 characters.";
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
        <div class="extendedHeader"  id="fullscreen">
			<div class="floatingBox">
               
                <form id="signUp" class="bxInputs" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                	<h4>Sign Up</h4>
					<span class="error"><?php echo $serverErr;?></span>
                
                	<div class="bxInputField">
                        <label for="username">Username:</label>
                        <span class="input"><input id="username" type="text" name="name" value="<?php echo $name;?>"></span>
                        <span class="error"><?php echo $nameErr;?></span>
					</div>
					
                    <div class="bxInputField">
                        <label for="email">E-mail:</label>
                        <span class="input"><input id="email" type="email" name="email" value="<?php echo $email;?>"></span>
                        <span class="error"><?php echo $emailErr;?></span>
					</div>
					
                    <div class="bxInputField">
                        <label for="password">Password:</label> 
                        <span class="input"><input id="password" type="password" name="pass" value="<?php echo $pass;?>" /></span>
                        <span class="error"><?php echo $passErr;?></span>				
					</div>
                    					
					<input class="btn" type="submit" value="Submit">
					<h5>Already have an account? <a href="sign_in.php">Login </a> here!</h5>
				</form>
				   
				<div id="done">
					<h4 class="left">User created successfully!</h4>
					<a href="sign_in.php">
						<div class="right btn">
							<h4>
								Proceed to login
							</h4>
						</div>
					</a>
				</div>
			</div>
        </div>
        
        <script>
			document.getElementById("done").style.display = "none";
		</script>
   
   		<?php
			require(dirname(dirname(__FILE__)).'/Scripts/dbConnect.php'); 
			
			// Hash the password before saving in the database
			$hashPass = password_hash($pass, PASSWORD_DEFAULT);	
			
			$sql = "INSERT INTO users (username, password, email)
			VALUES ('$name', '$hashPass', '$email')";

			if (!empty($name) & !empty($email) & !empty($pass)) {
				if (empty($nameErr) & empty($emailErr) & empty($passErr)) {
					if ($conn->query($sql) === TRUE) 
					{
						echo '<script>';
						echo '	document.getElementById("done").style.display = "block";';
						echo '	document.getElementById("signUp").style.display = "none";';
						echo '</script>';
					} 
					else 
					{
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
				}
			}
		?>
    </body>
</html>