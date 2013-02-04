<?php
/**
* DMyers Super Simple MVC
*
* @package    Database for SSMVC
* @language   PHP
* @author     Don Myers
* @copyright  Copyright (c) 2011
* @license    Released under the MIT License.
*/

class Database {
	static public $data = array();

	static public function connect($dsn,$user,$password,$connection='default') {
		/* make connection */
		try {
			$handle = new PDO($dsn , $user, $password);
		} catch (PDOException $e) {
			throw new Exception($e->getMessage());
		}
		
		self::$data[$connection] = $handle;
		
		return $handle;
	}

	static public function connection($connection='default') {
		return self::$data[$connection];
	}
	
	static public function columns($tablename,$connection='default') {
		$connection = self::$data[$connection];
	
		$statement = $connection->prepare('DESCRIBE '.$tablename);
		$statement->execute();
		$table_fields = $statement->fetchAll(PDO::FETCH_COLUMN);
		echo "\$fields = '".implode(',',$table_fields)."';";
	}

}