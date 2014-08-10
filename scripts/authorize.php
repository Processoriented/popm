<?php

require_once 'database_connection.php';
require_once 'app_config.php';

session_start();

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

	// Set up the query string
	$query_string = "SELECT ug.user_id " .
					"FROM user_groups ug, groups g " .
					"WHERE g.name = '%s' " .
					"AND g.id = ug.group_id " .
					"AND ug.user_id = " .
					mysql_real_escape_string($_SESSION['user_id']);

	foreach ($groups as $group) {
		// do a SQL search for the current $group
		$query = sprintf($query_string, mysql_real_escape_string($group));
		$result = mysql_query($query);

		if (mysql_num_rows($result) == 1) {
			// user is allowed access
			return;
		}
	}
	// If we get here then no matches were found for any group...
	handle_error("You are not authorized to see this page.");
}

function user_in_group($user_id, $group) {
	$query_string = "SELECT ug.user_id " .
					"FROM user_groups ug, groups g " .
					"WHERE g.name = '%s' " .
					"AND g.id = ug.group_id " .
					"AND ug.user_id = %d";
	$query = sprintf($query_string, mysql_real_escape_string($group),
					mysql_real_escape_string($user_id));
	$result = mysql_query($query);

	if (mysql_num_rows($result) == 1) {
		return true;
	} else {
		return false;
	}
}

?>