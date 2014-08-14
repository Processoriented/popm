<?php
	require_once 'scripts/view.php';
	
	display_pagetop("POPM",NULL,NULL,NULL,NULL,NULL);
?>
<!-- Welcome -->
<div class="block">
	<div class="hd">
		<h2>News</h2>
	</div>
	<div class="bd">
		<h3>Status Update</h3>
		<p>The project is chugging along.  Today I've added icons to my major functions on the site navigation, and I've relocated the sign-in form to the sidebar (although it still exists in it's own php file in case I ever need that back.</p>
	</div>
</div>
<div class="block">
	<div class="hd">
		<h2>From the Twitterverse</h2>
	</div>
	<div class="bd">
		<h3>Tweets</h3>
		<a class="twitter-timeline" width="680" href="https://twitter.com/processoriented/lists/project-management" data-widget-id="499717714047295488">Tweets from https://twitter.com/processoriented/lists/project-management</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	</div>
</div>


<?php display_rest_of_page(); ?>
