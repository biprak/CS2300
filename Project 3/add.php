<?php
  session_start();
?>

<?php
	$page_title = 'Contribute';
	include_once('./includes/header.php');	
?>

<body>

	<?php
		include_once('./includes/navbar.php');

		if (!isset($_SESSION['logged_user'])) {
			echo ("<div class=\"form\">
				<p class=\"message\">You do not have sufficient permission to access these features. Please log in.</p>");
		} 
		else {

		//Display the POST data for debugging
		//echo '<pre>' . print_r( $_POST, true ) . '</pre>';
		
		//Get the $fields variable, which is in a separate file in order to share with index.php
		require_once "includes/settings.php";
		
		//Try to get the movie_id from a URL parameter
		$album_id = filter_input( INPUT_GET, 'album_id', FILTER_SANITIZE_NUMBER_INT );
		if( empty( $album_id ) ) {
			//Try to get it from the POST data (form submission)
			$album_id = filter_input( INPUT_POST, 'album_id', FILTER_SANITIZE_NUMBER_INT );
		}

		$message = '';
		//Get the connection info for the DB. 
		require_once 'includes/config.php';

		//Establish a database connection
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if ($mysqli->errno) {
			print "<p class=\"message\">$mysqli->error</p>";
			exit();
		}

		//Was the "Save" button clicked?
		if( ! empty( $_POST[ 'add' ] ) ) {
			//Try to retrieve values from the POST data

			//Initialize an array to hold field values found in the $_POST data
			$field_values = array();
			
			//Loop through the expected fields
			foreach( $fields as $field ) {
				$field_name = $field[ 'term' ];
				$filter = $field[ 'filter' ];
				
				//Does this term exist in the POST data submitted by the add/edit movie form?
				if( !empty( $_POST[ $field_name ] ) ) {
					//Get the value for this term from the POST data
					$field_value = filter_input( INPUT_POST, $field_name, $filter );
					
					//Store the field values
					$field_values[ $field_name ] = $field_value;
				}
			}

			//Is this a new movie being added?
			if( empty( $album_id ) ) {
				//add 
				if( empty( $field_values['title'] )  ) {
					$message .= '<p class="message">Album not added. Title and Date Created are required.</p>';
				} else {
					//debugging
					//echo '<pre>' . print_r( $field_values, true ) . '</pre>';
					
					//Get an array of the field names that have data
					$field_name_array = array_keys( $field_values );
					
					//Comma delimited list of fields
					//equivalent to $field_list = "title, year, length";
					$field_list = implode( ',', $field_name_array );

					$field_list = $field_list.", date_created";
					
					//comma delimited list of values - need quotes around values
					$value_list = implode( "','", $field_values );
					$date = date("Y-m-d"); 
					$str = "', '$date";

					$value_list = $value_list.$str;
					
					//Build the SQL for adding a movie - later we'll improve security and quoting
					$sql = "INSERT INTO Albums ( $field_list ) VALUES ( '$value_list' );";
				}
				
			} else { 
				//update
				$update_fields = array();
				if( empty( $field_values['title'] ) || empty( $field_values['date_created'] ) ) {
					$message .= '<p class="message">Album not updated. Title and Date Created are required.';
				} else {
					foreach( $field_values as $field_name => $field_value ) {
						$update_fields[] = "$field_name = '$field_value'";
					}
					$sets = implode( ', ', $update_fields );
					
					//Build the SQL for adding a movie - later we'll improve security and quoting
					$sql = "UPDATE Albums SET $sets WHERE album_id=$album_id";
					
				}
			}

			//Anything to save?
			if( ! empty( $sql ) ) {
				if( $mysqli->query($sql) ) {
					$message .= '<p class="message">Album Saved.</p>';
					
					//Was this an "add"?
					if( empty( $album_id ) ) {
						//Get the primary key of the newly added movie
						$album_id = $mysqli->insert_id;
					}
				} else {
					$message .= "<p class=\"message\">Error saving Album.</p>";
				}
				
			}
		}

		$db_values = array();
		//Anything to load?
		if( ! empty( $album_id ) ) {
			//Load values from the db
			$sql_load = "SELECT * FROM Albums WHERE album_id=$album_id";
			$result = $mysqli->query($sql_load);
			if( $result ) {
				$row = $result->fetch_assoc();
				$db_values['title'] = $row['title'];
				$db_values['description'] = $row['description'];
				
			} else {
				$message .= "Couldn't load album from the database.$mysqli->error";
				$db_values['title'] = 'The Bronx';
				$db_values['description'] = '';
			}
			
		} else {
			//Nothing to load
			$db_values['title'] = '';
			$db_values['description'] = '';
		}

		if( empty( $album_id ) ) {
			$action = 'Add';
		} else {
			$action = 'Edit';
		}
		
		print $message;
		
		if( ! empty( $sql ) ) {
			$html_safe_sql = htmlentities( $sql );
			//print( "<p class=\"message\">SQL query <br>$html_safe_sql</p>");
		}

		//Start a form that submits to this same page
		print '<form method="post" class="form">';
			//If there is a movie_id then this is an edit form and needs a hidden field
				//for the primary key so that the UPDATE query knows which record to update
		print ('<p class="title">Add Album</p>');
			if( !empty( $album_id ) ) {
				print("<input type='hidden' name='album_id' value='$album_id'>");
			}
			
			//The fields
			foreach ( $fields as $field ) {
				$term = $field['term'];
				$field_heading = $field['heading'];
				$field_value = $db_values[$term];
				
				print("<p><label>$field_heading</label><input type='text' name='$term' value='$field_value'></p>");
			}
			
			//Submit / Save
			print("<input type='submit' name='add' value='Add'>");
		print '</form>';
	?>

	<form method="post" enctype="multipart/form-data" class="form">
		<p class="title">Upload Image</p>
		<br>
		<label>Single photo upload:</label><input type="file" name="newphoto" required /><br />
		<br><br>


		<p class="title">Photo Info</p>
		<p><label>Title:</label> <input type="text" name="photo_title" maxlength="100" /></p>
		<p><label>Author:</label> <input type="text" name="photo_author" maxlength="100" /></p>
		<p><label>Caption:</label> <input type="text" name="photo_caption" maxlength="1000" /></p>

		<p class="title">Album Selection</p><br>
		<?php

		$result = $mysqli->query("SELECT * FROM Albums;");

		while ( $row = $result->fetch_assoc() ) {
			$title = $row[ 'title' ];
			$album_id = $row['album_id'];

			print ("<input type=\"checkbox\" name=\"album_choice[]\" value=$album_id>$title<br>"
				);
		}
		?>
		<input type="submit" value="Upload photo" />
	</form>

	<form method="post" class="form">
		<p class="title">Edit Albums</p>
		<br>
		<p><label>Choose Album<label></p>

		<select name="album_edit">
		<?php

		$result = $mysqli->query("SELECT * FROM Albums;");

		while ( $row = $result->fetch_assoc() ) {
			$old_title = $row[ 'title' ];
			$old_description = $row[ 'description' ];
			$album_id = $row['album_id'];

			print ("<option value=$album_id>$old_title</option>"
				);
		}
		?>
		</select>

		<p><label>New Title:</label> <input type="text" name="new_album_title" maxlength="75" /></p>
		<p><label>New Description:</label><textarea name="new_description" rows="4" maxlength="1000"></textarea></p>
		<br>
		<input type="submit" name="edit" value="Edit" />
		<input type="submit" name="delete" value="Delete" />
	</form>


	<?php
		$photo_id; 
		$title = ''; 
		$author = ''; 
		$caption = ''; 
		print '<pre style="display:none;">' . print_r( $_FILES, true ) . '</pre>';
		if ( ! empty( $_FILES[ 'newphoto' ] ) ) {
			$newPhoto = $_FILES[ 'newphoto' ];
			$originalName = $newPhoto[ 'name' ];
			if ( $newPhoto[ 'error' ] == 0 ) {
				$tempName = $newPhoto[ 'tmp_name' ];
				$file_name = "images/uploaded/$originalName";
				move_uploaded_file( $tempName, $file_name);
				$_SESSION['photos'][] = $originalName;
				print("<p class=\"message\">The file $originalName was uploaded successfully.</p>");

				if (!empty($_POST['photo_title'])){
					 $title= $_POST['photo_title'];
				} 

				if (!empty($_POST['photo_author'])){
					 $author= $_POST['photo_author'];
				} 

				if (!empty($_POST['photo_caption'])){
					 $caption= $_POST['photo_caption'];
				} 

				$sql = "INSERT INTO Photos (title, author, caption, file_name) VALUES ('$title', '$author', '$caption', 'images/uploaded/$originalName')";

				if( ! empty( $sql ) ) {
					if( $mysqli->query($sql) ) {
						$message .= '<p class="message">Album Saved.</p>';
					
						//Was this an "add"?
						if( empty( $photo_id ) ) {
						//Get the primary key of the newly added movie
							$photo_id = $mysqli->insert_id;
						}
					} else {
						$message .= "<p class=\"message\">Error saving picture in database.</p>";
					}
				}


			} else {
				print("<p class=\"message\">Error: The file $originalName was not uploaded.</p>");
			}
		}

		//http://stackoverflow.com/questions/14543050/foreach-checkbox-post-in-php
		if (!empty($_POST['album_choice'])) {
			foreach($_POST['album_choice'] as $value) {
				$sql = "INSERT INTO PhotosInAlbum (photo_id, album_id) VALUES ('$photo_id','$value')";


				if( $mysqli->query($sql) ) {
					$message .= '<p>Album Saved.</p>';
					
						//Was this an "add"?
					if( empty( $photo_id ) ) {
						//Get the primary key of the newly added movie
						$photo_id = $mysqli->insert_id;
					}
				} else {
					$message .= "<p class=\"message\">Error saving picture in database.</p>";
				}
			}
		}

		if (!empty($_POST['edit'])) {
			//filter the inputs
            $new_title = filter_input(INPUT_POST, 'new_album_title', FILTER_SANITIZE_STRING);
            $new_description = filter_input(INPUT_POST, 'new_description', FILTER_SANITIZE_STRING);

            $album_id = $_POST['album_edit'];

            $date = date("Y-m-d"); 

            //initialize variables
			$old_title;
			$old_description;

            $result = $mysqli->query("SELECT * FROM Albums WHERE album_id = '$album_id' ;");

           	while ( $row = $result->fetch_assoc() ) {
				$old_title = $row[ 'title' ];
				$old_description = $row[ 'description' ];
				$album_id = $row['album_id'];
			}

            if (strlen($new_title) == 0) {
            	$new_title = $old_title;
            }

            if (strlen($new_description) == 0) {
            	$new_description = $old_description;
            }

            $sql = "UPDATE Albums SET title = '$new_title', description = '$new_description', date_modified = '$date'
             WHERE album_id = $album_id;";

            $result = $mysqli->query($sql);

            if (!$result) {
            	print($mysqli->error);
                exit();
            }
            else{
           		 //updates the last time the album was modified
                echo "<p class=\"message\">Changes saved!</p>";
            }

		}

		if (!empty($_POST['delete'])) {
			$album_id = $_POST['album_edit'];
			print $album_id;

			// delete album from database
			$sql = "DELETE FROM Albums WHERE album_id = $album_id;";

			$result = $mysqli->query($sql);

			//If no result, print the error
            if (!$result) {
              print($mysqli->error);
              exit();
            }
            else {
            	print ("<p class=\"message\">The selected album has been deleted!</p>");
            }
		}

	}


	?>


</body>