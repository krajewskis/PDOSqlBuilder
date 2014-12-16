<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 3.12.14
 * Time: 16:11
 */


require_once __DIR__ . '/AbstractSelectQueryTest.php';


class MySQLAbstractSelectQueryTest extends AbstractSelectQueryTest
{
	public function setUp()
	{
		parent::setUp(new \PDO('mysql:host=localhost;dbname=sql_builder', 'sql_builder', '27N6ST7W1m43rCK'), __DIR__ . '/../../../../sql/mysql.sql');
	}
}