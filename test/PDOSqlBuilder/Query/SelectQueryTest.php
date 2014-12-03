<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 3.12.14
 * Time: 16:08
 */

namespace test\PDOSqlBuilder\Query;


use PDOSqlBuilder\Query\SelectQuery;

abstract class SelectQueryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var SelectQuery
	 */
	protected $selectQuery;

	protected function setPdo(\PDO $pdo)
	{
		$this->selectQuery = new SelectQuery($pdo, 'test');
	}

	public function testSelect()
	{
		$list = $this->selectQuery->fetchAll(\PDO::FETCH_OBJ);
		$this->assertTrue(count($list) > 1);
	}

	public function testSelectLimit()
	{
		$list = $this->selectQuery->limit(1)->fetchAll(\PDO::FETCH_OBJ);
		$this->assertEquals(1, count($list));
	}
} 