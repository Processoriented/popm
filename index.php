<?php
	require_once 'scripts/view.php';
	
	display_pagetop("POPM",NULL,NULL,NULL,NULL,NULL);
?>
            <div id="yui-main">
                <div class="yui-b">
                	<div class="yui-g">
						<!-- Lists -->
						<div class="block">
							<div class="hd">
								<h2>Welcome!</h2>
							</div>
							<div class="bd">
								<h3>Get started here!</h3>
								<a href="signup.php"><img src="images/sign_me_up.png" /></a>
								<a href="signin.php"><img src="images/sign_me_in.png" /></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php display_rest_of_page(); ?>
	    </div>
	</body>
</html>