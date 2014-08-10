<?php

require_once 'app_config.php';
require_once 'authorize.php';
// 
	define("SUCCESS_MESSAGE", "notice");
	define("ERROR_MESSAGE", "error");
	define("WARNING_MESSAGE", "warning");
// 
session_start();

function display_pagetop($title, $javascript = NULL, $success_message = NULL, $error_message = NULL, $warn_message = NULL) {
    display_head($title, $javascript);
    display_title($title, $success_message, $error_message);
}

function display_rest_of_page($title = "") {
	display_sidebar($title);
	display_footer();
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
		if ($title == 'User Signup') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="/signup.php">Signup</a></li>';
		if ($title == 'Sign In') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="/signin.php">Login</a></li>';
	} else {
		if ($title == 'Project') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="/project.php">Projects</a></li>';		
		if ($title == 'Resource') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="/resource.php">Resources</a></li>';		
		if ($title == 'Calendar') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="/calendar.php">Calendar</a></li>';
		echo '</ul>';
		echo '<ul id="user-navigation">';
		if (user_in_group($_SESSION['user_id'], "admin")) {		
			if ($title == 'Management') { echo '<li class="active">'; } else { echo '<li>'; }
			echo '<a href="/management.php">Management</a></li>';
		}
		if ($title == 'Profile') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="/profile.php">Profile</a></li>';
		if ($title == 'Settings') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="/settings.php">Settings</a></li>';
		if ($title == 'Logout') { echo '<li class="active">'; } else { echo '<li>'; }
		echo '<a href="/logout.php">Logout</a></li>';
	}
	echo <<<EOD
	        </ul>
                <div class="clear"></div>
            </div>
        </div>
        <div id="bd">
EOD;


	display_messages($success_msg, $error_msg, $warn_msg);
}

function display_messages($success_msg = NULL, $error_msg = NULL, $warn_msg = NULL) {
    echo "<div class='block bh'>\n";
    if (!is_null($success_msg) && (strlen($success_msg) > 0)) {
        display_message($success_msg, SUCCESS_MESSAGE);
    }
    if (!is_null($error_msg) && (strlen($error_msg) > 0)) {
        display_message($error_msg, ERROR_MESSAGE);
    }
    if (!is_null($warn_msg) && (strlen($warn_msg) > 0)) {
        display_message($warn_msg, WARNING_MESSAGE);
    }
    echo "\t</div>\n\n";
}

function display_message($msg, $msg_type) {
    echo "\t<div class='bd'>\n";
    echo "\t\t<p class='alert {$msg_type}'>{$msg}</p>\n";
    echo "\t</div>\n";
}

function display_sidebar($title) {
    echo <<<EOD
            <div id="sidebar" class="yui-b">

                <!-- Sidebar block (same markup as basic block) -->
                <div class="block">
                    <div class="hd">
                        <h2 id="selectionTitle">Create POPM Site</h2>
                    </div>
                    <div class="bd">
                        <p id="selectionDescription">This project tracks the creation of the POPM Site.</p>
                    </div>
                </div>

                <!-- Layout adjustment options (for demo purposes) -->
                <div class="block">
                    <div class="hd">
                        <h2 id="rec_name">Projects</h2>
                    </div>
                    <div class="bd">
                        <h3>Actions</h3>
                        <ul id="action-switcher" class="biglist">
                            <li><a href="#" title="new">New Project</a></li>
                            <li><a href="#" title="view_all">View All Projects</a></li>
                            <li><a href="#" title="dash">Dashboard</a></li>
                        </ul>
                        <h3>Active</h3>
                        <ul id="activeGrp-switcher" class="biglist">
                            <li><a href="#" title="doc" class="highlight">Create POPM Site</a></li>
                            <li><a href="#" title="doc2">Create VinVin</a></li>
                            <li><a href="#" title="doc4">Test Project</a></li>
                            <li><a href="#" title="doc3">Second Test Project</a></li>
                        </ul>

                        <h3>Future</h3>
                        <ul id="futureGrp-switcher" class="biglist">
                            <li><a href="#" title="yui-t1">Next Project</a></li>
                            <li><a href="#" title="yui-t2">Project After That</a></li>
                            <li><a href="#" title="yui-t3">Another Future Project</a></li>
                            <li><a href="#" title="yui-t4">Some Project that will never happen</a></li>
                        </ul>

                        <h3>Completed</h3>
                        <ul id="compGrp-switcher" class="biglist">
                            <li><a href="#" title="tan_blue">Old Project</a></li>
                            <li><a href="#" title="red">Older Project</a></li>
                            <li><a href="#" title="green">Oldest Project</a></li>
                        </ul>

                        <h3>Archived</h3>
                        <p class="small gray">Archived records are view only.</p>
                        <ul id="archiveGrp-switcher" class="biglist">
                            <li><a href="#" title="on">Archived Project</a></li>
                            <li><a href="#" title="off">Another archived Project</a></li>
                        </ul>
                    </div>
                </div>

                <div class="block">
                    <div class="bd">
                        <h2>About Process Oriented Project Management</h2>
                        <p>This project is based on my idea that many of the processes involved in managing a project can be automated.</p>
                        <p>Figuring out whether a meeting is needed, who needs to attend the meeting, and what they need to contribute is a repetitive task that lends itself well to automation.  Likewise, meeting minutes, reminders, and other communications to all kinds of stakeholders should not be a manual task because it involves the same steps every time.</p>
                        <p>The result is a clean, intuitive project management platform including all the features you would expect and a high degree of automation. We hope you find it useful.</p>
                    </div>
                </div>
            </div>
		</div>
EOD;
}

function display_footer() {
    echo <<<EOD
        <div id="ft">
            <p class="inner">Copyright &copy; 2014 Processoriented.Guru</p>
        </div>

    </div>
</body>
</html>
EOD;
}

?>