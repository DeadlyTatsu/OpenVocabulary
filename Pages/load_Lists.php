<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"> 
</head>
<body>
   
    <?php
		require('../Scripts/dbConnect.php');

        $searchInput = trim($_GET['q']);
		$userlist = $_GET['x'];
	
		
		
		// Load all the user lists from the database!
		if($userlist == "true") {
			if(!empty($_SESSION['userId'])) {
				$sql="SELECT * FROM lists WHERE title LIKE '%".$searchInput."%' AND userId='".$_SESSION['userId']."'"; // LIMIT 12";
				$result = $conn->query($sql);

				// If there are list in the database, return them.
				if ($result->num_rows > 0) {

					echo '<h4 class="listLabel">Your lists:</h4>';
					echo '<div class="lists">';
					
					while($row = $result->fetch_assoc()) {

						// Load the lists from the database
						$sql="SELECT * FROM users WHERE userId='".$row['userId']."'";
						$user = $conn->query($sql)->fetch_assoc();

						echo '<form class="list publicList" method="post">
								<h1 class="title">'.$row['title'].'</h1>
								<input type="submit" class="btn listBtn edit yellow" name="edit" value="Edit">
								<input type="submit" class="btn listBtn train pink" name="train" value="Train">
								<input type="text" class="hidden" name="listId" value="'.$row['listId'].'">
								<p class="listElement listUser user">Created by: '.$user['username'].'</p>
							</form>';
					}
					echo '</div>';
				}
			}
			
		// Load all the public and visable lists from the database!
		} else if ($userlist == "false") {

			$sql="SELECT * FROM lists WHERE title LIKE '%".$searchInput."%' AND userId<>'".$_SESSION['userId']."'"; 
			$result = $conn->query($sql);

			// If there are list in the database, return them.
			if ($result->num_rows > 0) {
				
				echo '<h4 class="listLabel">Public lists:</h4>';
				echo '<div class="lists">';
				
				while($row = $result->fetch_assoc()) {

					// Load the lists from the database
					$sql="SELECT * FROM users WHERE userId='".$row['userId']."'";
					$user = $conn->query($sql)->fetch_assoc();

					echo '<form class="list userList" method="post">
							<h1 class="title">'.$row['title'].'</h1>
							<input type="submit" class="btn listBtn train pink" name="train" value="Train">
							<input type="text" class="hidden" name="listId" value="'.$row['listId'].'">
							<p class="listElement listUser user">Created by: '.$user['username'].'</p>
						</form>';
				}
				
				echo '</div>';
				echo '<h4 id="listLabel" class="info">No more search results...</h4>';
			} else {
				echo '<h4 id="listLabel" class="info">No search result for <u>'. $searchInput .'</u></h4>';
			}
		}	
		mysqli_close($conn);
    ?>
    
</body>
</html>