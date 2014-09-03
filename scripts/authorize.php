<?php

require_once 'database_connection.php';
require_once 'app_config.php';

if (!isset($_SESSION)) { session_start(); }

function authorize_user($groups = NULL) {
	// No need to check groups if there aren't any sessions set
	if ((!isset($_SESSION['user_id'])) || (!strlen($_SESSION['user_id']) > 0)) {
		header('Location: signin.php?error_message=You must login to see this page.');
		exit();
	}

	// If no groups passed in, the authorization above is enough
	if ((is_null($groups)) || (empty($groups))) {
		return;
	}

	$conn = con_POPM_dB::getInstance();
	// Set up the query string
	$query_string = "SELECT ug.user_id " .
					"FROM user_group ug, `group` g " .
					"WHERE g.name = '%s' " .
					"AND g.id = ug.group_id " .
					"AND ug.user_id = " .
					$conn->real_escape_string($_SESSION['user_id']);

	foreach ($groups as $group) {
		// do a SQL search for the current $group
		$query = sprintf($query_string, $conn->real_escape_string($group));
		$results = $conn->query($query);

		if ($results->num_rows == 1) {
			// user is allowed access
			return;
		}
	}
	// If we get here then no matches were found for any group...
	handle_error("You are not authorized to see this page.");
}

function user_in_group($user_id, $group) {
	$conn = con_POPM_dB::getInstance();
	$query_string = "SELECT ug.user_id " .
					"FROM user_group ug, `group` g " .
					"WHERE g.name = '%s' " .
					"AND g.id = ug.group_id " .
					"AND ug.user_id = %d ";
	$query = sprintf($query_string, $conn->real_escape_string($group),
					$conn->real_escape_string($user_id));
	$result = $conn->query($query);

	if ($result->num_rows == 1) {
		return true;
	} else {
		return false;
	}
}

?>