<div class="navbar">
	<a href="index.php"><img src="./images/logo.png" alt="Album Logo" class="logo"></a>
	<ul class="navbar-tabs">
		<?php
	
		/* Put menu items into an array and then print them out*/
		$menu_items = array(
			'Albums' => 'albums.php',
			'Contribute' => 'add.php',
			'Search' => 'search.php',
			'Log In' => 'login.php',
			'Log Out' => 'logout.php'
			);

		foreach ($menu_items as $title => $page) {
			echo ("
				<li><a href='$page'>$title</a></li>
			");
		}

		?>
	</ul>
</div>