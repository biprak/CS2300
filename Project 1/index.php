<!DOCTYPE html>
<html lang="en">
<head>
	<title>Pads For the People</title>
	<link rel="stylesheet" type="text/css" href="./styles/pads.css">
	<link href="https://fonts.googleapis.com/css?family=Sahitya:400,700" rel="stylesheet">
</head>
<body class="intro">
	<!-- Construct the navigation bar -->
	<div class="navbar">
		<a href="index.php"><img src="./img/logo.png" alt="Pads Logo" class="logo"></a>
		<ul class="navbar-tabs">
			<?php
	
			/* Put menu items into an array and then print them out*/
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

	<!-- Intro cover image made by me, Bipra Kundu -->
	<div class="cover-photo">
		<img src="./img/cover.png" alt="Pads Cover Photo">
	</div>

	<div class="description">
		<h1 class="heading">Fight Free Flow</h1>
		<p>Started by two college sophomores in New York City who witnessed an unsettling disparity in the donation and distribution of goods in homeless shelters, Pads for the People aims to mitigate the severe lack of feminine hygiene products found among homeless women. Food and clothes are definite necessities, but the need for pads and tampons often goes under the radar. To make matters worse, these products are often much too expensive for homeless women to buy freely. Every month, they face a horrifying situation: whether to spend the little money they have on eating for the day or having a pad or tampon to prevent bleeding. This is a choice that no person should ever have to make and Pads for the People wholeheartedly believes that the right to be clean is a human right. So we are asking you to help us. If you can, please donate any unopened pads or tampons, or money that we can then use to buy these items. We must do everything in our power to protect a basic human right. <br> 
		#FightFreeFlow</p>
	</div>

</body>
</html>