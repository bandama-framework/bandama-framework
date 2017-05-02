<?php

namespace Bandama\Foundation\Database;

/**
 * Query Builder class, select, where and from methods implement Fluent design pattern
 *
 * @package Bandama
 * @subpackage Foundation\Database
 * @author Jean-François YOBOUE <yoboue.kouamej@live.fr>
 * @version 1.0.0
 * @since 1.0.0 Class creation
 */
class QueryBuilder {
    // Fields
    /**
     * @var array Select fields
     */
    private $fields = array();

    /*
     * @var array Where close
     */
    private $conditions = array();

    /*
     * @var array From tables
     */
    private $from = array();



    // Public methods
    /**
     * Create select statement, implements Fluent design pattern
     *
     *  @return QueryBuilder
     */
    public function select() {
        $this->fields = func_get_args();

        return $this;
    }

    /**
     * Create where statement, implements Fluent design pattern
     *
     * @return QueryBuilder
     */
    public function where() {
        foreach(func_get_args() as $arg) {
            $this->conditions[] = $arg;
        }

        return $this;
    }

    /**
     * Create from statement, implements Fluent design pattern
     *
     * @param string $table Table name
     * @param string $alias Table alias
     *
     * @return QueryBuilder
     */
    public function from($table, $alias = null) {
        if(is_null($alias)) {
            $this->from[] = $table;
        } else {
            $this->from[] = "$table AS $alias";
        }

        return $this;
    }

    /**
     * Build query to generate a string
     *
     * @return string
     */
    public function getQuery() {
        $query = 'SELECT '.implode(', ', $this->fields)
                .' FROM '.implode(', ', $this->from);
        if (count($this->conditions) > 0) {
            $query = $query.' WHERE '.implode(' AND ', $this->conditions);
        }
        $query = rtrim($query).';';

        return $query;
    }


    // Overrides
    /**
     * Convert object to string
     *
     * @see QueryBuilder::getQuery
     *
     * @return string
     */
    public function __toString() {
        return $this->getQuery();
    }
}
