<!DOCTYPE html>
<html lang="en">
<head>
	<title>Pads Blog</title>
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

	<div class="container">
		<?php

		/* Put all the blog posts into an array */
		$posts = array(
			"
			<h3 class=\"date\">February 5 2017</h3>
			<h3 class=\"title\">Thanks For Coming to Our Packaging Party</h3>
			
			<!-- Photo of volunteers, courtesy of Amy and Sabrina -->
			<figure>
				<img src=\"./img/packaging.png\" alt=\"Pads Logo\" class=\"blog-img\">
				<figcaption>Photo of all the volunteers who helped package the pads. Courtesy of Amy and Sabrina.</figcaption>
			</figure>
			
			<p>Hey everyone!
			Hi all!
			We want to give a HUGE thank you to everyone who came out to our packaging event yesterday! We successfully made 162 care packages, with
			handwritten cards in each one. This is a task that we could not have accomplished without the love, support, and dedication of all of
			you. Thank you so much to everyone who came to the event and everyone who donated - your generosity means so much to us and to the women
			receiving these care packages.<br> <br>

			Much love,<br> 
			Sabrina and Amy</p>
			",
			"
			<h3 class=\"date\">January 21 2017</h3>
			<h3 class=\"title\">Care Packages</h3>
			<p>Hey everyone!
			We're so excited to announce that it's finally time to make care packages! We've had such an incredible drive, and we can't wait to begin 	distribution. We hope to see everyone at our packaging party on February 4th, your help is greatly wanted and appreciated!
			Remember to RSVP to the event page!<br> <br>
			Much love,<br> 
			Sabrina and Amy</p>
			",
			"
			<h3 class=\"date\">January 1 2017</h3>
			<h3 class=\"title\">Happy New Year!</h3>
			<p>Happy 2017!
			We're ringing in the New Year with grateful and excited hearts! Thank you for a wildly successful drive. Each and every person who has donated
			will have a beautiful impact on someone else's life. Whether you passed us a handful of pads or made a large cash contribution, you worked to
			restore dignity and health to some of the most overlooked members of our NYC community.
			We can't wait to continue fighting for women's rights with you all. Stay wonderful! (And we'll be making more announcements about final
			donation numbers and care package creation/distribution events in the future!)<br> <br>
			Much love,<br>
			Sabrina and Amy</p>
			",
			"
			<h3 class=\"date\">December 21 2016</h3>
			<h3 class=\"title\">Holiday Updates</h3>
			<p>Hello everyone!<br>
			Sorry for the finals week hiatus but now that the holiday season is upon us, we wanted to wish everyone a warm, happy, and healthy holidays! :)
			Some more Pads reminders are that <br>
			1) we are extending our donations drive deadline until January 1st! We WON'T be taking them on a rolling basis afterwards, simply because we'd like to make the care packages en bulk and make sure that they are all equal in content and quality. <br>
			2) we are also looking for drug free alternatives to help with cramping, so that we can put those in the packages as well. If you have any suggestions, please comment below or shoot us a message! <br>
			3) we are still in the process of contacting shelters and figuring out which one is best allied with Pads for the People's personal mission of making pads and tampons most accessible to women on the street (not just those who can make it to shelters). If you have any names or recommendations, we'd love to hear those as well! <br><br>
			Much love, <br>
			Sabrina and Amy <br>
			P.S You all make our hearts so much brighter this season!</p>
			",
			"
			<h3 class=\"date\">December 4 2016</h3>
			<h3 class=\"title\">Donations So Far</h3>
			<p>Donations (as of December 5th!): 883 pads, 344 tampons, 221 liners, and $404 <br><br>
			Hey everyone! <br>
			We are so grateful that our donations are still growing, and we really hope that this continues throughout the end of the drive! As of today,
			December 4th, our total donations will bring us to the equivalent of 3371 goods! As the end of December approaches, we are getting ready for
			packing and distribution. If anyone has any suggestions about distribution or couponing (to help us maximize the number of pads we can buy!)
			please let us know! <br>
			Thank you all so much for your love and support. <br><br>

			Much love, <br>
			Sabrina and Amy <br></p>
			",
			"
			<h3 class=\"date\">December 1 2016</h3>
			<h3 class=\"title\">A Great Start to December</h3>
			<p>Hello! 
			We have some great news to share! Today, we not only reached but SURPASSED our original GoFundMe goal of $250. We are continually blown away
			by your kindness and generosity. If you would like to donate to Pads for the People, please go to https://www.gofundme.com
			pads-for-the-people.
			Let's try to raise enough funds for as many pads and tampons as possible! <br><br>

			Much love, <br>
			Sabrina and Amy <br></p>
			",
			"
			<h3 class=\"date\">November 21 2016</h3>
			<h3 class=\"title\">More Donations!</h3>
			<p>Donations (as of November 21st): 582 pads, 39 tampons, 32 liners, and $284 <br><br>
			Hello everyone! <br>
			We’re so grateful that everyone came out to the potluck and supported our cause. It was a lot of fun to meet you all! We are blown away by
			how much our donations have increased over this past week. We are very proud to say that we’ve QUADRUPLED our original goal and now we have
			enough money/goods to bring our donations up to 2024 pads/tampons!!! We couldn’t have done it without you all! <br>
			Thank you and stay tuned for more announcements! <br><br>

			Much love, <br>
			Sabrina and Amy<br></p>
			",
			"
			<h3 class=\"date\">November 13 2016</h3>
			<h3 class=\"title\">Thanksgiving Potluck</h3>
			<p>Hi everyone! <br>
			We’re really excited to announce that we’re going to be hosting a Thanksgiving potluck dinner on Sunday, November 20th! It’ll be in
			Brookdale’s cafeteria at 7 PM, but it is open to anyone — CUNY student or not! Bring some pads/tampons in the spirit of giving and mingle
			with others :) <br>
			Please RSVP on the event page so we know if you’re coming. <br>
			We hope to see you all there! <br><br>

			Much love, <br>
			Sabrina and Amy<br></p>
			"
			);

		/* Iterate through array to print blog posts */
		foreach ($posts as $post_item) {
			echo "<div class=\"blog-post\">";
			echo $post_item;
			echo "</div> <hr>";
		}

		?>
	</div>
</body>
</html>