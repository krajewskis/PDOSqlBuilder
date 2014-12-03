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

class SQLiteSelectQueryTest extends SelectQueryTest
{
	public function setUp()
	{
		$this->setPdo(new \PDO('sqlite:' . __DIR__ . '/../../../../db/db.sqlite3'));
	}
}