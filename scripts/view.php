<?php

require_once 'app_config.php';
require_once 'authorize.php';
require_once 'elements.php';

define("SUCCESS_MESSAGE", "notice");
define("ERROR_MESSAGE", "error");
define("WARNING_MESSAGE", "warning");

if (!isset($_SESSION)) { session_start(); }

function display_pagetop($title, $javascript = NULL, $success_message = NULL, $error_message = NULL, $warn_message = NULL) {
    display_head($title, $javascript);
    display_title($title, $success_message, $error_message);
}

function display_rest_of_page($title = "") {
	echo '</div>';
	echo '</div>';
	echo '</div>';
	display_sidebar($title);
	display_footer();
}

function new_display_head($page_title = 'POPM', $emb_js = NULL) {
	echo '<!DOCTYPE html>';
	$ttl = new dom_element('title',$page_title);
	$meta = new dom_element('meta', NULL, new html_attr('charset','utf-8'));
	
}

function display_head($page_title = "", $embedded_javascript = NULL) {
    
    echo <<<EOD
<!DOCTYPE html>
<html lang="US-en">
<head>
    <title>{$page_title}</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
    <link rel="stylesheet" href="css/reset-fonts-grids.css" type="text/css">
    <link rel="stylesheet" href="css/yuiapp.css" type="text/css">
    <link id="theme" rel="stylesheet" href="css/green.css" type="text/css">	
    <link href="css/jquery.validate.password.css" rel="stylesheet" />
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/popm.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/jquery.validate.password.js"></script>

EOD;
    if (!is_null($embedded_javascript)) {
        echo $embedded_javascript;
    }
    echo "\n\t</head>\n";
}

function display_title($title, $success_msg = NULL, $error_msg = NULL, $warn_msg = NULL) {
    echo <<<EOD
<body class="rounded">
    <div id="doc3" class="yui-t3">

        <div id="hd">
            <h1>Process Oriented Project Management</h1>
            <div id="navigation">
                <ul id="primary-navigation">
EOD;
	if (!isset($_SESSION['user_id'])) {
		if ($title == 'Sign In') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="signin.php">Sign In</a></li>';
		if ($title == 'User Signup') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="signup.php">Signup</a></li>';
	} else {
		if ($title == 'Project') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="project.php">Projects</a></li>';		
		if ($title == 'Resource') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="resource.php">Resources</a></li>';		
		if ($title == 'Calendar') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="calendar.php">Calendar</a></li>';
		echo '</ul>';
		echo '<ul id="user-navigation">';
		if (user_in_group($_SESSION['user_id'], "admin")) {		
			if ($title == 'Management') { echo '<li class="active">'; } else { echo '<li>'; }
			echo '<a href="management.php">Management</a></li>';
		}
		if ($title == 'Profile') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="profile.php">Profile</a></li>';
		if ($title == 'Settings') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="settings.php">Settings</a></li>';
		if ($title == 'Sign Out') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="signout.php">Logout</a></li>';
	}
	echo '</ul>';
	echo '<div class="clear"></div>';
	echo '</div>';
	echo '</div>';
	echo '<div id="bd">';
	display_messages($success_msg, $error_msg, $warn_msg);
	echo '<div id="yui-main">';
	echo '<div class="yui-b">';
	echo '<div class="yui-g">';
}

function display_messages($success_msg = NULL, $error_msg = NULL, $warn_msg = NULL) {
    if (!is_null($success_msg) && (strlen($success_msg) > 0)) {
        display_message($success_msg, SUCCESS_MESSAGE);
    }
    if (!is_null($error_msg) && (strlen($error_msg) > 0)) {
        display_message($error_msg, ERROR_MESSAGE);
    }
    if (!is_null($warn_msg) && (strlen($warn_msg) > 0)) {
        display_message($warn_msg, WARNING_MESSAGE);
    }
}

function display_message($msg, $msg_type) {
	$pcls[] = new html_attr('class', 'alert');
	$pcls[] = new html_attr('class', $msg_type);	
	$msg_p = new dom_element('p', $msg, $pcls);
	$msg_b = new dom_element('div', $msg_p->html_out, new html_attr('class', 'bd'));
	$msg_d = new dom_element('div', $msg_b->html_out, new html_attr('class', 'block'));
	echo $msg_d->html_out;
}

function about_popm() {
	$p[] = new block_p('This project is based on the idea that many of the processes involved in managing a project can be automated.');
	$p[] = new block_p('Figuring out whether a meeting is needed, who needs to attend the meeting, and what they need to contribute is a repetitive task that lends itself well to automation.  Likewise, meeting minutes, reminders, and other communications to all kinds of stakeholders should not be a manual task because it involves the same steps every time.');
	$p[] = new block_p('The result is a clean, intuitive project management platform including all the features you would expect and a high degree of automation. We hope you find it useful.');
	$ab = new block_body($p);
	return new block('pgm_desc', $ab, 'About POPM');
}
function display_sidebar($title) {
	$abl = about_popm();
    $sdbr = new sidebar($abl);
    echo $sdbr->html_out;
}

function display_footer() {
    echo "\t</div>\n";
    $sa = new dom_element('a','Processoriented.Guru', new html_attr('href','http://Processoriented.Guru'));
    $ftr_p = new dom_element('p', 'Copyright &copy; 2014 ' . $sa->html_out, new html_attr('class', 'inner'));
    $ftr_d = new dom_element('div', $ftr_p->html_out, new html_attr('id','ft'));
	echo $ftr_d->html_out;
	echo '</div>';
	echo '</body>';
	echo '</html>';
}

?>