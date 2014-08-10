<?php
  require_once 'app_config.php';

  if (!mysql_connect(DATABASE_HOST, 
                     DATABASE_USERNAME, DATABASE_PASSWORD)) {
    handle_error("There was a problem connecting to the database " .
                 "that holds the information we need to get you connected.",
                 mysql_error());
  }

   if (!mysql_select_db(DATABASE_NAME)) {
    handle_error("There's a configuration problem with our database.", 
                 mysql_error());
  }  

class con_POPM_dB extends mysqli {
	protected static $instance;
	protected static $options = array();

    protected function __construct() {
        $o = self::$options;

        // turn of error reporting
        mysqli_report(MYSQLI_REPORT_OFF);

        // connect to database
        @parent::__construct(isset($o['host'])   ? $o['host']   : DATABASE_HOST,
                             isset($o['user'])   ? $o['user']   : DATABASE_USERNAME,
                             isset($o['pass'])   ? $o['pass']   : DATABASE_PASSWORD,
                             isset($o['dbname']) ? $o['dbname'] : DATABASE_NAME);

        // check if a connection established
        if( mysqli_connect_errno() ) {
            throw new exception(mysqli_connect_error(), mysqli_connect_errno()); 
        }
    }

    public static function getInstance() {
        if( !self::$instance ) {
            self::$instance = new self(); 
        }
        return self::$instance;
    }

    public static function setOptions( array $opt ) {
        self::$options = array_merge(self::$options, $opt);
    }

    public function query($query) {
        if( !$this->real_query($query) ) {
            throw new exception( $this->error, $this->errno );
        }

        $result = new mysqli_result($this);
        return $result;
    }

    public function prepare($query) {
        $stmt = new mysqli_stmt($this, $query);
        return $stmt;
    }    
}
class proj_data extends con_POPM_dB {
	public $projects;
	protected static $instance;
	
	public static function getInstance() {
		if( !self::$instance ) {
	    		self::$instance = new self(); 
		}
		return self::$instance;
	}
	public function getNavData($user_id) {
		self::getInstance();
		
		$query = sprintf("SELECT p.id, p.title, p.start_date, p.description "
				. "FROM project p INNER JOIN project_resource pr "
				. "ON pr.project_id = p.id "
				. "INNER JOIN resource r ON r.id = pr.resource_id "
				. "WHERE r.user_id = %d "
				. "ORDER BY p.start_date;"
				, $user_id);
		$results = $this->query($query);
		if ($results->num_rows > 0) {
			while($result = $results->fetch_assoc()) {
				$ps[] = $result;
			}
			$this->projects = $ps;
			return $this->projects;
		} else { throw new exception( 'No Results Returned : '. $query ); }
	}
}

class ConnectdB {
	private $db_host = DATABASE_HOST;
	private $db_user = DATABASE_USERNAME;
	private $db_pass = DATABASE_PASSWORD;
	private $db = DATABASE_NAME;
	public $my_conn;
	
	public function connect() {
		$con = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db);
		if ($con->connect_errno > 0) {
			//die('Could not connect to database!');
			handle_error("There was a problem connecting to the database " .
                 "that holds the information we need to get you connected.",
                 $con->connect_error);
        } else {
        	$this->my_conn = $con;
        }
        return $this->my_conn;
    }
    
    public function close() {
    	mysqli_close($my_conn);
    }
	
}

class ConnectPDO {
	private $db_host = DATABASE_HOST;
	private $db_user = DATABASE_USERNAME;
	private $db_pass = DATABASE_PASSWORD;
	private $db = DATABASE_NAME;
	public $my_conn;
	public $results;
	
	public function connect() {
		$con = new PDO('mysql:dbname=' . $this->db . ';host=' . $this->db_host, $this->db_user, $this->db_pass);
		if ($con->errorCode > 0) {
			handle_error("There was a problem connecting to the database " .
                		"that holds the information we need to get you connected.",
                		$con->errorInfo);
        	} else {
        		$this->my_conn = $con;
        	}
        	return $this->my_conn;
    	}
	public function close() {
    		$this->my_conn = null;
 	}
}       
?>