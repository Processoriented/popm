<?php
	require_once 'app_config.php';
	require_once 'database_connection.php';

	//Make sure a table was requested
	if (isset($_REQUEST['proj'])) {

		
		$connection = new ConnectdB();
		$connection->connect();
		
		$sql = sprintf("SELECT first_name,last_name,email,r.name as role, role_id\n"
			. "FROM project_resource p\n"
			. "INNER JOIN resource u\n"
			. "	ON u.id = p.resource_id\n"
			. "INNER JOIN role r\n"
			. "	ON r.id = p.role_id\n"
			. "WHERE p.project_id = %d",$_REQUEST['proj']); 
			
			

		if(!$results = $connection->my_conn->query($sql)){
			handle_error('There was an error running the query.', $connection->my_conn->error);
		}
		
		$xml = new SimpleXMLElement("<team/>");
	
		while ($rec = mysqli_fetch_assoc($results)) {
			$my_data = $xml->addChild("member");
			
			foreach($rec as $key => $value) {
				$my_data->$key = $value;
			}
		}
		$results->free();
		$connection->close();
		
		header ("Content-Type:text/xml");
		// echo '<p>hello world</p>';
		echo $xml->asXML();
    exit();
	}  else {
		handle_error('No table was requested','');
	}
		
?>