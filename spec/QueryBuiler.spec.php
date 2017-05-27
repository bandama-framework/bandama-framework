<?php

use \Bandama\Foundation\Database\QueryBuilder;

describe(QueryBuilder::class, function() {

    given('query', function() {
        return new QueryBuilder();
    });

    describe('::select()', function() {
        it('select everything from table', function() {
            $this->query->select('*')->from('table');
            expect(strval($this->query))->toEqual('SELECT * FROM table;');
        });

        it('select one field', function() {
            $this->query->select('id')->from('table');
            expect(strval($this->query))->toEqual('SELECT id FROM table;');
        });

        it('select n fields', function() {
            $this->query->select('id, first_name, last_name, email')->from('table');
            expect(strval($this->query))->toEqual('SELECT id, first_name, last_name, email FROM table;');
        });
    });

    describe('::from()', function() {
        it('select from one table without alias', function() {
            $this->query->select('id, first_name, last_name, email')->from('table');
            expect(strval($this->query))->toEqual('SELECT id, first_name, last_name, email FROM table;');
        });

        it('select from n tables without alias', function() {
            $this->query->select('id, first_name, last_name, email')->from('table1')->from('table2');
            expect(strval($this->query))->toEqual('SELECT id, first_name, last_name, email FROM table1, table2;');
        });

        it('select from one table with alias', function() {
            $this->query->select('id, first_name, last_name, email')->from('table', 't');
            expect(strval($this->query))->toEqual('SELECT id, first_name, last_name, email FROM table AS t;');
        });

        it('select from n tables with alias', function() {
            $this->query->select('id, first_name, last_name, email')->from('table1', 't1')->from('table2', 't2');
            expect(strval($this->query))->toEqual('SELECT id, first_name, last_name, email FROM table1 AS t1, table2 AS t2;');
        });
    });

    describe('::where()', function() {
        it('select with empty where statement', function() {
            $this->query->select('*')->from('table');
            expect(strval($this->query))->toEqual('SELECT * FROM table;');
        });

        it('select with where statement with one condition', function() {
            $this->query->select('*')->from('table')->where('id = 1');
            expect(strval($this->query))->toEqual('SELECT * FROM table WHERE id = 1;');
        });

        it('select with where statement with n conditions', function() {
            $this->query->select('*')->from('table')->where('id = 1', "name = 'name'");
            expect(strval($this->query))->toEqual("SELECT * FROM table WHERE id = 1 AND name = 'name';");
        });
    });
});
