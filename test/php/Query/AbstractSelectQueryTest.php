<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 3.12.14
 * Time: 16:08
 */

require_once __DIR__ . '/AbstractQueryTest.php';

use PPDO\Query\SelectQuery;

abstract class AbstractSelectQueryTest extends AbstractQueryTest
{
	/**
	 * @var SelectQuery
	 */
	protected $selectQuery;

	public function setUp(\PDO $pdo, $sql)
	{
		parent::setUp($pdo, $sql);
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