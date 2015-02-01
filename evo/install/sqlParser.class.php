<?php

// MySQL Dump Parser
// SNUFFKIN/ Alex 2004

class SqlParser {
	var $prefix, $mysqlErrors;
	var $conn, $installFailed, $sitename, $adminname, $adminemail, $adminpass, $managerlanguage;
	var $mode;
	var $dbVersion;
    var $connection_charset, $connection_collation, $ignoreDuplicateErrors;
    var $base_path;

	function SqlParser() {
		$this->prefix = 'modx_';
		$this->adminname = 'admin';
		$this->adminpass = 'password';
		$this->adminemail = 'example@example.com';
		$this->connection_charset = 'utf8';
		$this->connection_collation = 'utf8_general_ci';
		$this->ignoreDuplicateErrors = false;
		$this->managerlanguage = 'english';
	}

	function process($filename) {
	    global $modx,$modx_version;

		$this->dbVersion = 3.23; // assume version 3.23
		if(function_exists("mysql_get_server_info")) {
			$ver = mysql_get_server_info();
			$this->dbVersion = (float) $ver; // Typecasting (float) instead of floatval() [PHP < 4.2]
		}
		
		// check to make sure file exists
		$path = "{$this->base_path}install/sql/{$filename}";
		if (!is_file($path)) {
			$this->mysqlErrors[] = array("error" => "File '$path' not found");
			$this->installFailed = true ;
			return false;
		}
		
		$idata = file_get_contents($path);
		
		$idata = str_replace("\r", '', $idata);
		
		if(version_compare($this->dbVersion,'4.1.0', '>='))
		{
			$char_collate = "DEFAULT CHARSET={$this->connection_charset} COLLATE {$this->connection_collation}";
			$idata = str_replace('ENGINE=MyISAM', "ENGINE=MyISAM {$char_collate}", $idata);
		}
		
		// replace {} tags
		$ph = array();
		$ph['PREFIX']            = $this->prefix;
		$ph['ADMINNAME']         = $this->adminname;
		$ph['ADMINFULLNAME']     = substr($this->adminemail,0,strpos($this->adminemail,'@'));
		$ph['ADMINEMAIL']        = $this->adminemail;
		$ph['ADMINPASS']         = genHash($this->adminpass, '1');
		$ph['MANAGERLANGUAGE']   = $this->managerlanguage;
		$ph['DATE_NOW']          = time();
		$idata = parse($idata,$ph,'{','}');
		
		$sql_array = preg_split('@;[ \t]*\n@', $idata);
		
		$num = 0;
		foreach($sql_array as $sql_entry)
		{
			$sql_do = trim($sql_entry, "\r\n; ");
			$num++;
			if ($sql_do) mysql_query($sql_do);
			if(mysql_error())
			{
				// Ignore duplicate and drop errors - Raymond
				if ($this->ignoreDuplicateErrors)
				{
					if (mysql_errno() == 1060 || mysql_errno() == 1061 || mysql_errno() == 1091) continue;
				}
				// End Ignore duplicate
				$this->mysqlErrors[] = array("error" => mysql_error(), "sql" => $sql_do);
				$this->installFailed = true;
			}
		}
	}

}
