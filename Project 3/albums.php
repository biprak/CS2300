<?php
	$page_title = 'Albums';
	include_once('./includes/header.php');	
?>

<body>
	<?php
		include_once('./includes/navbar.php');

		require_once 'config.php';

		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		if ($mysqli->errno) {
			print "<p>$mysqli->error</p>";
			exit();
		}

		$result = $mysqli->query("SELECT * FROM Albums;");


		while ( $row = $result->fetch_assoc() ) {

			$title = $row[ 'title' ];
			$description = $row[ 'description'];
			$date_created = $row[ 'date_created' ];
			$date_modified = $row[ 'date_modified' ];
			$album_id = $row[ 'album_id' ];

			print ("<div class=\"album-entry\">
				<a class=\"album-title\" href=\"album.php?album_id=$album_id\">$title</a>
				<p class=\"date\">Album est. $date_created</p>
				<p class=\"date\">Album modified: $date_modified</p>
				<p class=\"description\">$description</p>
				</div>"
				);
		}
	?>
</body>