<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>OpenVocab - List Overwiew</title>
        <link rel="stylesheet" type="text/css" href="courses-style.css">
        <link rel="icon" href="../Icons/book-icon-green.png" />
        <link href="https://fonts.googleapis.com/css?family=Oleo+Script+Swash+Caps|Raleway" rel="stylesheet"> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <![endif]-->
    </head>
    
    <body>   	
       	<?php
			require(dirname(dirname(__FILE__)).'/Scripts/dbConnect.php');
			
			// Variables
	   		$title = $queArr[] = $ansArr[] = "";
			$listResult = $listErr = "";
			$listHeader = "Create new list";
		
			if(!empty($_SESSION['listId'])) {
				$listId = $_SESSION['listId'];
				
				// Load the title
				$sql = "SELECT title, listId FROM lists";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						if ($row["listId"] == $listId) {
							$title = $row["title"];
						}
					}
				}
				
				// Change title
				$listHeader = "Edit list";
			}
		
			// Run when any submit button is clicked
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				
				$title = test_input($_POST["title"]);

				if (empty($title)) {
					$listErr = "Title is required."; 
				} else if (!preg_match("/^[a-zA-Z0-9 -']*$/",$title)) {
					$listErr = "Only letters, numbers and white space allowed"; 
				} else {
					
					if (isset($_POST['save'])) {
						
						if(!isset($listId)) {
							create_list();
							update_list();
							$listResult = "List succsessfully created!";
						} else {
							update_list();
							$listResult = "List succsessfully updated!";
						}
												
					} else if (isset($_POST['train'])) {
						
						if(!isset($listId)) {
							create_list();
							update_list();
						} else {
							update_list();
						}
						header("Location:glossary.php");
					}
					
				}
			}
			
			function create_list() {
				require(dirname(dirname(__FILE__)).'/Scripts/dbConnect.php');
				
				global $title, $listId;
				
				$userId = $_SESSION["userId"];
				$sql = "INSERT INTO lists (userId, title) VALUES ('$userId', '$title')"; // Create list
				$conn->query($sql);

				$listId = $conn->insert_id; // Save last grenerated Id;
				$_SESSION["listId"] = $listId;

				$sql2 = "INSERT INTO words (listRow) VALUES (0)"; // Insert one empty word
				$conn->query($sql2);

			}
			function update_list() {
				require(dirname(dirname(__FILE__)).'/Scripts/dbConnect.php');
				
				// Apply some values
				global $title, $listId;
				
				$listId = $_SESSION["listId"];
				$listHeader = "Edit list";
				$userId = $_SESSION['userId'];

				// Update list information
				$sql = "UPDATE lists SET title='$title', userId='$userId' WHERE listId='$listId'";

				if ($conn->query($sql) !== TRUE) {
					echo "Error while updating the List Tile: " . $conn->error . "<br>";
				}

				/* Update word information */
				$queArr = $_POST["question"];
				$ansArr = $_POST["answer"];
				
				$acceptedRows = 0;
				for($i=0; $i<$queArr; $i++) {
					if(!empty($queArr[$i])) {
						$queArr[$i] = test_input($queArr[$i]);
						$acceptedRows++;
					} else {
						break;
					}
				}
				
				$count = 0;
				for($i=0; $i<$ansArr; $i++) {
					if(!empty($ansArr[$i])) {
						$ansArr[$i] = test_input($ansArr[$i]);
						$count++;
					} else {
						$acceptedRows = $count;
						break;
					}
				}

				// CHECK HOW MANY WORDS ALLREADY EXCIST IN DATABASE
				$sql = "SELECT * FROM words WHERE listId='$listId'";
				$result = $conn->query($sql);
				$words = $result->num_rows;
								
				for ($i = 0; $i < count($queArr); $i++) {	
					// Uppdate all words associated with this specific list in the table "words"
					if ($i < $acceptedRows & $i >= $words) {
						$sql = "INSERT INTO words (listId, listRow, word1, word2) VALUES ('$listId', '$i', '$queArr[$i]', '$ansArr[$i]')";
						$result = $conn->query($sql);
						//echo ("Word Inserted <br>");
					} else if ($i >= $acceptedRows) {
						$sql = "DELETE FROM words WHERE listId='$listId' AND listRow='$i'";
						$result = $conn->query($sql);
						//echo ("Word Removed <br>");
					} else if ($i < $words) {
						$sql = "UPDATE words SET word1='$queArr[$i]', word2='$ansArr[$i]' WHERE listId='$listId' AND listRow='$i'";
						$result = $conn->query($sql);
						//echo ("Word Updated <br>");
					}
				}
			}
				
			function test_input($data) {
				  $data = trim($data);
				  $data = stripslashes($data);
				  $data = htmlspecialchars($data);
				  return $data;
			}
			
			include('../Pages/header.php');
		?>    
        
		<form id="frmEdit" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
			<div class="extendedHeader">
				<div class="floatingBox">
					<h4><?php echo $listHeader;?></h4>
						<div id="titleBox">
							<input class="tbx" name="title" placeholder="Write the title here..." id="title" 
							value="<?php echo($title);?>"/>
							<h3>Title</h3>
						</div>
					<span class="error"><?php echo($listErr);?></span>
					<span class="info"><?php echo($listResult);?></span>
				</div>
			</div>
			<div id="wordList" class="bxContent wordList">			
				<h4>Words:</h4>
				<div id="newWords">
					<?php include(dirname(dirname(__FILE__)).'/Scripts/listButtons.php'); ?>
					<div id="newWords2">
						<div id="rowBox0" class="rowBox">
							<p class="index">1.</p>
							<div class="questionBox">
								<input class="tbx question tbxQuestion" name="question[]" placeholder="Write a question here..." />
								<h3>Question</h3>    	
							</div>
							<div class="answerBox">
								<input class="tbx answer tbxAnswer" name="answer[]" placeholder="Then write the answer here!" />
								<h3>Answer</h3>    	
							</div>
						</div>
					</div>
					<?php include(dirname(dirname(__FILE__)).'/Scripts/listButtons.php'); ?>
					<span class="info">Please notice that BOTH question and answer is required. Ignoring this might cause problems.</span>
					<span class="info">Please do NOT leave any empty spaces in the middle of your list.</span>
					<span class="info">Empty rows at the end of your list will be DELETED.</span>
					<br>
				</div>
			</div>
		
			<!-- Adds a new row -->
			<script>
				
				// Scroll code directly stolen. ThoQ on stackOverflow, your my man!!
				
				function scrollToBottom (id) {
				   var div = document.getElementById(id);
				   div.scrollTop = div.scrollHeight - div.clientHeight;
				}

				function scrollToTop (id) {
				   var div = document.getElementById(id);
				   div.scrollTop = 0;
				}
				
				//Require jQuery
				function scrollSmoothToBottom (id) {
				   var div = document.getElementById(id);
				   $('#' + id).animate({
					  scrollTop: div.scrollHeight - div.clientHeight
				   }, 250);
				}

				//Require jQuery
				function scrollSmoothToTop (id) {
				   var div = document.getElementById(id);
				   $('#' + id).animate({
					  scrollTop: 0
				   }, 250);
				}
				
				function newRow() {
					var i = document.getElementsByName("question[]").length + 1;
					var original = document.getElementById("rowBox0");
					var clone = original.cloneNode(true);
					
					clone.getElementsByClassName("index")[0].innerHTML = i + ".";
					clone.getElementsByClassName("question")[0].value = "";
					clone.getElementsByClassName("answer")[0].value = "";
					clone.style.display = "block";
					original.parentNode.appendChild(clone);
					
   					scrollSmoothToBottom('wordList');
					
					window.scrollTo(0,document.body.scrollHeight);
				}
				function scroll() {
					window.scrollTo(0,0);
				}
				function loadInfo() {
					try {
						var listId = <?php if(!empty($_SESSION["listId"])) {echo $_SESSION["listId"];} else { echo '""'; } ?>;

						if (window.XMLHttpRequest) {
							xmlhttp = new XMLHttpRequest(); // code for IE7+, Firefox, Chrome, Opera, Safari
						} else {
							xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); // code for IE6, IE5
						}

						xmlhttp.onreadystatechange = function() 
						{
							if (this.readyState == 4 && this.status == 200) 
							{
								document.getElementById("rowBox0").style.display = "none";
								document.getElementById("newWords2").innerHTML = this.responseText;
							}
						};
						xmlhttp.open("GET","loadwords.php?q="+listId,true);
						xmlhttp.send();
					} catch (err) {}
				}
				function cancelReturn() {
					if (confirm("All your unsaved changes will be deleted. Are you sure?") == true) {
						document.location.href = "../Pages/search.php";
					}
				}
				
				document.onkeypress=function(e){
					if (e.keyCode == 9 & e.shiftKey == true) {
						newRow();
					}
				}
			</script>
            
            <?php if (!empty($_SESSION["listId"])) { echo '<script> loadInfo(); </script>'; }?>
        </form>   
    </body>
</html>