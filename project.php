<?php
	require_once 'scripts/view.php';
	
	display_pagetop("POPM Projects",NULL,NULL,NULL,NULL,NULL);
?>
<!-- Basic block with spaced tabs -->
<div class="block tabs spaces">
	<div class="hd">
		<ul id="tab-switcher">
			<li class="active"><a href="#" title="overview">Overview</a></li>
			<li><a href="#" title="planning">Planning</a></li>
			<li><a href="#" title="meetings">Meetings</a></li>
			<li><a href="#" title="deliverables">Deliverables</a></li>
			<li><a href="#" title="issues">Issues</a></li>
			<li class="bh" ><a href="#" title="tasks">Tasks</a></li>
		</ul>
		<div class="clear"></div>
	</div>
	<div id="overview" class="tab-content bd">
		<h2 id="ov_Title">Create POPM Site</h2>
		<p id="ov_Desc">This project tracks the creation of the POPM Site.</p>
		<hr>
		<h3 id="ov_subTitle">Project Team</h3>
		<dl id="ov_DefList" class="list">
			<dt>Project Manager</dt>
			<dd>Vincent Engler</dd>
			<dt>Tester</dt>
			<dd>Alina Estis</dd>
			<dt>Tester</dt>
			<dd>Matt Barfield</dd>
		</dl>
		<hr>
		<h3 id="ov_subTitle2">Milestones</h3>
		<dl id="ov_DefList2" class="list">
			<dt>Initiation</dt>
			<dd>April 1, 2014</dd>
			<dt>Design & Development</dt>
			<dd>September 1, 2014</dd>
			<dt>Beta Testing</dt>
			<dd>November 1, 2014</dd>
			<dt>Go Live</dt>
			<dd>January 1, 2015</dd>
		</dl>
	</div>
	<div id="planning" class="tab-content bd bh">
		<h3>Project Team</h3>
		<form action="#" method="get">
			<div class="view-table">
				<table id="proj_team">
					<thead>
						<tr>
							<td><a href="#">Role</a></td>
							<td class="bh">Role_ID</td>
							<td><a href="#">First Name</a></td>
							<td><a href="#">Last Name</a></td>
							<td class="bh">email</td>
							<td class="bh">User_ID</td>
							<td>&nbsp;</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Project Manager</td>
							<td class="bh">5</td>
							<td>Vincent</td>
							<td>Engler</td>
							<td class="bh" >processoriented@gmail.com</td>
							<td class="bh">1</td>
							<td class="text-right"><a href="#" class="vt-edit">edit</a> | <a href="#" class="vt-delete">delete</a></td>
						</tr>
						<tr>
							<td>Contributor</td>
							<td class="bh">2</td>
							<td>Alina</td>
							<td>Estis</td>
							<td class="bh" >alina.estis@hotmail.com</td>
							<td class="bh">2</td>
							<td class="text-right"><a href="#" class="vt-edit">edit</a> | <a href="#" class="vt-delete">delete</a></td>
						</tr>
						<tr>
							<td>Contributor</td>
							<td class="bh">2</td>
							<td>Matt</td>
							<td>Barfield</td>
							<td class="bh" >mrbarfield@sbcglobal.net</td>
							<td class="bh">3</td>
							<td class="text-right"><a href="#" class="vt-edit">edit</a> | <a href="#" class="vt-delete">delete</a></td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<td>&nbsp;</td>
							<td class="bh">1</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td class="bh">&nbsp;</td>
							<td class="bh">&nbsp;</td>
							<td class="text-right"><a href="#" class="vt-insert">add team member</a></td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="column right bh">
				<p><label for="tm-first_name">First Name</label>
					<input type="text" class="text" name="tm-first_name" id="tm-first_name">
				</p>
				<p><label for="tm-last_name">Last Name</label>
					<input type="text" class="text" name="tm-last_name" id="tm-last_name">
				</p>
				<p><label for="tm-email">Email</label>
					<input type="text" class="text" name="tm-email" id="tm-email">
				</p>
				<p><label for="tm-role">Role: </label>
					<select name="tm-role" id="tm-role">
						<option value="1">Stakeholder</option>
						<option value="6">Executive Stakeholder</option>
						<option value="2">Contributor</option>
						<option value="3">Team Leader</option>
						<option value="4">Project Admin</option>
						<option value="5">Project Manager</option>
						<option value="7">Executive Sponsor</option>
					</select>
					<span class="info" id="tm-role-msg"></span>
				</p>
				<p><input type="submit" name="test8" id="test8" value="Submit"> or <a href="#">Cancel</a></p>
			</div>
			<div class="clear"></div>
		</form>
	</div>
	<div id="meetings" class="tab-content bd bh">
		<h3>2 Column Forms</h3>
		<form action="#" method="get">
			<div class="column right">
				<p><label for="test5">Text field</label>
					<input type="text" class="text" name="test5" id="test5" value="">
					<span class="info">Ex: some text</span>
				</p>
				<p><label for="test6">Title <span class="validation">must be awesome</span></label>
					<input type="text" class="text" name="test6" id="test6" value="Dude, it's like totally awesome.">
					<span class="info">Ex: some more text</span>
				</p>
				<p><label for="test7">Text area</label>
					<textarea class="text" name="test7" id="test7" rows="4" cols="40"></textarea>
					<span class="info">Lots of text can go in here</span>
				</p>
				<p><input type="submit" name="test8" id="test8" value="Submit"> or <a href="#">Cancel</a></p>
			</div>
			<div class="column left">
				<p>I bet you thought two column forms would be difficult, eh? <span class="highlight">Don't worry</span>. We've got you covered.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			</div>
			<div class="clear"></div>
		</form>
	</div>
	<div id="deliverables" class="tab-content bd bh">
		<h3>2 Column Forms</h3>
		<form action="#" method="get">
			<div class="column right">
				<p><label for="test5">Text field</label>
					<input type="text" class="text" name="test5" id="test5" value="">
					<span class="info">Ex: some text</span>
				</p>
				<p><label for="test6">Title <span class="validation">must be awesome</span></label>
					<input type="text" class="text" name="test6" id="test6" value="Dude, it's like totally awesome.">
					<span class="info">Ex: some more text</span>
				</p>
				<p><label for="test7">Text area</label>
					<textarea class="text" name="test7" id="test7" rows="4" cols="40"></textarea>
					<span class="info">Lots of text can go in here</span>
				</p>
				<p><input type="submit" name="test8" id="test8" value="Submit"> or <a href="#">Cancel</a></p>
			</div>
			<div class="column left">
				<p>I bet you thought two column forms would be difficult, eh? <span class="highlight">Don't worry</span>. We've got you covered.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			</div>
			<div class="clear"></div>
		</form>
	</div>
	<div id="issues" class="tab-content bd bh">
		<h3>2 Column Forms</h3>
		<form action="#" method="get">
			<div class="column right">
				<p><label for="test5">Text field</label>
					<input type="text" class="text" name="test5" id="test5" value="">
					<span class="info">Ex: some text</span>
				</p>
				<p><label for="test6">Title <span class="validation">must be awesome</span></label>
					<input type="text" class="text" name="test6" id="test6" value="Dude, it's like totally awesome.">
					<span class="info">Ex: some more text</span>
				</p>
				<p><label for="test7">Text area</label>
					<textarea class="text" name="test7" id="test7" rows="4" cols="40"></textarea>
					<span class="info">Lots of text can go in here</span>
				</p>
				<p><input type="submit" name="test8" id="test8" value="Submit"> or <a href="#">Cancel</a></p>
			</div>
			<div class="column left">
				<p>I bet you thought two column forms would be difficult, eh? <span class="highlight">Don't worry</span>. We've got you covered.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			</div>
			<div class="clear"></div>
		</form>
	</div>
	<div id="tasks" class="tab-content bd bh">
		<h3>2 Column Forms</h3>
		<form action="#" method="get">
			<div class="column right">
				<p><label for="test5">Text field</label>
					<input type="text" class="text" name="test5" id="test5" value="">
					<span class="info">Ex: some text</span>
				</p>
				<p><label for="test6">Title <span class="validation">must be awesome</span></label>
					<input type="text" class="text" name="test6" id="test6" value="Dude, it's like totally awesome.">
					<span class="info">Ex: some more text</span>
				</p>
				<p><label for="test7">Text area</label>
					<textarea class="text" name="test7" id="test7" rows="4" cols="40"></textarea>
					<span class="info">Lots of text can go in here</span>
				</p>
				<p><input type="submit" name="test8" id="test8" value="Submit"> or <a href="#">Cancel</a></p>
			</div>
			<div class="column left">
				<p>I bet you thought two column forms would be difficult, eh? <span class="highlight">Don't worry</span>. We've got you covered.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			</div>
			<div class="clear"></div>
		</form>
	</div>
</div>

<!-- Basic block -->
<div class="block bh">
	<div class="hd">
		<h2>Basic Block &larr; This can be an H2 or H3</h2>
	</div>
	<div class="bd">
		<h2>Some H2 Text</h2>
		<h3>Some H3 Text</h3>
		<p>So this is a basic block module. It allows you to define a header using either an &lt;h2&gt; or &lt;h3&gt; tag. It can live in the main body column (here) or in the side bar to the right. It will automatically expand/shrink/do-the-right-thing where ever you put it &mdash; without requiring any markup changes.</p>
		<p>Lorem ipsum dolor sit amet, <strong>some bold text</strong> <em>followed by some italic text</em> consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. <span class="highlight">Highlighted text goes here</span>, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		<p class="small">small text</p>
		<p class="gray">gray text</p>
		<hr>
		<p>Don't miss the &lt;hr&gt; here &uarr;</p>
	</div>
</div>

<!-- Basic block with tabs -->
<div class="block tabs bh">
	<div class="hd">
		<h2>Fake Header For SEO Purposes</h2>
		<ul>
			<li class="active"><a href="#">Tabs</a></li>
			<li><a href="#">Are</a></li>
			<li><a href="#">Freaking</a></li>
			<li><a href="#">Awesome</a></li>
			<li><a href="#">Tab 5</a></li>
			<li><a href="#">Tab 6</a></li>
		</ul>
		<div class="clear"></div>
	</div>
	<div class="bd">
		<h3>Tab Example</h3>
		<p>The tabs at the top of this block are made using an &lt;ul&gt; &mdash; they're super-useful for sub-navigation elements. If you look at the source, you'll also notice that right above them is an &lt;h2&gt; tag which is hidden from view. This lets you define a header for <abbr title="Search Engine Optimization">SEO</abbr> purposes without affecting your layout.</p>
		<p>You can set the active tab by simply applying <code>class="active"</code> to the appropriate &lt;li&gt;.</p>
	</div>
</div>

<!-- Tables -->
<div class="block bh">
	<div class="hd">
		<h2>Table Example</h2>
	</div>
	<div class="bd">
		<h3>Tables</h3>
		<table>
			<thead>
				<tr>
					<td><input type="checkbox" name="test10" id="test10" value=""></td>
					<td>ID</td>
					<td><a href="#">Login</a></td>
					<td><a href="#">First Name</a></td>
					<td><a href="#">Last Name</a></td>
					<td>&nbsp;</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input type="checkbox" name="test11" id="test11" value=""></td>
					<td>1</td>
					<td>susan</td>
					<td>Susan</td>
					<td>Delgado</td>
					<td class="text-right"><a href="#">view</a> | <a href="#">edit</a> | <a href="#">delete</a></td>
				</tr>
				<tr>
					<td><input type="checkbox" name="test12" id="test12" value=""></td>
					<td>2</td>
					<td>eddie</td>
					<td>Edward</td>
					<td>Dean</td>
					<td class="text-right"><a href="#">view</a> | <a href="#">edit</a> | <a href="#">delete</a></td>
				</tr>
				<tr>
					<td><input type="checkbox" name="test13" id="test13" value=""></td>
					<td>3</td>
					<td>jake</td>
					<td>John</td>
					<td>Chambers</td>
					<td class="text-right"><a href="#">view</a> | <a href="#">edit</a> | <a href="#">delete</a></td>
				</tr>
				<tr>
					<td><input type="checkbox" name="test14" id="test14" value=""></td>
					<td>4</td>
					<td>calvin</td>
					<td>Calvin</td>
					<td>Tower</td>
					<td class="text-right"><a href="#">view</a> | <a href="#">edit</a> | <a href="#">delete</a></td>
				</tr>
			</tbody>
		</table>

		<ul class="pager">
			<li><a href="#">&#171; Prev</a></li>
			<li class="active"><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">6</a></li>
			<li><a href="#">7</a></li>
			<li><a href="#">8</a></li>
			<li><a href="#">9</a></li>
			<li><a href="#">10</a></li>
			<li><a href="#">11</a></li>
			<li><a href="#">12</a></li>
			<li><a href="#">Next &#187;</a></li>
		</ul>

	</div>
</div>

<!-- Forms -->
<div class="block bh">
	<div class="hd">
		<h2>Single Column Form Example</h2>
	</div>
	<div class="bd">
		<h3>Attractive Looking Forms</h3>
		<form action="#" method="get">
			<p><label for="test1">Text field</label>
				<input type="text" class="text" name="test1" id="test1" value="test1">
				<span class="info">Ex: some text</span>
			</p>
			<p><label for="test2">Title <span class="validation">must be awesome</span></label>
				<input type="text" class="text" name="test2" id="test2" value="Dude, it's like totally awesome.">
				<span class="info">Ex: some more text</span>
			</p>
			<p><label for="test3">Text area</label>
				<textarea class="text" name="test3" id="test3" rows="4" cols="40"></textarea>
				<span class="info">Lots of text can go in here</span>
			</p>
			<p><input type="submit" name="test4" id="test4" value="Submit"> or <a href="#">Cancel</a></p>
		</form>
	</div>
</div>

<!-- Two column forms -->
<div class="block bh">
	<div class="hd">
		<h2>Two Column Form Example</h2>
	</div>
	<div class="bd">
		<h3>2 Column Forms</h3>
		<form action="#" method="get">
			<div class="column left">
				<p><label for="test5">Text field</label>
					<input type="text" class="text" name="test5" id="test5" value="">
					<span class="info">Ex: some text</span>
				</p>
				<p><label for="test6">Title <span class="validation">must be awesome</span></label>
					<input type="text" class="text" name="test6" id="test6" value="Dude, it's like totally awesome.">
					<span class="info">Ex: some more text</span>
				</p>
				<p><label for="test7">Text area</label>
					<textarea class="text" name="test7" id="test7" rows="4" cols="40"></textarea>
					<span class="info">Lots of text can go in here</span>
				</p>
			</div>
			<div class="column right">
				<p>I bet you thought two column forms would be difficult, eh? <span class="highlight">Don't worry</span>. We've got you covered.</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			</div>
			<div class="clear"></div>
			<p><input type="submit" name="test8" id="test8" value="Submit"> or <a href="#">Cancel</a></p>
		</form>
	</div>
</div>

<!-- Lists -->
<div class="block bh">
	<div class="hd">
		<h2>Lists! Lists!</h2>
	</div>
	<div class="bd">
		<h3>Get your lists here!</h3>
		<p>Unordered List</p>
		<ul class="list">
			<li>Apple</li>
			<li>Pear</li>
			<li>Orange</li>
		</ul>

		<p>Ordered List</p>
		<ol class="list">
			<li>Mars</li>
			<li>Jupiter</li>
			<li>Venus</li>
		</ol>

		<p>Dictionary List</p>
		<dl class="list">
			<dt>Hollywood</dt>
			<dd>Academy Awards</dd>
			<dt>Television</dt>
			<dd>Emmys</dd>
			<dt>Broadway</dt>
			<dd>Tonys</dd>
		</dl>
	</div>
</div>
<?php
	display_rest_of_page("POPM Projects");
?>