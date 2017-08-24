<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <?php
		require('../Scripts/dbConnect.php');

        $q = intval($_GET['q']);
		$queArr[] = $ansArr[] = "";
		
		// Load the words from the database
        $sql="SELECT * FROM words WHERE listId = '".$q."' ORDER BY listRow";
        $result = $conn->query($sql);
	
		$c = 0;
	
		// If there are words in the database, return rows filled with said words.
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$queArr[] = $row['word1'];
				$ansArr[] = $row['word2'];
				
				echo '<div id="rowBox' . $c . '" name="rowBox' . $c . '" class="rowBox">
						<p class="index">' . ++$c . '.</p>
						<div class="questionBox">
							<input class="tbx question" name="question[]" class="tbxQuestion" 
							value="' . $queArr[$c] . '" />
							<h3>Question</h3>    	
						</div>
						<div class="answerBox">
							<input class="tbx answer" name="answer[]" class="tbxAnswer" 
							value="' . $ansArr[$c] . '" />
							<h3>Answer</h3>    	
						</div>
					</div>';
			}
			
		// If there excist no words, return a empty row.
		} else {
			echo '<div id="rowBox' . $c . '" name="rowBox' . $c . '" class="rowBox">
				<p class="index">' . ++$c . '.</p>
				<div class="questionBox">
					<input class="tbx question" name="question[]" class="tbxQuestion" 
					value="" />
					<h3>Question</h3>    	
				</div>
				<div class="answerBox">
					<input class="tbx answer" name="answer[]" class="tbxAnswer" 
					value="" />
					<h3>Answer</h3>    	
				</div>
			</div>';
		}
		mysqli_close($conn);
    ?>
</body>
</html>