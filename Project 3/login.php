<?php session_start();?>

<?php
	$page_title = 'Log In';
	include_once('./includes/header.php');	
?>

<body>
	<?php
		include_once('./includes/navbar.php');

	//check if user logged in
	if (isset($_SESSION['logged_user'])) {
		$logged_user = $_SESSION[ 'logged_user' ];
		print "<p class=\"message\">You are logged in, $logged_user !</p>";
	}
	//else if not logged in
	else {
		// empty fields
		if (empty($_POST['username']) || empty($_POST['password'])) {
			echo '
			<div id="login_form" class="form"> 
				<form method="post" action="login.php">
				<h2 class="title">Log In</h2>
				<br>
					<div class="input">
						<label>Username: </label>
						<input type="text" name="username" maxlength="34" required> 
					</div>
					<br>
					<div class="input">
						<label>Password: </label>
						<input type="text" name="password" maxlength="128" required> 
					</div>
					<div class="button">
						<input type="submit" name="submit" value="Log in">
					</div>
				</form>
			</div>
			';
		}
		// if valid username and password were inputted
		else {
			// validate username and password
			$post_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
			$post_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

         	require_once 'includes/config.php';

          	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

         	if ($mysqli->errno) {
            	print($mysqli->error);
            	exit();
          	}

          	//gets the username and password for prepared statement checks
          	$username = $post_username;
          	$password = hash( "sha256", $post_password);

			$query = "SELECT * FROM users WHERE username = '$username' AND hashpassword = '$password'; ";
			$result = $mysqli->query($query);

			// check user is in databse
			if ($result && $result->num_rows == 1) {
				$row = $result->fetch_assoc();

				$hash_password = $row[ 'hashpassword' ];

            	// if passwords match, start session
            	if( $password === $hash_password) {
              		$db_username = $row['username'];
              		$db_name = $row['name'];
              		$_SESSION['logged_user'] = $db_name;
            	}
			}
			//not in database
			else {
				echo '<p class="message">No such user or password found. Please <a href="login.php">try</a> again.</p>';
			}

			if ( isset($_SESSION['logged_user'] ) ) {
            	print("<p class=\"message\">Congratulations, $db_name. You have been logged in!<p>");
            	print("<p class=\"message\">You can now add and edit your photos and albums!</p>");
          	} 

			$mysqli->close();
		}

	}

	?>
</body>