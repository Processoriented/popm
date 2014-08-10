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
    if ($k !== $v) { return true; }
  }
  return false;
}

function merge_de_array ( array $elems ) {
	$r = '';
	foreach($elems as $e) {
		$r = $r . $e->html_out;
	}
	return $r;
}

class html_attr {
	public $name;
	public $vals;
	public $text;
	
	public function __construct($attr, $val){
		$this->name = $attr;
		$this->add_val($val);
		$this->set_text();
	}
	public function add_val($val) {
		if(chk_array($val)) { 
			$this->add_vals($val);
		} elseif(!$this->chk_in_vals($val)) {
			$this->vals[] = $val;
			$this->set_text();
		}		
	}
	private function add_vals($values) {
		foreach($values as $val) { $this->add_val($val); }
	}
	private function chk_in_vals($val) {
		if(!isset($this->vals)) { return false; }
		elseif(!in_array($val,$this->vals)) { return false; }
		return true;
	}
	private function set_text() {
		$rtn = $this->name . '="';
		foreach($this->vals as $val) { $rtn = $rtn . $val . ' '; }
		$rtn = rtrim($rtn) . '"';
		$this->text = $rtn;
	}
}
class dom_element {
	protected $tag;
	public $attrs;
	public $elem_txt = '';
	public $html_out;
	protected static $void_elements = array('br', 'hr', 'img', 'input', 'link', 'meta','area'
						, 'base', 'col', 'embed', 'keygen', 'menuitem'
						, 'param', 'source', 'track', 'wbr');
						
	
	public function __construct($tag,$txt = NULL,$attr = NULL) {
		$this->tag = $tag;		
		if (isset($txt)) { $this->elem_txt = $txt; }
		if (isset($attr)) { $this->add_attr($attr); }
		$this->set_html();
	}
	public function add_attr($attr) {
		if (chk_array($attr)) { $this->add_attrs($attr); }
		else { if(!$this->chk_in_attrs($attr)) { $this->attrs[] = $attr; }
		$this->set_html(); }	
	}
	private function add_attrs($attrs) {
		foreach($attrs as $a) { $this->add_attr($a); }
	}
	private function attr_names() {
		if(!isset($this->attrs)) { return false; }
		else { foreach($this->attrs as $a) { $r[] = $a->name; }
			return $r; }
	}
	protected function get_attr_by_name($s) {
		if(isset($this->attrs)) { foreach($this->attrs as $a) { if($s->name == $a->name){ return $a; } }}
		return false;
	}
	private function chk_in_attrs($a) {
		if(!isset($this->attrs)) { return false; }
		elseif(!in_array($a->name, $this->attr_names())) { return false; }
		else {
			if(!$ca = $this->get_attr_by_name($a->name)) { return false; }
			else { foreach($a->vals as $v) { if(in_array($v, $ca->vals)) { return true; }}}}
		return false;
	}
	private function attr_text() {
		$rtn = '';
		if (isset($this->attrs)) { foreach ($this->attrs as $a) { $rtn = $rtn . ' ' . $a->text; }}
		return $rtn;
	}
	protected function is_void_elem() {
		if(in_array($this->tag, self::$void_elements)) { return true; }	else { return false; }
	}
	protected function set_html() {
		$rtn = '<' . $this->tag;
		$rtn = $rtn . $this->attr_text();
		$rtn = $rtn . '>';
		if(!(strlen($this->elem_txt == 0) && $this->is_void_elem())) {
			$rtn = $rtn . $this->elem_txt . '</' . $this->tag . '>'; }
		$this->html_out = $rtn;
	}
}
class sb_nav_a extends dom_element {
	public function __construct($caption, $title = NULL, $href = '#') {
		parent::__construct('a',$caption);
		$a[] = new html_attr('href',$href);	
		if(isset($title)) { $a[] = new html_attr('title',$title); }
		$this->add_attr($a);
		$this->set_html();
	}
}
class hidden_span extends dom_element {
	//creates a hidden span for storing information that will be needed by javascript navigation routines
	
	public function __construct($text, $id, $cls = NULL) {
		parent::__construct('span',$text, new html_attr('id',$id));
		if(isset($cls)) { $this->add_attr($cls); }
		$this->set_html();
	}
}
class sb_nav_li extends dom_element{
	public function __construct($anchor, $hidden_spans = NULL, $active = 0) {
		if(isset($hidden_spans)) {
			$hs = '';
			if(chk_array($hidden_spans)) {
				foreach($hidden_spans as $s) { $hs = $hs . $s->html_out; }
			} else { $hs = $hidden_spans->html_out; }
		}
		$t = $anchor->html_out . $hs;
		parent::__construct('li',$t);
		if($active == 1) { $this->add_attr(new html_attr('class','highlight')); }
		$this->set_html();
	}
}
class sb_nav_ul extends dom_element {
	public function __construct($items,$id) {
	// <ul id="action-switcher" class="biglist">
		$t = '';
		if(chk_array($items)) {
			foreach($items as $i) { $t = $t . $i->html_out; }
		} else { $t = $t . $items->html_out; }
		$a[] = new html_attr('id',$id);
		$a[] = new html_attr('class','biglist');
		parent::__construct('ul', $t, $a);
		$this->set_html;		
	}
}
class sb_nav_list_div extends dom_element {
	public function __construct($list, $title){
		$h = new dom_element('h3',$title);
		$t = $h->html_out . $list->html_out;
		parent::__construct('div', $t, new html_attr('class','bd'));
		$this->set_html;
	}
}
class sb_nav extends dom_element {
	public function __construct($divs, $title) {
		$h = new dom_element('h2', $title);
		$hd = new dom_element('div', $h->html_out, new html_attr('class','hd'));
		$tb = (chk_array($divs)) ? merge_de_array($divs) : $divs->html_out;
		$t = $hd->html_out . $tb;	

		parent::__construct('div', $t, new html_attr('class','block'));
		$this->set_html;
	}
}
class sb_info_block_p extends dom_element {
	public function __construct($text, $id = NULL) {
		parent::__construct('p', $text);
		if (isset($id)) { $this->add_attr(new html_attr('id',$id)); }
		$this->set_html;
	}
}
class sb_info_block_body extends dom_element {
	public function __construct($paras = NULL) {
		$ps = (!isset($paras)) ? new sb_info_block_p('') : $paras;
		$pt = (!chk_array($paras)) ? $ps->html_out : merge_de_array($ps);

		parent::__construct('div',$pt, new html_attr('class','bd'));
		$this->set_html();
	}
}
class sb_info_block extends dom_element {
	public function __construct($id, $body = NULL, $title = '', $visible = 1) {
		$h = new dom_element('h2',$title, new html_attr('id', $id . '_title'));
		$hdd = new dom_element('div',$h->html_out, new html_attr('class','hd'));
		if(!isset($body)) { $body = new sb_info_block_body(); }
		$blka[] = new html_attr('id',$id);
		$blka[] = new html_attr('class','block');
		if ($this->visibility == 0) { $blka[] = new html_attr('class','bh'); }
		parent::__construct('div',$hdd->html_out . $body->html_out, $blka);		
		$this->set_html;
	}
}
class sidebar extends dom_element {
	public function __construct($u_block, $nav = NULL, $l_block = NULL) {
		$a[] = new html_attr('id', 'sidebar');
		$a[] = new html_attr('class', 'yui-b');
		$t = $u_block->html_out;
		if(isset($nav)) { $t = $t . $nav->html_out; }
		if(isset($l_block)) { $t = $t . $l_block->html_out; }
		parent::__construct('div', $t, $a);
		$this->set_html;
	}
}
?>