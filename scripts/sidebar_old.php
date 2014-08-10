<?php

require_once 'app_config.php';
require_once 'authorize.php';

session_start();


function chk_array($unknown) {
	if ( (array) $unknown !== $unknown ) { 
    	return false; 
	} else { 
    	return true;
    } 
} 

function is_assoc($array) {
  foreach (array_keys($array) as $k => $v) {
    if ($k !== $v)
      return true;
  }
  return false;
}

class html_attr {
	private $attr;
	private $vals;
	public $attr_text;
	
	public function __construct($attr, $val){
		$this->attr = $attr;
		add_val($val);
	}
	public function add_val($val) {
		if (!chk_array($val)) {
			$this->vals[] = $val;
		} else {
			foreach($val as $e) {
				$this->vals[] = $e;
			}
		}
	}
	public function get_text() {
		$rtn = $this->attr . '="';
		foreach($this->vals as $val) {
			$rtn = $rtn . $val . ' ';
		}
		$rtn = rtrim($rtn) . '"';
		$this->attr_text = $rtn;
		return $this->attr_text;
	}
}

class dom_element {
	private $tag;
	private $attrs;
	public $elem_txt = '';
	public $elem;
	
	public function __construct($tag) {
		$this->tag = $tag;
	}
	public function __construct2($tag,$txt = NULL, $attr = NULL, $val = NULL) {
		$this->tag = $tag;
		if (isset($txt)) { $this->elem_txt = $txt; }
		if (isset($val) || isset($attr)) {
			add_attr($attr,$val);
		} elseif (isset($attr)) {
			add_attr_obj($attr);
		}
	}
	public function add_attr($attr,$val) {
		$this->attrs[] = new html_attr($attr,$val);
	}
	public function add_attr_obj($attr) {
		if (!chk_array($attr)) {
			$this->attrs[] = $attr;
		} else {
			foreach($attr as $e) {
				$this->attrs[] = $e;
			}
		}		
	}
	public function get_html() {
		$rtn = '<' . $this->tag;
		if (isset($this->attrs)) {
			foreach ($this->attrs as $a) {
				$rtn = $rtn . ' ' . $a->get_text;
			}
		}
		$rtn = $rtn . '>' . $this->elem_txt . '</' . $this->tag . '>';
		$this->elem = $rtn;
		return $this->elem;
	}
}

class main_nav_a {
	public $e;
	
	public function __construct($href, $title, $caption) {
		$this->e = new dom_element('a',$caption,NULL,NULL);
		$a[] = new html_attr('href',$href);		
		$a[] = new html_attr('title',$title);
		$this->e->add_attr_obj($a);
	}
	public function get_html() {
		return $this->e->get_html;
	}
}

class sidebar {
	private $selected_record_block;
	private $navlist;
	private $app_info_block;
	public $html_out;
	
	public function get_html() {
		$rtn = '<div id="sidebar" class="yui-b">\n';
		//todo add blocks
		$rtn = $rtn . '</div>\n';
		$this->html_out = $rtn;
		return $this->html_out;
	}
}
// the info_block displays a title and one or more paragraphs of text
class info_block {
	private $title_txt;
	private $block_id;
	private $visibility;
	public $paragraphs;
	public $html_out;
	
	public function __construct($id) {
		$this->block_id = $id;
		$this->visibility = 0;
	}
	public function __construct2($id, $title) {
		$this->block_id = $id;
		$this->title_txt = $title;
		$this->visibility = 1;
	}
	public function __construct3($id, $title, $visible) {
		$this->block_id = $id;
		$this->title_txt = $title;
		$this->visibility = $visible;
	}
	public function add_paragraph($txt,$id=NULL) {
		$idt = '';
		if (!isset($id)) { $idt = $id; }
		$this->paragraphs[] = array($txt,$id);
	}
	public function delete_paragraph($pId) {
		if (isset($this->paragraphs[$pId])) { 
			unset($this->paragraphs[$pId]);
			return true;
		} else {
			foreach($this->paragraphs as $key => $para){
				$p = $para[1];
				$ks[$p] = $key;
			}
			if (isset($ks[$pId])) {
				$k = $ks[$pId];
				unset($this->paragraphs[$k]);
				return true;
			}
		}
		return false;
	}
	public function set_visible() { $this->visibility = 1; }
	public function set_invisible() { $this->visibility = 0; }
	public function get_html() {
		$rtn = '<div id="{$block_id}" class="block';
		if (isset($this->visibility)) {
			if ($this->visibility == 0) {
				$rtn = $rtn . ' bh"';
			} 
		}
		$rtn = $rtn . '>\n';
		$rtn = $rtn . '<div class="hd">\n';
		$rtn = $rtn . '<h2 id="{$this->block_id}_title">';
		if (isset($this->title_txt)) { $rtn = $rtn . $this->title_txt; }
		$rtn = $rtn . '</h2>\n';
		$rtn = $rtn . '</div>\n';
		if (isset($this->paragraphs)) {
			$rtn = $rtn . '<div class="bd">\n';
			foreach($this->paragraphs as $para) {
				$rtn = $rtn . '<p';
				if (!strlen($para[1]) == 0) { $rtn = $rtn . ' id="{$para[1]}"'; }
				$rtn = $rtn . '>' . $para[0] . '</p>\n';
			}
			$rtn = $rtn . '</div>\n';
		}
		$rtn = $rtn . '</div>\n';
		$this->html_out = $rtn;
		return $this->html_out;
	}
}

class main_nav_li {
	private $url = '#';
	private $title;
	private $caption;
	private $hidden_txt;
	private $active = 0;
	public $html_out;
	
	public function __construct($title, $caption) {
		$this->title = $title;
		$this->caption = $caption;
	}
	public function __construct2($title, $caption, $act) {
		$this->title = $title;
		$this->caption = $caption;
		$this->active = $act;
	}
	public function __construct3($title, $caption, $act, $hidden) {
		$this->title = $title;
		$this->caption = $caption;
		$this->active = $act;
		$this->hidden_txt = $hidden;
	}
	public function __construct4($title, $caption, $act, $hidden, $url) {
		$this->title = $title;
		$this->caption = $caption;
		$this->hidden_txt = $hidden;
		$this->active = $act;
		$this->url = $url;
	}
	public function get_html() {
		$rtn = '<li><a href="{$this->url}"';
		if ($this->active == 1) { $rtn = $rtn . ' class="highlight"'; }
		$rtn = $rtn . ' title ="{$this->title}">{$this->caption}</a>';
		if (isset($this->hidden_txt)) { 
			$rtn = $rtn . '<span id="hd_{$this->title}" class="bh">{$this->hidden_txt}</span>';
		}
		$rtn = $rtn . '</li>';
		$this->html_out = $rtn;
		return $this->html_out;
	}
}

function create_sidebar($page_name) {
	$odt = '<div id="sidebar" class="yui-b">\n';
	$sel_rec_block = new info_block('sel_rec');
	
	
	
	$list_nav_hd = <<<EOD
<div class="block">
	<div class="hd">
		<h2 id="rec_name">{$page_name}</h2>
	</div>
	<div class="bd">
		<h3>Actions</h3>
		<ul id="action-switcher" class="biglist">
			<li><a href="#" title="new">New {$page_name}</a></li>
			<li><a href="#" title="view_all">View All {$page_name}s</a></li>
			<li><a href="#" title="dash">Dashboard</a></li>
		</ul>
EOD;
	if ($page_name == 'Project') {
		if (!isset($_SESSION['user_id'])) {
			$connection = new ConnectdB();
			$connection->connect();
		
			$query = sprintf("SELECT p.id, p.title, p.start_date, p.description "
								. "FROM project p INNER JOIN project_resource pr "
								. "ON pr.project_id = p.id "
								. "INNER JOIN resource r ON r.id = pr.resource_id "
								. "WHERE r.user_id = %d AND p.start_date <= DATE(NOW()) "
								. "AND IFNULL(p.finish_date,DATE_SUB(NOW() INTERVAL 1 HOUR)) > DATE(NOW()) "
								. "ORDER BY p.start_date;"
								, $_SESSION['user_id']);
			
			if(!$results = $connection->my_conn->query($query)){
				handle_error('There was an error running the query.', $connection->my_conn->error);
			}
			
			if ($results->num_rows > 0) {
				$list_nav_sec_one = '<h3>Active</h3>\n <ul id="activeGrp-switcher" class="biglist">\n ';
				while ($result = $results->fetch_assoc()) {
					$list_nav_sec_one = $list_nav_sec_one . sprintf('<li><a href="#" title="p%d" class="highlight">%s</a><span id="d%d" class="bh">%s</span></li>\n '
						, $result['id']
						, $result['title']
						, $result['id']
						, $result['description']);
				}
				$list_nav_sec_one = $list_nav_sec_one . '</ul>\n ';
			}
			$results->free();
			$query = sprintf("SELECT p.id, p.title, p.description "
								. "FROM project p INNER JOIN project_resource pr "
								. "ON pr.project_id = p.id "
								. "INNER JOIN resource r ON r.id = pr.resource_id "
								. "WHERE r.user_id = %d AND p.start_date > DATE(NOW()) "
								. "AND IFNULL(p.finish_date,DATE_SUB(NOW() INTERVAL 1 HOUR)) > DATE(NOW()) "
								. "ORDER BY p.start_date;"
								, $_SESSION['user_id']);
			
			if(!$results = $connection->my_conn->query($query)){
				handle_error('There was an error running the query.', $connection->my_conn->error);
			}
			
			if ($results->num_rows > 0) {
				$list_nav_sec_two = '<h3>Future</h3>\n <ul id="futureGrp-switcher" class="biglist">\n ';
				while ($result = $results->fetch_assoc()) {
					$list_nav_sec_two = $list_nav_sec_two . sprintf('<li><a href="#" title="p%d" class="highlight">%s</a><span id="d%d" class="bh">%s</span></li>\n '
						, $result['id']
						, $result['title']
						, $result['id']
						, $result['description']);
				}
				$list_nav_sec_two = $list_nav_sec_two . '</ul>\n ';
			}
			$results->free();
			$query = sprintf("SELECT p.id, p.title, p.description "
								. "FROM project p INNER JOIN project_resource pr "
								. "ON pr.project_id = p.id "
								. "INNER JOIN resource r ON r.id = pr.resource_id "
								. "WHERE r.user_id = %d AND p.finish_date IS NOT NULL "
								. "AND p.finish_date < DATE(NOW()) "
								. "ORDER BY p.finish_date;"
								, $_SESSION['user_id']);
			
			if(!$results = $connection->my_conn->query($query)){
				handle_error('There was an error running the query.', $connection->my_conn->error);
			}
			
			if ($results->num_rows > 0) {
				$list_nav_sec_three = '<h3>Completed</h3>\n <ul id="compGrp-switcher" class="biglist">\n ';
				while ($result = $results->fetch_assoc()) {
					$list_nav_sec_three = $list_nav_sec_three . sprintf('<li><a href="#" title="p%d" class="highlight">%s</a><span id="d%d" class="bh">%s</span></li>\n '
						, $result['id']
						, $result['title']
						, $result['id']
						, $result['description']);
				}
				$list_nav_sec_three = $list_nav_sec_three . '</ul>\n ';
			}
			$results->free();
			// TO Do write Archived Project logic
		}
	}
	
	//Resource Nav List Logic
	if ($page_name == 'resource') {
		if (!isset($_SESSION['user_id'])) {
			$connection = new ConnectdB();
			$connection->connect();
			$list_nav_sec_one = '';
		
			$query = "SELECT t.id, t.name, t.plural FROM resource_type t ORDER BY t.id;";
			
			if(!$results = $connection->my_conn->query($query)){
				handle_error('There was an error running the query.', $connection->my_conn->error);
			}
			
			if ($results->num_rows > 0) {
				while($result = $results->fetch_assoc()) {
					$types[] = $result;
				}
			}
			$results->free();
			
			foreach ($types as $type) {
				$query = sprintf("SELECT r.id, r.name, r.first_name, r.nick_name, r.last_name, r.email, r.linkedin_id, " .
								"r.facebook_id, r.twitter_id, r.image_url, r.description " .
								"FROM resource r " .
								"WHERE r.type_id = %d " .
								"AND (EXISTS (	SELECT c.id " .
								"            	FROM user_resource c " .
								"            	WHERE r.id = c.resource_id " .
								"            	AND c.user_id = %d) " .
								"     OR EXISTS (SELECT pr.id " .
								"                FROM project_resource pr " .
								"                WHERE pr.resource_id = r.id " .
								"                AND EXISTS ( 	SELECT prb.id " .
								"                            	FROM project_resource prb " .
								"                            	INNER JOIN resource rb " .
								"                            		ON rb.id = prb.resource_id " .
								"                            	WHERE rb.user_id = %d " .
								"                            	AND prb.project_id = pr.project_id) " .
								"				) " .
								"     )" 
								,$type['id']
								,$_SESSION['user_id']
								,$_SESSION['user_id']);
				
				if(!$results = $connection->my_conn->query($query)){
					handle_error('There was an error running the query.', $connection->my_conn->error);
				}
				if ($results->num_rows > 0) {
					$list_nav_sec_one = $list_nav_sec_one . sprintf('<h3>%s</h3>\n <ul id="activeGrp-switcher" class="biglist">\n ',$type['plural']);
					while ($result = $results->fetch_assoc()) {
						$list_nav_sec_one = $list_nav_sec_one . sprintf('<li><a href="#" title="r%d" class="highlight">%s</a>' . 
						
																, $result['id']
																, $result['name']);
						if (isset($result['description']){
							$list_nav_sec_one = $list_nav_sec_one . sprintf('<span id="d%d" class="bh">%s</span>'
																	, $result['id']
																	, $result['description']);
						}
						if (isset($result['description']){
							$list_nav_sec_one = $list_nav_sec_one . sprintf('<span id="email%d" class="bh">%s</span>'
																	, $result['id']
																	, $result['email']);
						}
						$list_nav_sec_one = $list_nav_sec_one . '</li>\n ';
					}
					$list_nav_sec_one = $list_nav_sec_one . '</ul>\n ';
				}
			}
		}
	}
	//ToDo Write Calendar Nav List Logic
	//ToDo Write management Nav List Logic
	//ToDo Write Profile Nav List Logic
	//ToDo Write Settings Nav List Logic

	$list_nav_ft = '</div>\n </div>\n ';

	$pgm_desc = <<<EOD
	<div id="pgm_desc" class="block bh">
		<div class="hd">
			<h2>About POPM</h2>
		</div>
			<div class="bd">
				<p>This project is based on my idea that many of the processes involved in managing a project can be automated.</p>
				<p>Figuring out whether a meeting is needed, who needs to attend the meeting, and what they need to contribute is a repetitive task that lends itself well to automation.  Likewise, meeting minutes, reminders, and other communications to all kinds of stakeholders should not be a manual task because it involves the same steps every time.</p>
				<p>The result is a clean, intuitive project management platform including all the features you would expect and a high degree of automation. We hope you find it useful.</p>
			</div>
		</div>
	</div>
</div>
EOD;
	$rtn = $odt . $selected_record . $list_nav_hd;
	if (isset($list_nav_sec_one)) { $rtn = $rtn . $list_nav_sec_one; }
	if (isset($list_nav_sec_two)) { $rtn = $rtn . $list_nav_sec_two; }
	if (isset($list_nav_sec_three)) { $rtn = $rtn . $list_nav_sec_three; }
	if (isset($list_nav_sec_four)) { $rtn = $rtn . $list_nav_sec_four; }
	$rtn = $rtn . $list_nav_ft . $pgm_desc;
	
	return $rtn;
}

?>