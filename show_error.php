<!DOCTYPE html>
<?php

    require_once 'scripts/app_config.php';

	session_start();

    if (isset($_SESSION['error_message'])) {
        $error_message = preg_replace("/\\\\/",'',$_SESSION['error_message']);
    } else {
        $error_message = "Something went wrong, and that's how you ended up here.";
    }
    if (isset($_SESSION['system_error_message'])) {
        $system_error_message = preg_replace("/\\\\/",'',$_SESSION['system_error_message']);
    } else {
        $system_error_message = "No system-level error message was reported.";
    }

?>
<html>
    <head>
    	<meta charset='utf-8' >
        <link href="css/reset-fonts-grids.css" rel="stylesheet" />
        <link href="css/yuiapp.css" rel="stylesheet" />
        <link href="css/green.css" rel="stylesheet" />
    </head>
    <body class="rounded">
    <div id="doc3" class="yui-t3">

        <div id="hd">
            <h1>Process Oriented Project Management</h1>
        </div>
        <div id="bd">
        <div id="'block bh">
	        <div id="example">Uh oh... sorry!</div>
	</div>
        <div id="'block bh">
            <h1>We're really sorry...</h1>
            <p><img src="images/error.jpg" class="error" />
            <span class="error_message"><?php echo $error_message; ?>
            </span></p>
            <p>Don't worry, though, we've been notified that there's a problem and we take these things seriously.  In fact, if you want to contact us to find out more about what's happened, or you have any concerns, just <a href="mailto:support@processoriented.guru">email us</a> and we'll be happy to get right back to you.</p>
            <p>In the meantime, if you want to go back to the page that caused the problem, you can do that by <a href="javascript:history.go(-1);">clicking here.</a>  If the same problem occurs, though, you may want to come back a bit later.  We bet we'll have things figured out by then.  Thanks again... we'll see you soon.  And again, we're really sorry for the inconvenience.</p>
            <?php
                debug_print("<hr />");
                debug_print("<p>The following system-level message was received: " .
                "<b>{$system_error_message}</b></p>");
            ?>
        </div>

        <div id="ft"><p class="inner">Copyright &copy; 2014 Processoriented.Guru</p></div>
    </body>
</html>