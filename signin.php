<?php

require_once 'scripts/database_connection.php';
require_once 'scripts/view.php';

$error_message = $_REQUEST['error_message'];

session_start();

//if the user is logged in, the user_id session will be set
if(!isset($_SESSION['user_id'])) {

	//get db connection
	$connection = new ConnectdB();
	$connection->connect();

	// See if a login form was submitted with a username for login
	if(isset($_POST['username'])) {
		// Try and log the user in
		$username = mysqli_real_escape_string(trim($_REQUEST['username']));
		$password = mysqli_real_escape_string(trim($_REQUEST['password']));

		//look up the user
		$query = sprintf("SELECT user_id, username FROM user "
				. "WHERE username = '%s' "
				. "AND password = '%s';"
				, $username
				, crypt($password, $username));

		if(!$results = $connection->my_conn->query($query)){
			handle_error('There was an error running the query.', $connection->my_conn->error);
		}
			
		if ($results->num_rows == 1) {
			while ($result = $results->fetch_assoc()) {
				$user_id = $result['user_id'];
				setcookie('user_id', $user_id);
				setcookie('username', $result['username']);
				header("Location: profile.php");
				exit();
			}
		} else {
			//if user not found, issue an error
			$error_message = "Your username/password combination was invalid.";
		}

	}
	// Still in the "not signed in" part of the if statement
	// Start the page, and we know there's no success or error message
	// since they're just logging in
	//
	$svr_php_self = $_SERVER['PHP_SELF'];
	if (isset($username)) {
		$sply_username = sprintf(" value='%s'",$username);
	}
	display_pagetop("Sign In", NULL, $_REQUEST['success_message'], $_REQUEST['error_message'], $_REQUEST['warning_message']);
} else {
	// Now handle the case where they're logged in
	header("Location: profile.php");
	exit();
}
?>

<div id="yui-main">
	<div class="yui-b">
		<div class="yui-g">
			<!-- Signin Form -->
			<div class="block">
				<div class="hd">
					<h2>Login to Process Oriented Project Management</h2>
				</div>
				<div class="bd">
					<h3>Sign In</h3>
					<form id="signin_form" action="signin.php" method="POST">
						<p>
							<label for="username">Username:</label>
							<input type="text" name="username" id="username" size="20" <?php echo $sply_username; ?> />
						</p>
						<p>
							<label for="password">Password:</label>
							<input type="password" name="password" id="password" size="20" />
						</p>
						<p><input type="submit" value="Sign In" /></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	display_rest_of_page();
?>