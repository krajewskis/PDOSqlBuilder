<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 2.12.14
 * Time: 12:41
 */



use PPDO\Builder\SelectBuilder;
use PPDO\Builder\WhereBuilder;

class SelectBuilderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var SelectBuilder
	 */
	private $selectBuilder;

	public function setUp()
	{
		$whereBuilder = new WhereBuilder();
		$this->selectBuilder = new SelectBuilder('test', $whereBuilder);
	}

	public function testBuildQuery()
	{
		$query = $this->selectBuilder->build();
		$this->assertEquals('SELECT * FROM test', $query);
	}

	public function testBuildQueryWhere()
	{
		$this->selectBuilder->where('id', 1);
		$this->assertEquals('SELECT * FROM test WHERE (id = ?)', $this->selectBuilder->build());
		$parameters = $this->selectBuilder->getParameters();
		$this->assertInternalType('array', $parameters);
		$this->assertEquals(1, count($parameters));
		$this->assertEquals(1, $parameters[0]);
	}

	public function testBuildQueryOrder()
	{
		$this->selectBuilder->order('id DESC');
		$this->assertEquals('SELECT * FROM test ORDER BY id DESC', $this->selectBuilder->build());
	}

	public function testBuildQueryLimit()
	{
		$query = $this->selectBuilder->limit(100)->build();
		$this->assertEquals('SELECT * FROM test LIMIT 100', $query);
	}

	public function testBuildQueryOffset()
	{
		$query = $this->selectBuilder->offset(100)->build();
		$this->assertEquals('SELECT * FROM test OFFSET 100', $query);
	}

	public function testBuildQueryLimitOffset()
	{
		$query = $this->selectBuilder->limit(100)->offset(100)->build();
		$this->assertEquals('SELECT * FROM test LIMIT 100 OFFSET 100', $query);
	}
}