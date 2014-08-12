<?php

require_once 'scripts/app_config.php';
require_once 'scripts/database_connection.php';
require_once 'scripts/view.php';

$error_message = isset($_REQUEST['error_message']) ? $_REQUEST['error_message'] : NULL;
$success_message = isset($_REQUEST['success_message']) ? $_REQUEST['success_message'] : NULL;
$warning_message = isset($_REQUEST['warning_message']) ? $_REQUEST['warning_message'] : NULL;

//get db connection
$conn = con_POPM_dB::getInstance();

//Check to see if the user has already completed the form...
if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
	//check if the requested username is already in use
	$username = $conn->real_escape_string(trim($_REQUEST['username']));
	$password = $conn->real_escape_string(trim($_REQUEST['password']));

	$query = sprintf("SELECT username FROM users "
				. "WHERE username = '%s' "
				. "AND password = '%s';"
				, $username
				, crypt($password, $username));

	if(!$results = $conn->query($query)){
		handle_error('There was an error running the query.', $conn->error);
	}
	//This query should return no results, so if it does, then the user
	//has created a new profile with the same credentials as before.
	if ($results->num_rows == 1) {
		while ($result = $results->fetch_assoc()) {
			$user_id = $result['user_id'];
			setcookie('user_id', $user_id);
			setcookie('username', $result['username']);
			header("Location: profile.php");
			exit();
		}
	} else {
		//Now check if a different user has the same requested username
		$query = sprintf("SELECT username FROM user "
						. "WHERE username = '%s' "
						. "AND password <> '%s';"
						, $username
						, crypt($password, $username));
		$results->free();
		if(!$results = $conn->query($query)){
			handle_error('There was an error running the query.', $conn->error);
		}
		if ($results->num_rows == 1) {
			$error_message = "The username {$username} is already in use.";
		} else {
			$results->free();
			//finally create the user
			$upload_dir = HOST_WWW_ROOT . "uploads/profile_pics/";
			$image_fieldname = "user_pic";

			//Potential PHP upload errors
			$php_errors = array(1 => 'Maximum file size in php.ini exceeded'
			,       2 => 'Maximum file size in HTML form exceeded'
			,       3 => 'Only part of the file was uploaded'
			,       4 => 'No file was selected to upload.'
			,       6 => 'Missing a temporary folder'
			,       7 => 'Failed to write file to disk'
			,       8 => 'A PHP Extension stopped the file upload.'
			);

			$first_name = trim($_REQUEST['first_name']);
			$last_name = trim($_REQUEST['last_name']);
			$username = trim($_REQUEST['username']);
			$password = trim($_REQUEST['password']);
			$email = trim($_REQUEST['email']);
			$bio = trim($_REQUEST['bio']);
			$facebook_url = str_replace("facebook.org", "facebook.com", trim($_REQUEST['facebook_url']));
			$position = strpos($facebook_url, "facebook.com");
			if ($position === false) {
			  $facebook_url = "http://www.facebook.com/" . $facebook_url;
			}

			$twitter_handle = trim($_REQUEST['twitter_handle']);
			$twitter_url = "http://www.twitter.com/";
			$position = strpos($twitter_handle, "@");
			if ($position === false) {
			  $twitter_url = $twitter_url . $twitter_handle;
			} else {
			  $twitter_url = $twitter_url . substr($twitter_handle, $position + 1);
			}
			
			$linkedin_url = trim($_REQUEST['linkedin_url']);
			$position = strpos($linkedin_url, "linkedin.com/in/");
			if ($position === false) {
			  $linkedin_url = "http://www.linkedin.com/in/" . $linkedin_url . "/";
			}

			// Make sure we didn't have an error uploading the image
			($_FILES[$image_fieldname]['error'] == 0)
				or handle_error("The server couldn't upload the image you selected."
				, $php_errors[$_FILES[$image_fieldname]['error']]);

			// Is this file the result of a valid upload?
			@is_uploaded_file($_FILES[$image_fieldname]['tmp_name'])
				or handle_error("You were tryin to do something naughty. Shame on you!",
				"Uploaded request : file named " .
				"'{$_FILES[$image_fieldname]['tmp_name']}'");

			// Is this actually an image?
			@getimagesize($_FILES[$image_fieldname]['tmp_name'])
				or handle_error("you selected a file for your picture that isn't an image."
				,"{$_FILES[$image_fieldname]['tmp_name']} isn't a valid image file.");

			// Name the file uniquely
			$now = time();
			while (file_exists($upload_filename = $upload_dir . $now . '-' . $_FILES[$image_fieldname]['name']))
				{
					$now++;
				}

			//Make sure that the upload directory exists and is writable
			@file_exists($upload_dir)
				or handle_error("Upload Directory does not exist","{$upload_dir} does not exist.");

			@is_writable($upload_dir)
				or handle_error("Upload Directory is not writable","{$upload_dir} not writable.");

			// Finally, move the file to its permanent location
			@move_uploaded_file($_FILES[$image_fieldname]['tmp_name'], $upload_filename)
				or handle_error("We had a problem saving your image."
					,"permissions or related error moving file to {$upload_filename}.");



			$insert_sql = sprintf("INSERT INTO users (username,password,bio) "
							. "VALUES ('%s', '%s', '%s');"
							, $conn->real_escape_string($username)
							, $conn->real_escape_string(crypt($password, $username))
							, $conn->real_escape_string($bio));
							
			if(!$results = $conn->query($insert_sql)){
				handle_error('There was an error inserting your profile.'
					, 'Error Message: ' . $conn->error);
			}
			$iid = $conn->insert_id;
			if(!$iid > 0) {
				handle_error('There was an error inserting your profile.'
					, 'Error Message: No record inserted');
			}
			$results->free();
							
			//Check if there's already a resource with the same email address or social id
			$sql = sprintf("SELECT id FROM resource WHERE email = '%s' OR ( email IS NULL AND (facebook_id = '%s' OR twitter_id = '%s' OR linkedin_id = '%s'));"
					, $conn->real_escape_string($email)
					, $conn->real_escape_string($facebook_url)
					, $conn->real_escape_string($twitter_url)
					, $conn->real_escape_string($linkedin_url));
			
			if(!$results = $conn->query($sql)){
				handle_error('There was an error inserting your profile.'
					, 'Error Message: ' . $conn->error);
			}
			if ($results->num_rows > 0) {
				$sql = sprintf("UPDATE resource "
						. "SET first_name = '%s' "
						. ",last_name = '%s' "
						. ",user_id = %d "
						. ",image_url = '%s' "
						. ",facebook_id = '%s' "
						. ",twitter_id = '%s' "
						. ",linkedin_id = '%s' "
						. "WHERE id IN ("
						, $conn->real_escape_string($first_name)
						, $conn->real_escape_string($last_name)
						, $iid
						, $conn->real_escape_string($facebook_url)
						, $conn->real_escape_string($twitter_url)
						, $conn->real_escape_string($linkedin_url)
						, $conn->real_escape_string($upload_filename));
				while ($row = mysqli_fetch_assoc($results)) {
					$sql = $sql . $row['id'] . ",";
				}
				$sql = substr($sql,0,-1) . ");";
			} else {
				$sql = sprintf("INSERT INTO resource (first_name,last_name,email,user_id,image_url,facebook_id,twitter_id,linkedin_id) "
						. "VALUES ('%s', '%s', '%s', %d, '%s', '%s', '%s', '%s');"
						, $conn->real_escape_string($first_name)
						, $conn->real_escape_string($last_name)
						, $conn->real_escape_string($email)
						, $iid
						, $conn->real_escape_string($facebook_url)
						, $conn->real_escape_string($twitter_url)
						, $conn->real_escape_string($linkedin_url)
						, $conn->real_escape_string($upload_filename));
			}
			$results->free();
									
			if(!$results = $conn->query($sql)){
				handle_error('There was an error inserting your profile.'
					, 'Error Message: ' . $conn->error);
			}
			$results->free();

			// Insert the user into the database


			// Redirect the user to the page that displays user information
			setcookie('user_id', $iid);
			setcookie('username', $username);
			header("Location: show_user.php");
			exit();
		}
	}
}

//if not then show the form and let them fill it in
// Setup the javascript
$account_scripts = <<<EOD

    <script>
        $(document).ready(function() {
            $("#signup_form").validate({
                rules: {
                    password: {
                        minlength: 6
                    },
                    confirm_password: {
                        minlength: 6,
                        equalTo: "#password"
                    }
                },
                messages: {
                    password: {
                        minlength: "Passwords must be at least 6 characters"
                    },
                    confirm_password: {
                        minlength: "Passwords must be at least 6 characters",
                        equalTo: "Your passwords do not match."
                    }
                }
            });
        });
    </script>

EOD;


$success_msg = (isset($_REQUEST['success_message'])) ? $_REQUEST['success_message'] : NULL;
$error_msg = (isset($_REQUEST['error_message'])) ? $_REQUEST['error_message'] : NULL;
$warn_msg = (isset($_REQUEST['warning_message'])) ? $_REQUEST['warning_message'] : NULL;

display_pagetop("User Signup", $account_scripts, $success_msg, $error_msg, $warn_msg);
?>
<!-- Signup Form -->
<div class="block">
	<div class="hd">
		<h2>User Information</h2>
	</div>
	<div class="bd">
		<h3>Sign Up for Process Oriented Project Management</h3>
		<form id="signup_form" action="signup.php" method="POST" enctype="multipart/form-data">
			<p>
				<label for="first_name">First Name:</label>
				<input type="text" name="first_name" size="20" class="required" />
			</p>
			<p>
				<label for="last_name">Last Name:</label>
				<input type="text" name="last_name" size="20" class="required" />
			</p>
			<p>
				<label for="username">Username:</label>
				<input type="text" name="username" size="20" class="required" />
			</p>
			<p>
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" size="20" class="required password" />
				<div class="password-meter">
					<div class="password-meter-message"></div>
					<div class="password-meter-bg">
						<div class="password-meter-bar"></div>
					</div>
				</div>							
			</p>
			<p>
				<label for="confirm_password">Confirm Password:</label>
				<input type="password" id="confirm_password" name="confirm_password" size="20" class="required" />
			</p>
			<p>
				<label for="email">E-Mail Address:</label>
				<input type="text" name="email" size="50" />
			</p>
			<p>
				<label for="linkedin_url">LinkedIn URL:</label>
				<input type="text" name="linkedin_url" size="50" />
			</p>
			<p>
				<label for="facebook_url">Facebook URL:</label>
				<input type="text" name="facebook_url" size="50" />
			</p>
			<p>
				<label for="twitter_handle">Twitter Handle:</label>
				<input type="text" name="twitter_handle" size="20" />
			</p>
			<p>
				<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
				<label for="user_pic">Upload a picture:</label>
				<input type="file" name="user_pic" size="30" />
			</p>
			<p>
				<label for="bio">Biography:</label>
				<textarea name="bio" cols="40" rows="10"></textarea>
			</p>
			<p><input type="submit" value="Submit" /> or <input type="reset" value="Clear and Restart" /></p>
		</form>
	</div>
</div>
<?php display_rest_of_page(); ?>