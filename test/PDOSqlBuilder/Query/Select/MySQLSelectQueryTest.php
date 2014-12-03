<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 3.12.14
 * Time: 16:11
 */

namespace test\PDOSqlBuilder\Query\Select;

require_once __DIR__ . '/../SelectQueryTest.php';

use test\PDOSqlBuilder\Query\SelectQueryTest;

class MySQLSelectQueryTest extends SelectQueryTest
{
	public function setUp()
	{
		$this->setPdo(new \PDO('mysql:host=localhost;dbname=sql_builder', 'sql_builder', '27N6ST7W1m43rCK'));
	}
}