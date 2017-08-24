<?php
// Start the session
session_start();

if(!empty($_SESSION['userId'])) {
	header("Location:../Pages/search.php");
}
?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Open Vocabulary</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link href="https://fonts.googleapis.com/css?family=Oleo+Script+Swash+Caps|Raleway" rel="stylesheet">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <![endif]-->
	</head>
	<body>
		<div id="storbox">
        	<div id="imgBackground"></div>
            
			<header id="header" class="ha-header ha-header-large">
				<nav id="nav">
					<h1>OpenVocabulary</h1>
					<h3>The free online glossary trainer</h3>
				</nav>
				
				<div class="btns">
					<a href="Pages/sign_in.php" class="btn btnSignIn yellow">Login</a>
					<a href="Pages/sign_up.php" class="btn btnSignUp pink">Sign Up</a>
				</div>
				
				<a href=#sec1>
					<h6 class="link">Want to know more?</h6>
				</a>
			</header>
			<span id="sec1"></span>
			<article>
				<section>
					<div class="text-left">
						<h2>What is OpenVocabulary?</h2>
						<p>OpenVocabulary is the fastest, easiest and best way to quickly learn and expand on your vocabulary in any language.
						This page makes it easy to create and organize different wordlists from multiple courses and school books, and share it with your class mates or students.
						You can even create you own private lists for your own studies or private assignments!</p>
					</div>
					<div class="img-right">
						<img id="imgSun" class="imgR icon" src="Icons/Sun.png" alt="spinning sun picture">
					</div>
				</section>
				<section>
					<div class="text-right">
						<h2>Work together</h2>
						<p>OpenVocabulary makes it easy to collaborate and study together, and it's content is compleatly user generated. By providing a quick way to create and categorize words after book, chapter and page, finding your glossarys are allways quickly accessible. Finding your and other's glossary lists has never been easier. If a specific list does not excist yet you can create them yourself, knowing that you helped every following student, and that they now can use and expand on what you've done.</p>
					</div>
					<div class="img-left">
						<img id="imgHeart" class="imgL icon" src="Icons/Heart.png" alt="Pulsating heart picture">
					</div>
				</section>
				<section>
					<div class="text-left">
						<h2>Free forever</h2>
						<p>OpenVocabulary will never charge for it's core functionality. If it helps you study, it will be free. Not everyone has money to spend on school or education and we totally get that. That's why I built OpenVocabulary with these people in mind from the very start. If you have any questions or improvment ideas, please let me know. This homepage is still under construction, and a lot will change. Be part of it!</p>
					</div>
					<div class="img-right">
						<img id="imgLetter" class="imgR icon" src="Icons/Letters.png" alt="Shaking abc picture">
					</div>
				</section>
				
				<a class="link" href="Pages/search.php" >
					<h6>Try without an account!</h6>
				</a>
			</article>
			<footer>
			</footer>
		</div>
     	
      	<script>
			function scrollSmoothToBottom (id) {
			   var div = document.getElementById(id);
			   $('#' + id).animate({
				  scrollTop: div.scrollHeight - div.clientHeight
			   }, 250);
			}

			function scrollSmoothToTop (id) {
			   var div = document.getElementById(id);
			   $('#' + id).animate({
				  scrollTop: 0
			   }, 250);
			}
		</script>
	</body>
</html>
