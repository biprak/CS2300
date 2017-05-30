<!DOCTYPE html>
<html lang="en">
<head>
	<title>Our Work</title>
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

	<!-- Achievements cover image made by me, Bipra Kundu -->
	<div class="cover-photo">
		<img src="./img/achievements.png" alt="Achievements Cover Photo">
	</div>

	<div class="description">
		<h1 class="heading">Thank you for everything</h1>
		<p>Thanks to everyone's contributions over the past few months, from just one pad to hundreds of dollars to generous shipments from all over the country and even Canada, we were able to raise 4,049 pads, 344 tampons, and 413 panty liners. This is no small feat and we could never have gotten this far without all of your support. We hope to continue raising awareness for the struggles of homeless women and any other underpriveleged groups. Nonetheless, we will continue to #FightFreeFlow.</p>
	</div>

	<?php

	/* Put questionnaire questions into an array*/
	$questions = Array(
		"
		<p class=\"question\">What percent of homeless people in America are women?</p>
		<select name=\"percentage\">
			<option value=\"incorrect\">5-20%</option>
			<option value=\"incorrect\">25-30%</option>
			<option value=\"correct\">35-40%</option>
		</select>
		<input type=\"submit\" value=\"Submit\" />
		",
		"
		<p class=\"question\">How much food can you get for the price of one package of pads?</p>
		<select name=\"food\">
			<option value=\"correct\">About two McPick for $5 meals</option>
			<option value=\"incorrect\">About one Applebee’s 2 for $20 meals</option>
			<option value=\"incorrect\">About four slices of dollar pizza</option>
		</select>
		<input type=\"submit\" value=\"Submit\" />
		",
		"
		<p class=\"question\">How many homeless people in America are LGBTQ+?</p>
		<select name=\"lgbtq\">
			<option value=\"correct\">1.6-2.8 million</option>
			<option value=\"incorrect\">3.4-3.6 million</option>
			<option value=\"correct\">5.5-6.5 million</option>
		</select>
		<input type=\"submit\" value=\"Submit\" />
		"
		);

	/* Strings to start the div and form tags */
	$div_start = 
		"<div class=\"questionnaire\">
		<form action=\"work.php\" method=\"post\">";
	
	$div_end =
		"</form>
		</div>";

	echo "<h1 class=\"heading\">Learn More</h1>";


	/* Print out and evaluate the first question */
	echo $div_start;
	echo $questions[0];

	if ( !empty($_POST["percentage"]) ) {
		$choice = $_POST["percentage"];
		checkAnswer("percentage", $choice);

	}

	echo $div_end;

	/* Print out and evaluate the second question */
	echo $div_start;
	echo $questions[1];

	if ( !empty($_POST["food"]) ) {
		$choice = $_POST["food"];
		checkAnswer("food", $choice);
	}

	echo $div_end;

	/* Print out and evaluate the third question */
	echo $div_start;
	echo $questions[2];

	if ( !empty($_POST["lgbtq"]) ) {
		$choice = $_POST["lgbtq"];
		checkAnswer("lgbtq", $choice);
	}

	echo $div_end;

	/* Function to check if the answer is correct and print out a response */
	function checkAnswer($question, $val) {
		if ( $val === "correct" ) {
			echo "
				<p>You are correct.<p> 
			";
		}

		if ($val === "incorrect") {
			echo "
				<p>Not quite<p> 
			";
		}
			
		if ( $question === "percentage") {
			echo "
				<p>In the US, 39.7% of homeless people are women - this means that nearly half of the homeless population has to deal with periods
				each month. An issue that affects such a large number of people is commonly overlooked, leaving women with no options but to suffer
				through bleeding and cramps with no help.</p>
			";
		}

		if ( $question === "food") {
			echo "
			<p>The cost of a single package of pads or tampons can buy two McDonald's meals. This leaves women with one of the toughest decisions to make
			each month: whether to buy food or hygiene products. Not only is this a demeaning, discouraging decision, it is also unfair. No one should be
			forced to choose between food and cleanliness.</p>
			";
		}

		if ( $question === "lgbtq") {
			echo "
			<p>Almost 40% of the homeless population in America is LGBTQ+. Millions of transgender youth live on the streets with no access to care. Many homeless shelters have restrictive requirements for accessing feminine hygiene products, leaving transgender people who experience periods with no care at all.</p>
			";
		}
	}

	?>

	<!-- Contact us form !-->
	<h1 class="heading">Contact Us!</h1>
	<div class="contact">
		<form action="work.php" method="post">
			Your name: <br>
			<input type="text" name="name" required>
			<br>

			Your message: <br>
			<textarea rows="10" cols="75" name="msg" required>
			</textarea>
			<br>

			<input type="submit" value="Submit">
		</form>
	</div>

	<?php
	/* Check if inputs are filled and send message to me as email */
	if ( !empty($_POST["name"]) ) {
		$name = $_POST["name"];

		if ( !empty($_POST["msg"]) ) {
		$msg = $_POST["msg"];
	}

	sendMail($name, $msg);
}

	/* Function to send email to me */
	function sendMail($name, $msg) {
		$to = "biprakundu@gmail.com";
		$subject = "Message from" . $name;

		mail($to, $subject, $msg);
	}


	?>

</body>
</html>