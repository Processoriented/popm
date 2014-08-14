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
		<div class="column left">
			<h3>POPM Status Updates</h3>
			<a class="twitter-timeline" href="https://twitter.com/popm_guru" data-widget-id="499991197088104448" data-chrome="noheader nofooter transparent noscrollbar" >Tweets by @popm_guru</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
		<div class="column right">
			<h3>Project Management News</h3>
			<a class="twitter-timeline" href="https://twitter.com/popm_guru/lists/project-management" data-widget-id="499991523392376834" data-chrome="noheader nofooter transparent noscrollbar" >Tweets from https://twitter.com/popm_guru/lists/project-management</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php display_rest_of_page(); ?>
