<?php
  session_start();
?>

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



		if (!empty($_GET["album_id"]) && !filter_var($_GET["album_id"], FILTER_VALIDATE_INT) === false) {
			$album_id = $_GET["album_id"];


			$result = $mysqli->query("SELECT *
      										FROM Photos 
											INNER JOIN PhotosInAlbum ON Photos.photo_id = PhotosInAlbum.photo_id
     										WHERE PhotosInAlbum.album_id = $album_id; ");

			print('<table>
			<thead>
			<tr>
			<th>Photo</th>
			<th>Title</th>
			<th>Author</th>
			<th>Caption</th>
			</tr>
			</thead><tbody>');
		
			while ( $row = $result->fetch_assoc() ) {
				print('<tr>');

				$title = $row[ 'title' ];
				$author = $row[ 'author' ];
				$caption = $row[ 'caption' ];
				$file_name = $row[ 'file_name' ];
				$photo_id = $row[ 'photo_id' ];

				print("<td class=\"thum\"><a href=\"photo.php?photo_id=$photo_id\"> <img src=\"$file_name\" alt=\"picture\"> </a></td>");
				print("<td>$title</td>");
				print("<td>$author</td>");
				print("<td>$caption</td>");
			}

		print('</tbody>
			</table>
			');

		}	
	?>
	</body>