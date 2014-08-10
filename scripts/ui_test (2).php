<?php
	require_once 'app_config.php';
	require_once 'database_connection.php';
	require_once 'elements.php';
	

	$conn = proj_data::getInstance();
		
	
			
	if(!$results = $conn->query("SELECT t.id, t.name, t.plural FROM resource_type t ORDER BY t.id;")){
		handle_error('There was an error running the query.', $connection->my_conn->error);
	}
	
	if ($results->num_rows > 0) {
		while($result = $results->fetch_assoc()) {
			$types[] = $result;
		}
	}
	$before = sizeof($types);
	$results->free();
	$after = sizeof($types);
?>
<!DOCTYPE html>
<html lang="US-en">
	<head>
		<meta charset="utf-8">
		<title>Types</title>
	</head>
	<body>
		
<?php
	$ibp[] = new sb_info_block_p('This is a test paragraph','fst');
	$ibp[] = new sb_info_block_p('This is a different test paragraph','scd');
	$bb = new sb_info_block_body($ibp);
	$ib = new sb_info_block('vib', $bb,'test block');
	
	foreach($types as $typ) {
		$a = new sb_nav_a($typ['plural'],'a'. $typ['id']);
		$h = new hidden_span($typ['name'],'a'. $typ['id']);
		$l[] = new sb_nav_li($a,$h);
	}
	$u = new sb_nav_ul($l,'uList');
	$d[] = new sb_nav_list_div($u, 'Types');
	$oid = array(1,2,3,4,5,6,7,8);
	foreach ($oid as $ov) { $o[] = new sb_nav_a('record : ' . $ov,'a'.$oidi); }
	foreach($o as $oi) { $lst[] = new sb_nav_li($oi); }
	$ua = new sb_nav_ul($lst,'uList2');
	$d[] = new sb_nav_list_div($ua, 'Records');
	
	$projects = $conn->getNavData(311000000);
	foreach($projects as $proj) { $pa[] = new sb_nav_a($proj['title'], 'proj_' . $proj['id']); }
	foreach($pa as $pi) { $plst[] = new sb_nav_li($pi); }
	$upr = new sb_nav_ul($plst,'uLstPr');
	$d[] = new sb_nav_list_div($upr, 'Project records');
	
	$n = new sb_nav($d,'Projects');

	$sdbr = new sidebar($ib, $n);
	echo $sdbr->html_out;
	
?>
	</body>
</html>