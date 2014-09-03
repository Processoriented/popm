<?php
	require_once 'app_config.php';
	require_once 'database_connection.php';
	
	class SimpleXMLExtended extends SimpleXMLElement {
	  public function addCData($cdata_text) {
		$node = dom_import_simplexml($this); 
		$no   = $node->ownerDocument; 
		$node->appendChild($no->createCDATASection($cdata_text)); 
	  } 
	}

	//Make sure a table was requested
	if (isset($_REQUEST['user'])) {

		
		$connection = new ConnectdB();
		$connection->connect();
		
		$sql = sprintf("SELECT p.id ,p.title ,p.start_date ,p.finish_date ,p.manager_id ,p.description ,p.last_update FROM project p INNER JOIN project_resource pr ON pr.project_id = p.id INNER JOIN resource r ON pr.resource_id = r.id WHERE r.user_id = %d",$_REQUEST['user']); 
			
			

		if(!$results = $connection->my_conn->query($sql)){
			handle_error('There was an error running the query.', $connection->my_conn->error);
		}
		
		$xml = new SimpleXMLExtended('<?xml version="1.0" encoding="utf-8"?><info/>');
		

		while ($rec = mysqli_fetch_assoc($results)) {
			$my_data = $xml->addChild("project");
			
			foreach($rec as $key => $value) {
				if ($key == 'description') {
					// handle CData
					$my_data->$key = NULL;
					$my_data->$key->addCData($value);
				} elseif ($key == 'id') {
					$my_data->addAttribute('id',$value);
					$my_data->$key = $value;
				} else {
					$my_data->$key = $value;
				}
			}
		}
		$results->free();
		
		foreach($xml->children() as $proj) {
						
			$proj_id = $proj['id'];
			
			$team = $proj->addChild('team');
			
			$tsql = sprintf("SELECT u.user_id,first_name,last_name,email,r.name as role, role_id\n"
			. "FROM project_resource p\n"
			. "INNER JOIN resource u\n"
			. "	ON u.id = p.resource_id\n"
			. "INNER JOIN role r\n"
			. "	ON r.id = p.role_id\n"
			. "WHERE p.project_id = %d",$proj_id);
			
			if(!$tresults = $connection->my_conn->query($tsql)){
				handle_error('There was an error running the query.', $connection->my_conn->error);
			}
			
			while ($trec = mysqli_fetch_assoc($tresults)) {
				$my_tdata = $team->addChild('member');
				foreach($trec as $key => $value) {
					$my_tdata->$key = $value;
				}
			}
			$tresults->free();			
		} 
		
		$connection->close();
		
		header ("Content-Type:text/xml");
		echo $xml->asXML();
    exit();
	}  else {
		handle_error('No table was requested','');
	}
		
?>