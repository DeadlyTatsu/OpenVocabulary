<?php
  session_start();
?>

<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Train the words</title>
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
		require(dirname(dirname(__FILE__)).'/Scripts/dbConnect.php');
		
		$listId = "";
		
		$list[][] = "";
		$listId = $_SESSION['listId'];
		$sql = "SELECT * FROM words WHERE listId='$listId' ORDER BY listRow";
		$result = $conn->query($sql);
		
		for($i = 0; $i < $result->num_rows; $i++) {
			$row = $result->fetch_assoc();
			$list[$i][0] = $row['word1'];
			$list[$i][1] = $row['word2'];
		}
		
		shuffle($list);
		
		include('../Pages/header.php');
	?>
        
      	<div id="fullscreen" class="extendedHeader">
   			<div class="floatingBox">
                	<h4 id="titleText" class="left">Translate</h4>
                	<h4 id="status" class="right">10/14 Answerd!</h4>
				
                <div id="innerGlossBox">
					<div class="left" id="gQuestionBox">
						<h2 id="question">Lamp</h2>
						<h3>The word to translate</h3>
					</div>

					<div class="left fullLength" id="gAnswerBox">
						<input class="tbx " id="answer" autofocus/>
						<h3>Write the answer</h3>
					</div>

					<div class="left fullLength" id="gKeyBox">
						<input class="tbx fullLength" id="key"/>
						<h3>The correct answer</h3>
					</div>

					<input class="btn pink right" type="button" id="btnCheckAnswer" value="Check Answer" onClick="showAnswer()" />
      				<input class="btn hidden yellow right" type="button" id="btnNewWord" value="Next Word" onClick="nextWord()" />
					<input class="btn hidden pink right" type="button" id="btnStartOver" value="Start Over" onClick="startOver()" />
      				<input class="btn hidden yellow right" type="button" id="btnReturn" value="I'm done" onClick="finish()" />
      				
      				<span id="result"></span>        
				</div>
      		</div>
        </div>
        
        <span id="test" style="margin-top: 300px"></span>
        
        <script>
			function test_input(data) {
				data.trim();
				return data;
			}
			
			var strList = '<?php echo json_encode($list);?>' 	// data is now the string '[1,2,3]';
			var arrList = JSON.parse(strList); 					// data is now the array [1,2,3];
			var amtWords = arrList.length;
			
			document.getElementById("key").readOnly = true;
			document.getElementById("status").innerHTML = "0/" + amtWords + " Words Answerd!";
			
			function showAnswer() {
				var corrAnswer = arrList[0][1];
				document.getElementById("key").value = corrAnswer;
				
				var answer = document.getElementById("answer").value;
				answer = test_input(answer);
				
				if(corrAnswer == answer) {
					document.getElementById("answer").style.color = "green";
					arrList.splice(0, 1);	// removes the wordpair
				} else {
					document.getElementById("answer").style.color = "red";
					document.getElementById("gKeyBox").style.display = "block";
					// pushes the incorrect wordpair last
					var b = arrList.shift();
					arrList.push(b);
				}
				var wordsLeft = amtWords - arrList.length;
				
				// replace element to trigger animation again
				var elm = document.getElementById("gKeyBox");
				var newone = elm.cloneNode(true);
				elm.parentNode.replaceChild(newone, elm);
				
				document.getElementById("status").innerHTML = wordsLeft + "/" + amtWords + " Words Answerd!";
				document.getElementById("btnNewWord").style.display = "block";
				document.getElementById("btnCheckAnswer").style.display = "none";
			}
			function nextWord() {
				
				document.getElementById("btnNewWord").style.display = "none";
				
				try {
					var question = arrList[0][0];
					
					// replace element to trigger animation again
					var elm = document.getElementById("gQuestionBox");
					var newone = elm.cloneNode(true);
					elm.parentNode.replaceChild(newone, elm);

					document.getElementById("answer").style.color = "black";
					document.getElementById("gKeyBox").style.display = "none";
					document.getElementById("question").innerHTML = question;
					document.getElementById("answer").value = "";
					document.getElementById("btnCheckAnswer").style.display = "block";
					document.getElementById("answer").focus();

					// TEST 
					//document.getElementById("test").innerHTML = "";
					//for(var i = 0; i < arrList.length; i++) {
					//	document.getElementById("test").innerHTML += arrList[i][0] + " - " + arrList[i][1] + "<br>";
					//}
				}
				catch(err) {
					document.getElementById("gQuestionBox").style.display = "none";
					document.getElementById("btnStartOver").style.display = "block";
					document.getElementById("btnReturn").style.display = "block";
				}
			}
			function startOver() {
				document.location.href = "../Pages/glossary.php";
			}
			function finish() {
				document.location.href = "../Pages/search.php";
			}
			
			document.onkeypress=function(e){
				if(document.getElementById("btnNewWord").style.display == "block") {
					nextWord();
				} else if (e.keyCode == 13) {
					showAnswer();
				}
			}
			

			
			nextWord();
		</script>
    </body>
</html>
