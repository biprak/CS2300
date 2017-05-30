<?php
	$page_title = 'Search';
	include_once('./includes/header.php');	
?>

<body>

	<?php
		include_once('./includes/navbar.php');
	?>

<div id="search_form" class="form"> 
	<h2 class="title">Search</h2>
	<br> 
	<form method="post" action="search.php">
		<!-- Input term -->
		<div class="input">
			<label>Search Term: </label>
			<input type="text" name="search_term" maxlength="1000" required> 
		</div>
		<div class="button">
			<input type="submit" name="search" value="Search">
		</div>
	</form>
</div>

<?php
	require_once 'includes/config.php';

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if (!empty($_POST['search'])){

		$term = filter_input(INPUT_POST, 'search_term', FILTER_SANITIZE_STRING);

		// Query for matching term 
		$result = $mysqli->query('SELECT * FROM Photos WHERE title LIKE "%' . $term . '%" OR author LIKE "%' . $term . '%" OR caption LIKE "%' . $term . '%";');

		// If terms found, show them
		if ($result->num_rows > 0){

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

				print("<td class=\"thum\"><img src=\"$file_name\" alt=\"picture\"></td>");
				print("<td>$title</td>");
				print("<td>$author</td>");
				print("<td>$caption</td>");
			}

			print('</tbody>
				</table>
				');
		}

		else {
			echo '<p class="message">Could not find any matching results</p>';
		}
	}


?>
