<?php

namespace Bandama\Foundation\Session;

use Bandama\Foundation\Database\Connection;


/**
 * Class for managing PDO database sessions
 *
 * @package Bandama
 * @subpackage Foundation\Session
 * @see \SessionHandlerInterface
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.0 Class creation
 */
class PDOSessionHandler implements \SessionHandlerInterface {
    // Fields
    /**
     * @var Bandama\Foundation\Database\Connection Connection object
     */
    protected $connection = null;

    /**
     * @var string Name of table containing session informations
     */
    protected $tableName = 'sessions';

    /**
     * @var string Name of session id column
     */
    protected $columnSessionId = 'session_id';

    /**
     * @var string Name of session data column
     */
    protected $columnSessionData = 'session_data';

    /**
     * @var string Name of session lifetime column
     */
    protected $columnSessionLifetime = 'session_lifetime';

    /**
     * @var string Name of created at column
     */
    protected $columnCreatedAt = 'created_at';

    /**
     * @var string Name of updated at column
     */
    protected $columnUpdatedAt = 'updated_at';

    /**
     * @var boolean Indicate of create new record in database or update an existing record
     */
    protected $isNewRecord = true;


    // Constructors
    /**
     * Constructor
     *
     * @var \Bandama\Foundation\Database\Connection $connection Database connection object
     * @var array $params Session table parameters
     *
     * @return void
     */
    public function __construct(Connection $connection, $params = array()) {
        $this->connection = $connection;

        if (isset($params['table_name'])) {
            $this->tableName = $params['table_name'];
        }

        if (isset($params['col_session_id'])) {
            $this->columnSessionId = $params['col_session_id'];
        }

        if (isset($params['col_session_data'])) {
            $this->columnSessionData = $params['col_session_data'];
        }

        if (isset($params['col_session_lifetime'])) {
            $this->columnSessionLifetime = $params['col_session_lifetime'];
        }

        if (isset($params['col_created_at'])) {
            $this->columnCreatedAt = $params['col_created_at'];
        }

        if (isset($params['col_updated_at'])) {
            $this->columnUpdatedAt = $params['col_updated_at'];
        }
    }

    // Overrides
    /**
     * @see \SessionHandlerInterface::open
     */
    public function open($savePath ,$name) {
        if($this->connection->open()) {
            $this->connection->close();

            return true;
        } else {
            return false;
        }
    }

    /**
     * @see \SessionHandlerInterface::close
     */
    public function close() {
        $this->connection->close();

        return true;
    }

    /**
     * @see \SessionHandlerInterface::read
     */
    public function read($sessionId) {
        $data = '';

        $db = $this->connection->open();
        $result = $db->query("SELECT * FROM {$this->tableName} WHERE {$this->columnSessionId} = '$sessionId'");

        if ($result) {
            if ($row = $result->fetch()) {
                $data = $row[$this->columnSessionData];
                $this->isNewRecord = false;
            }

            $result->closeCursor();
        }

        $this->connection->close();

        return $data;
    }

    /**
     * @see \SessionHandlerInterface::write
     */
    public function write($sessionId , $sessionData) {
        $result = false;
        $db = $this->connection->open();

        if ($this->isNewRecord == true) {
            $query = $db->prepare("INSERT INTO {$this->tableName}({$this->columnSessionId}, {$this->columnSessionData}, {$this->columnSessionLifetime}, {$this->columnCreatedAt}, {$this->columnUpdatedAt}) VALUES(:session_id, :session_data, :session_lifetime, :created_at, :updated_at);");
            $result = $query->execute(array(
                'session_id' => $sessionId,
                'session_data' => $sessionData,
                'session_lifetime' => 1440,
                'created_at' => time(),
                'updated_at' => time()
            ));
        } else {
            $query = $db->prepare("UPDATE {$this->tableName} SET {$this->columnSessionData} = :session_data, {$this->columnSessionLifetime} = :session_lifetime, {$this->columnUpdatedAt} = :updated_at WHERE {$this->columnSessionId} = :session_id;");

            $result = $query->execute(array(
                'session_data' => $sessionData,
                'session_lifetime' => 1440,
                'updated_at' => time(),
                'session_id' => $sessionId
            ));
        }

        $this->connection->close();

        return $result;
    }

    /**
     * @see \SessionHandlerInterface::destroy
     */
    public function destroy($sessionId) {
        $result = false;
        $db = $this->connection->open();
        $query = $db->prepare("DELETE FROM {$this->tableName} WHERE {$this->columnSessionId} = :session_id;");

        $result = $query->execute(array(
            'session_id' => $sessionId
        ));

        return $result;
    }

    /**
     * @see \SessionHandlerInterface::gc
     *
     */
    public function gc($maxlifetime) {
        return true;
    }
}
