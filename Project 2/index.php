<!DOCTYPE html>
<html>
<head>
	<title>Hip-Hop Catalog</title>
	<link rel="stylesheet" type="text/css" href="./styles/style.css?version=1.9">
	<link href="https://fonts.googleapis.com/css?family=Cinzel:400,700,900" rel="stylesheet">
</head>
<body>

<!-- Image created by me, Bipra Kundu -->
<div id="header">
	<img src="./img/header.png" alt="header">
</div>

<!-- Form for adding entry -->
<div id="add_form" class="form"> 
	<h2 class="title">Add</h2>
	<form method="post" action="index.php">
		<!-- Input album name-->
		<div class="input">
			<label>Album Name</label>
			<input type="text" name="album_name" maxlength="34" required> 
		</div>
		<!-- Input artist name-->
		<div class="input">
			<label>Artist Name</label>
			<input type="text" name="artist_name" maxlength="34" required> 
		</div>
		<!-- Input single name-->
		<div class="input">
			<label>Hit Single</label>
			<input type="text" name="single_name" maxlength="34" required> 
		</div>
		<!-- Input Year -->
		<div class="input">
			<label>Year</label>
			<input type="text" name="year" maxlength="4" required> 
		</div>
		<!-- Input certification -->
		<div class="input">
			<label>Sales Certification</label>
			<select name="certification">
				<option>Please Select</option>
				<option value="gold">Gold</option>
				<option value="platinum">Platinum</option>
				<option value="multi-platinum">Multi-Platinum</option>
				<option value="diamond">Diamond</option>
			</select>
		</div>
		<!-- Input awards -->
		<div class="input">
			<label>Awards</label>
			<select name="awards">
				<option>Please Select</option>
				<option value="grammy">Grammy Award</option>
				<option value="bet">BET Award</option>
				<option value="mtv">MTV Video Music Award</option>
				<option value="bilboard">Bilboard Music Award</option>
			</select>		
		</div>
		<div class="button">
			<input type="submit" name="add" value="Add">
		</div>
	</form>
</div>

<!-- Form for searching entry -->
<div id="search_form" class="form"> 
	<h2 class="title">Search</h2>
	<form method="post" action="index.php">
		<!-- Input album name-->
		<div class="input">
			<label>Album Name</label>
			<input type="text" name="album_name" maxlength="34"> 
		</div>
		<!-- Input artist name-->
		<div class="input">
			<label>Artist Name</label>
			<input type="text" name="artist_name" maxlength="34"> 
		</div>
		<!-- Input single name-->
		<div class="input">
			<label>Hit Single</label>
			<input type="text" name="single_name" maxlength="34"> 
		</div>
		<!-- Input Year -->
		<div class="input">
			<label>Year</label>
			<input type="text" name="year" maxlength="4"> 
		</div>
		<!-- Input certification -->
		<div class="input">
			<label>Sales Certification</label>
			<select name="certification">
				<option>Please Select</option>
				<option value="gold">Gold</option>
				<option value="platinum">Platinum</option>
				<option value="multi-platinum">Multi-Platinum</option>
				<option value="diamond">Diamond</option>
			</select>
		</div>
		<!-- Input awards -->
		<div class="input">
			<label>Awards</label>
			<select name="awards">
				<option>Please Select</option>
				<option value="grammy">Grammy Award</option>
				<option value="bet">BET Award</option>
				<option value="mtv">MTV Video Music Award</option>
				<option value="bilboard">Bilboard Music Award</option>
			</select>		
		</div>
		<div class="button">
			<input type="submit" name="search" value="Search">
		</div>
	</form>
</div>

<?php
	// Get name of data file. 
	$file_name = 'data.txt';

	// Check file exists 
	if(!file_exists($file_name)) {
		print("<p class=\"message\">Unable to find the file $file_name</p>");
		exit;
	}

	// Open file for reading 
	$file_pointer = fopen($file_name, 'r');

	// Notify user if open was not successful 
	if (!$file_pointer) {  
		print("<p class=\"message\">Could not find file</p>");  
		exit;
	}

	// Initialize array of albums 
	$albums = array();

	// Loop through the lines of the file 
	if (filesize($file_name) != 0) {
		while (!feof($file_pointer)) {
			// Read line
			$line = fgets($file_pointer);

			// Get content of line into array
			$album = explode("\t", $line);

			// Trim any \n
			if(!empty($album)) {
				$album[5] = rtrim($album[5]);

				$albums[] = $album;
			}
		}
	}

	unset($album);
	unset ($line);
	fclose($file_pointer);

	// Notify user of error in reading file 
	if (!is_array($albums)) {
		print("<p class=\"message\"There was an error reading the file $data_file_name</p>");
		exit;
	}

	// Initialize update variable 
	$update = false; 

	// Check if add button was pressed 
	if (isset($_POST["add"])) {

		// Filter inputs 
		$album_name = filter_input(INPUT_POST, 'album_name', FILTER_SANITIZE_STRING);
		$artist_name = filter_input(INPUT_POST, 'artist_name', FILTER_SANITIZE_STRING);
		$single_name = filter_input(INPUT_POST, 'single_name', FILTER_SANITIZE_STRING);

		if (!filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT)) {
			print ("<p class=\"message\">Not a valid integer. Could not add entry.</p>");
		} else {
			$year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
		}

		$certification = filter_input(INPUT_POST, 'certification', FILTER_SANITIZE_STRING);
		$awards = filter_input(INPUT_POST, 'awards', FILTER_SANITIZE_STRING);

		// Make sure required fields are inputted and year is correct 
		if ((!empty($album_name)) && (!empty($artist_name)) && (!empty($year)) && (!empty($year))) {
			$hiphop_time_check = (1973 <= $year && $year <= 2017);
			if (is_int($year)) {
				if ($hiphop_time_check) {
					// Store contents of entries into array
					$new_album = array($album_name, $artist_name, $single_name, $year, $certification, $awards);
					$albums[] = $new_album;

					$update = true;
					
				} else {
					print ("<p class=\"message\">Not a valid year! Hip-Hop was born in 1973. Could not add entry.</p>");
				}		 
			 }
		}
	}

	$reset_update = false; 

	if (isset($_POST["reset"])) {
		$fname = fopen($file_name, "w+");
		fclose($fname);
		$albums = array();
		$reset_update = true;
	}

	// If catalog should be updated 
	if ($update || $reset_update) {
		$file_pointer = fopen($file_name,'w');

		// Notify user if file could not be opened 
		if (!$file_pointer) {
			print( "<p class=\"message\"Could not open $file_name for writing.</p>");
			exit;
		}

		// Initialize array of lines
		$lines = array();

		// Put line in albums 
		foreach($albums as $album) {
			$new_line = implode("\t", $album);
			$lines[] = $new_line;
		}

		// Put new line 
		$each_line = implode("\n", $lines);

		// Write line into file 
		fputs($file_pointer, $each_line);

		// Close file 
		$closed = fclose($file_pointer);

		// Notify user if the add was successful 
		if ($update) {
			if ($closed) {
				print ("<p class=\"message\">The album has been successfully added</p>");
			} else {
				print ("<p class=\"message\">Failed to add the album to catalog</p>");
			}
		}

		if ($reset_update) {
			if ($closed) {
				print ("<p class=\"message\">The catalog has been reset</p>");
			} else {
				print ("<p class=\"message\">Failed to reset catalog</p>");
			}
		}

	}

	// Initialize search array 
	$searchAlbums = array(); 

	// Check if user wants to search 
	if (isset($_POST["search"])) {

		// Filter inputs 
		$album_name = filter_input(INPUT_POST, 'album_name', FILTER_SANITIZE_STRING);
		$artist_name = filter_input(INPUT_POST, 'artist_name', FILTER_SANITIZE_STRING);
		$single_name = filter_input(INPUT_POST, 'single_name', FILTER_SANITIZE_STRING);


		$certification = filter_input(INPUT_POST, 'certification', FILTER_SANITIZE_STRING);
		$awards = filter_input(INPUT_POST, 'awards', FILTER_SANITIZE_STRING);


		// Make sure numbers are valid 
		if ((!empty($_POST["year"])) && (!filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT))) {
			print ("<p class=\"message\">Not a valid integer. Could not search entry.</p>");
		} else {
			$year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
		}

		// Initialize array of search fields 
		$searchFields = array($album_name, $artist_name, $single_name, $year, $certification, $awards);

		// Go through each album and check if its contents match any of the search fields 
		foreach ($albums as $albumindex => $album) {
			$match = 1;
			foreach ($searchFields as $elementIndex => $element) {
				if (!empty($element)) {
					$element = trim($element);
					$match = $match && (strtolower($element) == strtolower($album[$elementIndex]));
				}
			}
			// If there is a match, add to search array 
			if ($match) {
				$searchAlbums[] = $album;
			}
		}

		// If the search array has contents, print them into table. 
		if (empty($searchAlbums)) {
			print("<p class=\"message\">There were no results found</p>");
		} else {
			print("<p class=\"message\">Here are your results</p>");

			print '<div id="search_table">
				<h1 class="table_title">Search Results</h1>
				<table>
				<thead>
					<tr>
					<th class="bigger_cell">Album Name</th>
					<th class="bigger_cell">Arist</th>
					<th class="bigger_cell">Single</th>
					<th class="smaller_cell">Year</th>
					<th class="smaller_cell">RIAA</th>
					<th class="smaller_cell">Awards</th>
				</thead>
				</tr>';

				print '<tbody>';
				foreach ($searchAlbums as $albumindex => $album) {
					print("<tr>");
						foreach ($album as $elementIndex => $element) {
							$safe_element = htmlentities($element);
							print("<td>$safe_element</td>");
						}
						print("</tr>");
					}
				print '</tbody>
					</table>
				</div>';
		}
	}
?>

<!-- Construct table for catalog -->
<div id="add_table">
	<h1 class="table_title">Catalog</h1>
	<table>
		<thead>
			<tr>
				<th class="bigger_cell">Album Name</th>
				<th class="bigger_cell">Arist</th>
				<th class="bigger_cell">Single</th>
				<th class="smaller_cell">Year</th>
				<th class="smaller_cell">RIAA</th>
				<th class="smaller_cell">Awards</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($albums as $albumindex => $album) {
					print("<tr>");
						foreach ($album as $elementIndex => $element) {
							$safe_element = htmlentities($element);
							if (strpos($element, "'")) {
								print("<td>$element</td>");
							} else{
								print("<td>$safe_element</td>");
							} 
							
						}
						print("</tr>");
					}
			?>
		</tbody>
	</table>
</div>

<!-- Make button for reset -->
	<div class="button">
		<form method="post" action="index.php">
			<input type="submit" name="reset" value="Reset">
		</form>
	</div>

</body>
</html>