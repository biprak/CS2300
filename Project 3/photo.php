<?php
  session_start();
?>

<?php
	$page_title = 'Photo';
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

		if (!empty($_GET["photo_id"]) && !filter_var($_GET["photo_id"], FILTER_VALIDATE_INT) === false) {
			$photo_id = $_GET["photo_id"];

			// get all photos
			$result = $mysqli->query("SELECT * FROM Photos WHERE photo_id = '$photo_id';");

			 //no result
          	if (!$result) {
          		print($mysqli->error);
            	exit();
            }

            if(mysqli_num_rows($result)==0){
            	echo"<p class=\"message\">No such file exists</p>";
            }


			while ( $row = $result->fetch_assoc() ) {

				//determine title
            	if(strlen($row['title'])==0) {
             		$title = 'Untitled';
            	}
            	else {
              		$title = $row[ 'title' ];
            	}

            	//determines caption
            	if(strlen($row['caption'])==0) {
             		$caption = 'No caption';
            	}
            	else {
              		$caption = $row[ 'caption' ];
            	}

            	//determines author
            	if(strlen($row['author'])==0) {
             		$author = 'Author unknown';
            	}
            	else {
              		$author = $row[ 'author' ];
            	}

            	$file_name = $row[ 'file_name' ];

            	print "<div class=\"show_photo\">";
            	print "<p class=\"photo_title\">$title</p>";
            	print "<img src=\"$file_name\" alt=\"picture\">";
            	print "<p class=\"photo_info\">Author: $author </p>";
            	print "<p class=\"photo_info\">Caption: $caption </p>";
            	print "<p class=\"photo_info\">In Albums: ";

            	//sql query to get the albums that this picture is in
              	$sql = "SELECT title
              	FROM PhotosInAlbum INNER JOIN Albums ON Albums.album_id = PhotosInAlbum.album_id
              	WHERE PhotosInAlbum.photo_id = '$photo_id';";

              	//Get  data
              	$result2 = $mysqli->query($sql);
                
              	//no result
              	if (!$result2) {
                	print($mysqli->error);
                	exit();
                }

                //prints out the corresponding albums in a list
                while ($row2 = $result2->fetch_row()) {
                	foreach( $row2 as $value ) {
                		echo "<li>$value</li>";
                	}
                }


            	print "</div>";




			}

			if (!isset($_SESSION['logged_user'])) {
				echo ("<div class=\"form\">
				<p class=\"message\">Log in to edit this photo!</p>
				</div>");
			} 

			else {
				echo '
				<form class="form" method="post">
				<p class="title">Photo Edit</p>

				<p><label>New Title:</label> <input type="text" name="new_title" maxlength="100" /></p>
				<p><label>New Author:</label> <input type="text" name="new_author" maxlength="100" /></p>
				<p><label>New Caption:</label><textarea name="new_caption" rows="4" maxlength="1000"></textarea></p>

				<input type="submit" name="edit" value="Edit" />
				</form>'; 
			}
		}

		if (!empty($_POST['edit'])) {
			//filter the inputs
            $new_title = filter_input(INPUT_POST, 'new_title', FILTER_SANITIZE_STRING);
            $new_author = filter_input(INPUT_POST, 'new_author', FILTER_SANITIZE_STRING);
            $new_caption = filter_input(INPUT_POST, 'new_caption', FILTER_SANITIZE_STRING);

            $photo_id = $_GET["photo_id"];

            //initialize variables
			$old_title;
			$old_description;

            $result = $mysqli->query("SELECT * FROM Photos WHERE photo_id = '$photo_id' ;");

           	while ( $row = $result->fetch_assoc() ) {
				$old_title = $row[ 'title' ];
				$old_caption = $row[ 'caption' ];
				$old_author = $row[ 'author' ];
			}

            if (strlen($new_title) == 0) {
            	$new_title = $old_title;
            }

            if (strlen($new_author) == 0) {
            	$new_author = $old_author;
            }

            if (strlen($new_caption) == 0) {
            	$new_caption = $old_caption;
            }

            $sql = "UPDATE Photos SET title = '$new_title', caption = '$new_caption', author = '$new_author'
             WHERE photo_id = $photo_id;";

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

		?>
</body>


