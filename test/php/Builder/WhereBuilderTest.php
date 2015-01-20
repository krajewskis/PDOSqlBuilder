<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 15.10.14
 * Time: 17:58
 */



use PPDO\Builder\WhereBuilder;

class WhereBuilderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var WhereBuilder
	 */
	private $whereBuilder;

	public function setUp()
	{
		$this->whereBuilder = new WhereBuilder();
	}

	public function testEqualsBoolTrue()
	{
		$this->whereBuilder->addCondition('a', true);
		$this->assertEquals('(a = ?)', $this->whereBuilder->getConditions());
		$this->assertEquals(1, current($this->whereBuilder->getParameters()));
	}

	public function testEqualsBoolFalse()
	{
		$this->whereBuilder->addCondition('a', false);
		$this->assertEquals('(a = ?)', $this->whereBuilder->getConditions());
		$this->assertEquals(0, current($this->whereBuilder->getParameters()));
	}

	public function testEqualsInt()
	{
		$this->whereBuilder->addCondition('a', 1);
		$this->assertEquals('(a = ?)', $this->whereBuilder->getConditions());
		$this->assertEquals(1, current($this->whereBuilder->getParameters()));
	}

	public function testInInt()
	{
		$this->whereBuilder->addCondition('a', array(1, 2));
		$this->assertEquals('(a IN (?,?))', $this->whereBuilder->getConditions());
		$this->assertEquals(1, current($this->whereBuilder->getParameters()));
		$this->assertEquals(2, next($this->whereBuilder->getParameters()));
	}

	public function testHigherThanInt()
	{
		$this->whereBuilder->addCondition('a > ?', 1);
		$this->assertEquals('(a > ?)', $this->whereBuilder->getConditions());
		$this->assertEquals(1, current($this->whereBuilder->getParameters()));
	}

	public function testLowerThanInt()
	{
		$this->whereBuilder->addCondition('a < ?', 1);
		$this->assertEquals('(a < ?)', $this->whereBuilder->getConditions());
		$this->assertEquals(1, current($this->whereBuilder->getParameters()));
	}

	public function testBetweenInt()
	{
		$this->whereBuilder->addCondition('a > ?', 1);
		$this->whereBuilder->addCondition('a < ?', 10);
		$this->assertEquals('(a > ?) AND (a < ?)', $this->whereBuilder->getConditions());
		$parameters = $this->whereBuilder->getParameters();
		$this->assertEquals(1, $parameters[0]);
		$this->assertEquals(10, $parameters[1]);
	}

	public function testHigherThanTime()
	{
		$this->whereBuilder->addCondition('a > ?', 'now()');
		$this->assertEquals('(a > ?)', $this->whereBuilder->getConditions());
		$this->assertEquals('now()', current($this->whereBuilder->getParameters()));
	}

	public function testLowerThanTime()
	{
		$this->whereBuilder->addCondition('a < ?', 'now()');
		$this->assertEquals('(a < ?)', $this->whereBuilder->getConditions());
		$this->assertEquals('now()', current($this->whereBuilder->getParameters()));
	}

	public function testEqualsString()
	{
		$this->whereBuilder->addCondition('a', 'a');
		$this->assertEquals('(a = ?)', $this->whereBuilder->getConditions());
		$this->assertEquals('a', current($this->whereBuilder->getParameters()));
	}

	public function testInString()
	{
		$this->whereBuilder->addCondition('a', array('a', 'b'));
		$this->assertEquals('(a IN (?,?))', $this->whereBuilder->getConditions());
		$this->assertEquals('a', current($this->whereBuilder->getParameters()));
		$this->assertEquals('b', next($this->whereBuilder->getParameters()));
	}

	public function testArrayOne()
	{
		$this->whereBuilder->addCondition(array(
			'a' => 1,
		));

		$this->assertEquals('(a = ?)', $this->whereBuilder->getConditions());
		$params = $this->whereBuilder->getParameters();
		$this->assertEquals(1, count($params));
		$this->assertEquals(1, $params[0]);
	}

	public function testArrayFew()
	{
		$this->whereBuilder->addCondition(array(
			'a' => 1,
			'b' => array('a', 'b')
		));

		$this->assertEquals('(a = ?) AND (b IN (?,?))', $this->whereBuilder->getConditions());
		$params = $this->whereBuilder->getParameters();
		$this->assertEquals(3, count($params));
		$this->assertEquals(1, $params[0]);
		$this->assertEquals('a', $params[1]);
		$this->assertEquals('b', $params[2]);
	}

	public function testOrByValue()
	{
		$this->whereBuilder->addCondition('a = ? OR b = ?', 1);
		$this->assertEquals('(a = ? OR b = ?)', $this->whereBuilder->getConditions());
		$params = $this->whereBuilder->getParameters();
		$this->assertEquals(2, count($params));
		$this->assertEquals(1, $params[0]);
		$this->assertEquals(1, $params[1]);
	}

	public function testOrByValues()
	{
		$this->whereBuilder->addCondition('a = ? AND b = ?', array(1, 2));
		$this->assertEquals('(a = ? AND b = ?)', $this->whereBuilder->getConditions());
		$params = $this->whereBuilder->getParameters();
		$this->assertEquals(2, count($params));
		$this->assertEquals(1, $params[0]);
		$this->assertEquals(2, $params[1]);
	}
}
 