<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 3.12.14
 * Time: 16:11
 */


require_once __DIR__ . '/AbstractSelectQueryTest.php';


class SQLiteAbstractSelectQueryTest extends AbstractSelectQueryTest
{
	public function setUp()
	{
		parent::setUp(new \PDO('sqlite:' . __DIR__ . '/../../db/db.sqlite3'), __DIR__ . '/../../sql/sqlite.sql');
//		parent::setUp(new \PDO('sqlite:memory:'), __DIR__ . '/../../sql/sqlite.sql');
	}
}