<header>
	<a href="../index.php" class="left">
		<h1>OpenVocabulary</h1>
	</a>

	<form id="logOutUserBox" method="post" action="/Scripts/sign_out.php">
		<?php
			if(!empty($_SESSION["username"])) {
				echo '<input id="btnLogOut" class="btn yellow right" type="submit" name="logOut" value="Log Out"/>';
			} else {
				echo '<input id="btnLogOut" class="btn pink right" type="submit" name="logOut" value="Log In"/>';	
			}
		?>

		<h2 class="right">
			<span id="user">
				<?php 
					if(!empty($_SESSION["username"])) {
						echo("Logged in as");
					} else {
						echo("Not logged in");
					}
				?> 
			</span>
			<span id="user-name" class="right">
				<?php
					if (isset($_SESSION["username"])) {
						echo $_SESSION["username"];
					}
				?>
			</span>
		</h2>
	</form>
</header>