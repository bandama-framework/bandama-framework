<?php

namespace Bandama\Test;

use Bandama\Foundation\Database\QueryBuilder;


class QueryBuilderTest extends \PHPUnit_Framework_TestCase {	

    public function testSelectEverythingFromTable() {
        $query = new QueryBuilder();
        $query->select('*')->from('table');
        $this->assertEquals(strval($query), 'SELECT * FROM table;');
    }

    public function testSelectOneField() {
        $query = new QueryBuilder();
        $query->select('id')->from('table');
        $this->assertEquals(strval($query), 'SELECT id FROM table;');
    }

    public function testSelectNFields() {
        $query = new QueryBuilder();
        $query->select('id, first_name, last_name, email')->from('table');
        $this->assertEquals(strval($query), 'SELECT id, first_name, last_name, email FROM table;');
    }

    public function testFromOneTableWithoutAlias() {
        $query = new QueryBuilder();
        $query->select('id, first_name, last_name, email')->from('table');
        $this->assertEquals(strval($query), 'SELECT id, first_name, last_name, email FROM table;');
    }

    public function testFromNTablesWithoutAlias() {
        $query = new QueryBuilder();
        $query->select('id, first_name, last_name, email')->from('table1')->from('table2');
        $this->assertEquals(strval($query), 'SELECT id, first_name, last_name, email FROM table1, table2;');
    }

    public function testFromOneTableWithAlias() {
        $query = new QueryBuilder();
        $query->select('id, first_name, last_name, email')->from('table', 't');
        $this->assertEquals(strval($query), 'SELECT id, first_name, last_name, email FROM table AS t;');
    }

    public function testFromNTablesWithAlias() {
        $query = new QueryBuilder();
        $query->select('id, first_name, last_name, email')->from('table1', 't1')->from('table2', 't2');
        $this->assertEquals(strval($query), 'SELECT id, first_name, last_name, email FROM table1 AS t1, table2 AS t2;');
    }

    public function testWhereEmpty() {
        $query = new QueryBuilder();
        $query->select('*')->from('table');
        $this->assertEquals(strval($query), 'SELECT * FROM table;');
    }

    public function testWhereWithOneCondition() {
        $query = new QueryBuilder();
        $query->select('*')->from('table')->where('id = 1');
        $this->assertEquals(strval($query), 'SELECT * FROM table WHERE id = 1;');
    }

    public function testWhereWithNCondition() {
        $query = new QueryBuilder();
        $query->select('*')->from('table')->where('id = 1', "name = 'name'");
        $this->assertEquals(strval($query), "SELECT * FROM table WHERE id = 1 AND name = 'name';");
    }
}