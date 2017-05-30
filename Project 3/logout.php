<?php session_start();?>

<?php
	$page_title = 'Log Out';
	include_once('./includes/header.php');	
?>

<body>
	
	<?php
		include_once('./includes/navbar.php');
	?>

	<div class="form">
	      <!--Saves information from the current user to greet them and unsets it-->
     <?php
     	if (isset($_SESSION['logged_user'])) {
     		$olduser = $_SESSION['logged_user'];
     		unset($_SESSION['logged_user']);
     	} else {
     		$olduser = false;
        }

        if ( $olduser ) {
          print("<p class=\"message\">Thank you for using our albums, $olduser!</p>");
          print("<p class=\"message\"><a href='login.php'>Log in</a> to edit photos and albums!</p>");
        } else {
          print("<p class=\"message\">You have not logged in yet. <br><br> <a href='login.php'>Log in here</a></p>");
        }
      ?>
     </div>
</body>
