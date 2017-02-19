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
 * @version 1.0.1
 * @since 1.0.1 Adding PDO attributes, support for Oracle, SQLite, PostgreSQL database; adding field to store current PDO object, adding close method
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

	/**
	 * @var array Define attributes for PDO object
	 */
	protected $attributes;

	/**
	 * @var \PDO PDO object
	 */
	 protected $pdo;


	// Properties
	/**
	 * Get database connection driver
	 *
	 * @return string
	 */
	public function getDriver() {
		return $this->driver;
	}

	/**
	 * Get database host
	 *
	 * @return string
	 */
	public function getHost() {
		return $this->host;
	}

	/**
	 * Get database port
	 *
	 * @return int
	 */
	public function getPort() {
		return $this->host;
	}

	/**
	 * Get database name
	 *
	 * @return string
	 */
	public function getDatabase() {
		return $this->database;
	}

	/**
	 * Get database user
	 *
	 * @return string
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * Get PDO objct attributes
	 *
	 * @return array
	 */
	public function getAttributes() {
		return $this->attributes;
	}

	/**
	 * Get PDO object
	 *
	 * @return \PDO
	 */
	public function getPDO() {
		return $this->pdo;
	}

	// Constructors
	/**
	 * Constructor
	 *
	 * @param array $parameters Array of database connection parameters
	 *
	 * @return void
	 */
	function __construct($parameters) {
		$this->driver = $parameters["database_driver"];
		$this->host = $parameters["database_host"];
		$this->port = $parameters["database_port"];
		$this->database = $parameters["database_name"];
		$this->user = $parameters["database_user"];
		$this->password = $parameters["database_password"];
		if (isset($parameters['attributes'])) {
			$this->attributes = $parameters['attributes'];
		} else {
			$this->attributes = array();
		}
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
	public function getConnection() {
		try {
			$pdo = null;

			switch($this->driver){
				case "pdo_mysql": // MySQL Database
					$pdo = new PDO("mysql:host=".$this->host.";dbname=".$this->database.";charset=utf8", $this->user, $this->password);
					break;
				case "pdo_sqlserver": // SQL Server Database
					$pdo = new PDO("sqlsrv:Server=".$this->host.";Database=".$this->database, $this->user, $this->password);
					break;
				case "pdo_sqlite": // SQLite Database
				    $pdo = new PDO("sqlite:{$this->database}");
					break;
				case "pdo_pgsql": // PostgreSQL Database
				    $pdo = new PDO("pgsql:dbname={$this->database};host={$this->host}", $this->user, $this->password);
				    break;
				case "pdo_oci": // Oracle Database
					$tns = "oci:dbname=(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP) (Host = {$this->host}) (Port = {$this->port}))) (CONNECT_DATA = (SERVICE_NAME = {$this->database})))";
					$pdo = new PDO($tns, $this->user, $this->password);
					break;
				default:
					throw new  Exception("Database driver not defined");
				}

				if (count($this->attributes) > 0) {
					foreach ($this->attributes as $key => $value) {
						$pdo->setAttribute($key, $value);
					}
				}

				$this->pdo = $pdo;

				return $pdo;

		} catch (PDOException $e) {
			throw new PDOException('Unable to connect to database, errorMessage = '.$e->getMessage());
		} catch (Exception $e) {
			throw new Exception('Internal error, errorMessage = '.$e->getMessage());
		}
	}

	/**
	 * @see Connection::getConnection()
	 */
	public function open() {
		return $this->getConnection();
	}

	/**
	 * @see Connection::getConnection()
	 */
	public function connect() {
		return $this->getConnection();
	}

	/**
	 * Close connection to database
	 *
	 * @return void
	 */
	public function close() {
		$this->pdo = null;
	}
}
