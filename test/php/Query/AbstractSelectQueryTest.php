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

	public function testLimit()
	{
		$list = $this->selectQuery->limit(1)->fetchAll(\PDO::FETCH_OBJ);
		$this->assertEquals(1, count($list));
	}

	public function testWhereEqualsBoolTrue()
	{
		$list = $this->selectQuery->where('status1', true)->fetchAll(\PDO::FETCH_OBJ);
		$this->assertEquals(1, $list[0]->status1);
	}

	public function testWhereEqualsBoolFalse()
	{
		$list = $this->selectQuery->where('status1', false)->fetchAll(\PDO::FETCH_OBJ);
		$this->assertEquals(0, $list[0]->status1);
	}

	public function testWhereEqualsInt()
	{
		$list = $this->selectQuery->where('id', 1)->fetchAll(\PDO::FETCH_OBJ);
		$this->assertEquals(1, $list[0]->id);
	}

	public function testWhereEqualsString()
	{
		$list = $this->selectQuery->where('code', 'FIRST')->fetchAll(\PDO::FETCH_OBJ);
		$this->assertEquals('FIRST', $list[0]->code);
	}

	public function testWhereInInt()
	{
		$list = $this->selectQuery->where('id', array(1, 2))->fetchAll(\PDO::FETCH_OBJ);
		$this->assertEquals(1, $list[0]->id);
		$this->assertEquals(2, $list[1]->id);
	}

	public function testWhereInString()
	{
		$list = $this->selectQuery->where('code', array('FIRST', 'SECOND'))->fetchAll(\PDO::FETCH_OBJ);
		$this->assertEquals('FIRST', $list[0]->code);
		$this->assertEquals('SECOND', $list[1]->code);
	}

	public function testWhereArrayOne()
	{
		$list = $this->selectQuery->where(array('id' => 1))->fetchAll(\PDO::FETCH_OBJ);
		$this->assertEquals(1, $list[0]->id);
	}

	public function testWhereArrayFew()
	{
		$list = $this->selectQuery->where(array('id' => 1, 'code' => array('FIRST', 'SECOND')))->fetchAll(\PDO::FETCH_OBJ);
		$this->assertEquals(1, $list[0]->id);
		$this->assertEquals('FIRST', $list[0]->code);
	}

	public function testWhereOrByValue()
	{
		$list = $this->selectQuery->where('id = ? OR id = ?', 1)->fetchAll(\PDO::FETCH_OBJ);
		$this->assertEquals(1, $list[0]->id);
	}

	public function testWhereOrByValues()
	{
		$list = $this->selectQuery->where('id = ? OR id = ?', array(1, 2))->fetchAll(\PDO::FETCH_OBJ);
		$this->assertEquals(1, $list[0]->id);
		$this->assertEquals(2, $list[1]->id);
	}
}