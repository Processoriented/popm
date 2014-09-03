<?php

require_once 'app_config.php';
require_once 'authorize.php';

if (!isset($_SESSION)) { session_start(); }


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
	public $aname;
	public $val;
	public $atext;
	
	public function __construct($attr, $val){
		$this->aname = $attr;
		$this->val = $val;
		$this->set_text();
	}
	protected function set_text() {
		$rtn = $this->aname . '="';
		$rtn = $rtn . $this->val;
		$rtn = rtrim($rtn) . '"';
		$this->atext = $rtn;
	}
}
class html_cls_attr extends html_attr {
	public $classes;
	public function __construct() {
		$cls = func_get_args();
		$this->classes = $cls;
		parent::__construct('class', implode($this->classes, ' '));
	}
	public function add_classes() {
		$cls = func_get_args();
		$this->classes = array_merge($this->classes, $cls);
		$this->val = implode($this->classes, ' ');
		$this->set_text();
	}
	public function rm_classes() {
		$cls = func_get_args();
		$this->classes = array_diff($this->classes, $cls);
		$this->val = implode($this->classes, ' ');
		$this->set_text();		
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
		if (chk_array($attr)) { 
			$this->add_attrs($attr); 
		} elseif(!$this->chk_in_attrs($attr)) { 
			$this->attrs[] = $attr; 
		} elseif(is_a($attr, 'html_cls_attr')) {
			$ca = $this->get_attr_by_name('class');
			foreach($attr->classes as $c) {
				$ca->add_classes($c);
			}
		}
		$this->set_html();
	}
	private function add_attrs($attrs) {
		foreach($attrs as $a) { $this->add_attr($a); }
	}
	public function apnd($elem) {
		if(chk_array($elem)) { $this->apnd_array($elem); }
		else { 
			$t = (is_a($elem,dom_element)) ? $elem->html_out : $elem;
			$this->elem_txt = $this->elem_txt . $t;
			$this->set_html();
		}
	}
	public function ppnd($elem) {
		if(chk_array($elem)) { $this->ppnd_array($elem); }
		else { 
			$t = (is_a($elem,dom_element)) ? $elem->html_out : $elem;
			$this->elem_txt = $t . $this->elem_txt;
			$this->set_html();
		}	
	}
	private function apnd_array($elems) {
		foreach($elems as $elem) { $this->apnd($elem); }
	}
	private function ppnd_array($elems) {
		foreach($elems as $elem) { $this->ppnd($elem); }
	}
	private function attr_names() {
		if(!isset($this->attrs)) { return false; }
		else { foreach($this->attrs as $a) { $r[] = $a->aname; }
			return $r; }
	}
	protected function get_attr_by_name($s) {
		if(isset($this->attrs)) { foreach($this->attrs as $a) { if($s == $a->aname){ return $a; } } }
		return false;
	}
	public function get_id() {
		if(!$ida = $this->get_attr_by_name('id')) { return false; }
		else { return $ida->val; } 
	}
	public function get_class_vals() {
		if(!$cls = $this->get_attr_by_name('class')) { return false; }
		else { return $cls->classes; } 
	}
	public function remove_class($cls_name) {
		if($cla = $this->get_attr_by_name('class')) {
			$cla->rm_classes($cls_name);
		}
	}
	private function chk_in_attrs($a) {
		// Are any attributes set for this element?
		if(!isset($this->attrs)) { 
			return false; 
		} elseif(!in_array($a->aname, $this->attr_names())) { 
			// Do any of the existing attributes have the same name as $a?
			return false; 
		} else {
			return true;
		}
		return false;
	}
	private function attr_text() {
		$rtn = '';
		if (isset($this->attrs)) { foreach ($this->attrs as $a) { $rtn = $rtn . ' ' . $a->atext; }}
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
class nav_a extends dom_element {
	public function __construct($caption, $title = NULL, $href = '#') {
		parent::__construct('a',$caption);
		$a[] = new html_attr('href',$href);	
		if(isset($title)) { 
			$a[] = new html_attr('title',$title);
			$a[] = new html_attr('id', $title);
		}
		$this->add_attr($a);
		$this->set_html();
	}
}
class hidden_span extends dom_element {
	//creates a hidden span for storing information that will be needed by javascript navigation routines
	
	public function __construct($text, $id = NULL, $cls = NULL) {
		$a[] = new html_cls_attr('bh');
		if(isset($cls)) { $a[0]->add_classes($cls); }
		if(isset($id)) { $a[] = new html_attr('id',$id); }
		parent::__construct('span',$text, $a);
		$this->set_html();
	}
}
class sb_nav_li extends dom_element{
	public function __construct($anchor, $hidden_spans = NULL, $active = 0) {
		$hs = '';
		if(isset($hidden_spans)) {
			$hs = (chk_array($hidden_spans)) ? merge_de_array($hidden_spans) : $hidden_spans->html_out;
		}
		$t = $anchor->html_out . $hs;
		parent::__construct('li',$t);
		if($active == 1) { $this->add_attr(new html_cls_attr('highlight')); }
		$this->set_html();
	}
}
class tab_nav_li extends dom_element{
	public function __construct($anchor, $active = 0) {
		parent::__construct('li', $anchor->html_out);
		if($active == 1) { $this->add_attr(new html_cls_attr('active')); }
		$this->set_html();
	}
	public function toggle_active() {
		if(!in_array('active',$this->get_class_vals())) { 
			$this->add_attr(new html_cls_attr('active')); 
		} else { 
			$this->remove_class('active'); 
		}
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
		$a[] = new html_cls_attr('biglist');
		parent::__construct('ul', $t, $a);
		$this->set_html();		
	}
}
class tab_nav_ul extends dom_element {
	public function __construct($items) {
		$t = '';
		if(chk_array($items)) {
			foreach($items as $i) { $t = $t . $i->html_out; }
		} else { $t = $t . $items->html_out; }
		$a[] = new html_attr('id','tab-switcher');
		parent::__construct('ul', $t, $a);
		$this->set_html();		
	}
}
class sb_nav_list_div extends dom_element {
	public function __construct($list, $title){
		$h = new dom_element('h3',$title);
		$t = $h->html_out . $list->html_out;
		parent::__construct('div', $t, new html_cls_attr('bd'));
		$this->set_html();
	}
}
class sb_nav extends dom_element {
	public function __construct($divs, $title) {
		$h = new dom_element('h2', $title);
		$hd = new dom_element('div', $h->html_out, new html_cls_attr('hd'));
		$tb = (chk_array($divs)) ? merge_de_array($divs) : $divs->html_out;
		$t = $hd->html_out . $tb;	
		$a[] = new html_cls_attr('block');
		$a[] = new html_attr('id', 'sb_nav');
		parent::__construct('div', $t, $a);
		$this->set_html();
	}
}
class block_p extends dom_element {
	public function __construct($text, $id = NULL, $small = NULL, $gray = NULL) {
		parent::__construct('p', $text);
		if (isset($id)) { $this->add_attr(new html_attr('id',$id)); }
		if (isset($small)) { $this->add_attr(new html_cls_attr('small')); }
		if (isset($gray)) { $this->add_attr(new html_cls_attr('gray')); }
		$this->set_html();
	}
}
class block_body extends dom_element {
	public function __construct($paras = NULL, $id = NULL, $title = NULL) {
		$ps = (!isset($paras)) ? new block_p('') : $paras;
		$pt = (!chk_array($paras)) ? $ps->html_out : merge_de_array($ps);
		if(isset($title)) { $pt = '<h3>' . $title . '</h3>' . $pt; }
		$ba[] = new html_cls_attr('bd');
		if(isset($id)) { $ba[] = new html_attr('id', $id); }
		parent::__construct('div',$pt, $ba);
		$this->set_html();
	}
}
class block extends dom_element {
	public function __construct($id, $body = NULL, $title = '', $visible = 1) {
		$h = new dom_element('h2',$title, new html_attr('id', $id . '_title'));
		$hdd = new dom_element('div',$h->html_out, new html_cls_attr('hd'));
		if(!isset($body)) { $body = new block_body(); }
		$blka[] = new html_attr('id',$id);
		$blka[] = new html_cls_attr('block');
		if ($visible == 0) { $blka[] = new html_cls_attr('bh'); }
		parent::__construct('div',$hdd->html_out . $body->html_out, $blka);		
		$this->set_html();
	}
}
class tabbed_block extends dom_element {
	public function __construct($id, $bodies, $title = '', $active_id = NULL) {
		$body = '';
		foreach($bodies as $k => $tab) {
			$tid = ($tab->get_id()) ? $tab->get_id() : 'tab_' . $k;
			$a = new nav_a(ucfirst($tid),$tid);
			if(((!isset($active_id)) && ($k === 0)) || (!$active_id == $tid))  {
				$li[] = new tab_nav_li($a, 1);
			} else {
				$li[] = new tab_nav_li($a);
				$tab->add_attr(new html_cls_attr('bh'));
			} 
			$body = $body . $tab->html_out;
		}
		$nul = new tab_nav_ul($li);
		$h = new dom_element('h2',$title, new html_attr('id', $id . '_title'));
		$hdd = new dom_element('div',$h->html_out . $nul->html_out, new html_cls_attr('hd'));
		$blka[] = new html_attr('id',$id);
		$blka[] = new html_cls_attr('block');
		$blka[] = new html_cls_attr('tabs');
		parent::__construct('div', $hdd->html_out . $body, $blka);
		$this->set_html();
	}
}
class sidebar extends dom_element {
	public function __construct($u_block, $nav = NULL, $l_block = NULL) {
		$a[] = new html_attr('id', 'sidebar');
		$a[] = new html_cls_attr('yui-b');
		$t = $u_block->html_out;
		if(isset($nav)) { $t = $t . $nav->html_out; }
		if(isset($l_block)) { $t = $t . $l_block->html_out; }
		parent::__construct('div', $t, $a);
		$this->set_html();
	}
}
class frm_input extends dom_element {
	public $label = NULL;
	public $para;
	public function __construct($iType, $id = NULL, $lbl = NULL, $name = NULL, $size = NULL, $val = NULL, $cls = NULL, $lid = NULL, $lcls = NULL) {
		$rid = (isset($id)) ? $id : 'id_' . rand(100,999);
		$name = (isset($name)) ? $name : $rid;
		$la[] = new html_attr('for', $rid);
		if(isset($lid)) { $la[] = new html_attr('id', $lid); }
		if(isset($lcls)) { $la[] = new html_cls_attr($lcls); }
		if(isset($lbl)) { 
			$l = new dom_element('label', $lbl, $la);
			$this->label = $l;		
		}
		
		$a[] = new html_attr('type', $iType);
		if((isset($id)) || (isset($lbl))) { 
			$a[] = new html_attr('id', $rid);
			$a[] = new html_attr('name', $name); 
		}
		if(isset($size)) { $a[] = new html_attr('size', $size); }
		if(isset($val)) { $a[] = new html_attr('value', $val); }
		parent::__construct('input', NULL, $a);
		$this->set_html();
		$this->para = new frm_p($this);
		//to supply text for a text input access the elem_txt property of the parent
	}
}
class frm_p extends dom_element {
	public function __construct($input) {
		$text = $input->html_out;
		if(isset($input->label)) { $text = $input->label->html_out . $text; }
		parent::__construct('p', $text);
	}
}
class frm extends dom_element {
	public $frm_body;
	public function __construct($inputs, $id, $action, $title = NULL, $method = 'POST') {
		$t = '';
		foreach($inputs as $i) { $t = $t . $i->para->html_out; }
		$a[] = new html_attr('id', $id);
		$a[] = new html_attr('action', $action);
		$a[] = new html_attr('method', $method);
		
		parent::__construct('form',$t, $a);
		$this->frm_body = new block_body($this, NULL, $title);
	}
}
?>