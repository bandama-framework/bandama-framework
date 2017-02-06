<?php

namespace Bandama\Foundation\Database;

use PDO;
use PDOException;
use Exception;

/**
 * Database connection class
 *
 * @package Bandama
 * @subpackage Foundation\Database
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.0 Class creation
 */
class Connection {
	// Fields

	/**
	 * @var string Database driver name e.g (pdo_mysql, etc.)
	 */
	protected $driver;

	/**
	 * @var string Database server host name e.g (localhost)
	 */
	protected $host;

	/**
	 * @var int Datase port
	 */
	protected $port;

	/**
	 * @var string Database name
	 */
	protected $database;

	/**
	 * @var string Database user
	 */
	protected $user;

	/**
	 * @var string Database password
	 */
	protected $password;


	// Properties

	/**
	 * Get database connection driver
	 *
	 * @return string
	 */
	public function getDriver(){
		return $this->driver;
	}

	/**
	 * Get database host
	 *
	 * @return string
	 */
	public function getHost(){
		return $this->host;
	}

	/**
	 * Get database port
	 *
	 * @return int
	 */
	public function getPort(){
		return $this->host;
	}

	/**
	 * Get database name
	 *
	 * @return string
	 */
	public function getDatabase(){
		return $this->database;
	}

	/**
	 * Get database user
	 *
	 * @return string
	 */
	public function getUser(){
		return $this->user;
	}

	// Constructors

	/**
	 * Constructor
	 *
	 * @param array $parameters Array of database connection parameters
	 *
	 * @return void
	 */
	function __construct($parameters){
		$this->driver = $parameters["database_driver"];
		$this->host = $parameters["database_host"];
		$this->port = $parameters["database_port"];
		$this->database = $parameters["database_name"];
		$this->user = $parameters["database_user"];
		$this->password = $parameters["database_password"];
	}

	// Public Methods

	/**
	 * Create a new database connection
	 *
	 * @throws PDOException If there is unable to connect to database
	 * @throws Exception If an error occurs
	 *
	 * @return PDO
	 */
	public function getConnection(){
		try{
			switch($this->driver){
				case "pdo_mysql":
					return new PDO("mysql:host=".$this->host.";dbname=".$this->database.";charset=utf8", $this->user, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
				case "pdo_sqlserver":
					return new PDO("sqlsrv:Server=".$this->host.";Database=".$this->database, $this->user, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
			}
		}catch(PDOException $e){
			throw new PDOException('Unable to connect to database, errorMessage = '.$e->getMessage());
		}catch(Exception $e){
			throw new Exception('Internal error, errorMessage = '.$e->getMessage());
		}
	}

	/**
	 * @see Connection::getConnection()
	 */
	public function open(){
		return $this->getConnection();
	}

	/**
	 * @see Connection::getConnection()
	 */
	public function connect() {
		return $this->getConnection();
	}
}
