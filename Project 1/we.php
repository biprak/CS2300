<!DOCTYPE html>
<html lang="en">
<head>
	<title>Who We Are</title>
	<link rel="stylesheet" type="text/css" href="./styles/pads.css">
	<link href="https://fonts.googleapis.com/css?family=Sahitya:400,700" rel="stylesheet">
</head>
<body>
	<!-- Construct the navigation bar -->
	<div class="navbar">
		<a href="index.php"><img src="./img/logo.png" alt="Pads Logo" class="logo"></a>
		<ul class="navbar-tabs">
			<?php
	
			/* Put menu items into an array and then print them our*/
			$menu_items = array(
				'Blog' => 'blog.php',
				'Who We Are' => 'we.php',
				'Our Work' => 'work.php',
				'Donate' => 'https://www.gofundme.com/pads-for-the-people',
				);

			foreach ($menu_items as $title => $page) {
				echo ("
					<li><a href='$page'>$title</a></li>
				");
			}

			?>
		</ul>
	</div>

	<!-- Container for bio -->
	<div class="container">
		<div class="we-image">
			<!-- Picture of Amy taken by me -->
			<img src="./img/amy.jpg" alt="Amy Zhen">
		</div>
		<!-- Put bio and Guess the Lie in this div -->
		<div class="we-post" >
			<?php

			/* Store Guess the Lie form in a string and then print it */
			$amy_quiz = "
				<form method=\"post\" class=\"amy-quiz\">
					<p class=\"guess\">Guess the Lie!</p>
					<input type=\"radio\" name=\"amy-choice\" value=\"incorrect\" required> I tried smuggling lobsters on to a plane. <br>
					<input type=\"radio\" name=\"amy-choice\" value=\"incorrect\"> I go to Church every single week. <br>
					<input type=\"radio\" name=\"amy-choice\" value=\"correct\"> My favorite flavor of ice cream is pistachio. <br>
					<input type=\"submit\" value=\"Submit\" />
				</form>
				";

			echo $amy_quiz;

			$amy_bio = 
				"
				<p>Hello! My name is Amy Zhen. I go to Church every Sunday, I did once try to bring back a whole luggage of lobsters from my relatives in China, but I hate pistachio ice cream. I'm a sophomore at the Macaulay Honors College at Hunter. I'm double majoring in creative writing and psychology, while also pursuing a minor in Asian American studies. Some of the activities I'm involved with at my school include the Coalition for the Revitalization of Asian American Studies (CRAASH), Macaulay Book Club, and Humans of Macaulay. I'm very interested in photography, spoken word, fashion, museum going, and cooking.</p>
				";

			/* Check the answer to Guess the Lie and then post appropriate response */
			if ( !empty($_POST["amy-choice"]) ) {
				$amy_choice = $_POST["amy-choice"];

				removeQuiz("amy");

				checkGuess($amy_choice);

				echo $amy_bio;
			}

			?>
		</div>
	</div>

	<!-- Container for bio -->
	<div class="container">
		<div class="we-image">
			<!-- Picture of Sabrina taken by me -->
			<img src="./img/sabrina.jpg" alt="Sabrina Rich">
		</div>	
		<!-- Put bio and Guess the Lie in this div -->
		<div class="we-post" >
			<?php

			/* Store Guess the Lie form in a string and then print it */
			$sab_quiz = "
				<form method=\"post\" class=\"sab-quiz\">
					<p class=\"guess\">Guess the Lie!</p>
					<input type=\"radio\" name=\"sab-choice\" value=\"incorrect\" required> My favorite show is Buffy the Vampire Slayer. <br>
					<input type=\"radio\" name=\"sab-choice\" value=\"incorrect\"> I used to be an avid soccer player. <br>
					<input type=\"radio\" name=\"sab-choice\" value=\"correct\"> I have a cat named Lucky. <br>
					<input type=\"submit\" value=\"Submit\" />
				</form>
				";

			echo $sab_quiz;

			$sab_bio = 
				"
				<p>Hey! My name is Sabrina Rich and I'm a sophomore at the Macaulay Honors College at Hunter College. My favorite show is Buffy, I did used to play soccer, but I actually have dog named lucky I'm studying political science and sociology, with a minor in human rights and Asian American studies. I'm also involved with the Coalition for the Revitalization of Asian American Studies at Hunter (CRAASH) and Macaulay Book Club. In my free time I really enjoy theatre (doing stage crew as well as seeing shows) and reading. My favorite broadway show is Eclipsed, and my favorite authors are Arundhati Roy, Jhumpa Lahiri, and Chimamanda Ngozi Adichie!</p>
				";

			/* Check the answer to Guess the Lie and then post appropriate response */
			if ( !empty($_POST["sab-choice"]) ) {
				$sab_choice = $_POST["sab-choice"];

				removeQuiz("sab");

				checkGuess($sab_choice);

				echo $sab_bio;
			}

			?>

			<?php

			/* Function using javascript to remove Guess the Lie quiz after an answer is submitted */
			function removeQuiz($name) {
				echo "
				<script type=\"text/javascript\">
				var quiz = document.querySelector('.{$name}-quiz');
				quiz.style.display = \"none\";
				</script>
				";
			}

			/* Function to check the answer and print appropriate response */
			function checkGuess($x_choice) {
				if ( $x_choice === "correct" ) {
					echo "
					<p>Yep, you got it!</p> 
					";
				} elseif ( $x_choice === "incorrect" ) {
					echo "
					<p>Nope, you're wrong!</p> 
					";
				}
			}

			?>

		</div>
	</div>
</body>
</html>