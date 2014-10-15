<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 15.10.14
 * Time: 17:58
 */

namespace test\PDOSqlBuilder\Builder;


use PDOSqlBuilder\Builder\WhereBuilder;

class WhereBuilderTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var WhereBuilder
	 */
	private $wb;

	public function setUp()
	{
		$this->wb = new WhereBuilder();
	}

	public function testEqualsBoolTrue()
	{
		$this->wb->addCondition('a', true);
		$this->assertEquals('(a = ?)', $this->wb->getConditions());
		$this->assertEquals(1, current($this->wb->getParameters()));
	}

	public function testEqualsBoolFalse()
	{
		$this->wb->addCondition('a', false);
		$this->assertEquals('(a = ?)', $this->wb->getConditions());
		$this->assertEquals(0, current($this->wb->getParameters()));
	}

	public function testEqualsInt()
	{
		$this->wb->addCondition('a', 1);
		$this->assertEquals('(a = ?)', $this->wb->getConditions());
		$this->assertEquals(1, current($this->wb->getParameters()));
	}

	public function testEqualsString()
	{
		$this->wb->addCondition('a', 'a');
		$this->assertEquals('(a = ?)', $this->wb->getConditions());
		$this->assertEquals('a', current($this->wb->getParameters()));
	}

	public function testInInt()
	{
		$this->wb->addCondition('a', array(1, 2));
		$this->assertEquals('(a IN (?,?))', $this->wb->getConditions());
		$this->assertEquals(1, current($this->wb->getParameters()));
		$this->assertEquals(2, next($this->wb->getParameters()));
	}

	public function testInString()
	{
		$this->wb->addCondition('a', array('a', 'b'));
		$this->assertEquals('(a IN (?,?))', $this->wb->getConditions());
		$this->assertEquals('a', current($this->wb->getParameters()));
		$this->assertEquals('b', next($this->wb->getParameters()));
	}

	public function testMass()
	{
		$this->wb->addCondition(array(
			'a' => 1,
			'b' => array('a', 'b')
		));

		$this->assertEquals('(a = ?) AND (b IN (?,?))', $this->wb->getConditions());
		$params = $this->wb->getParameters();
		$this->assertEquals(3, count($params));
		$this->assertEquals(1, $params[0]);
		$this->assertEquals('a', $params[1]);
		$this->assertEquals('b', $params[2]);
	}

	public function testOrByValue()
	{
		$this->wb->addCondition('a = ? OR b = ?', 1);
		$this->assertEquals('(a = ? OR b = ?)', $this->wb->getConditions());
		$params = $this->wb->getParameters();
		$this->assertEquals(2, count($params));
		$this->assertEquals(1, $params[0]);
		$this->assertEquals(1, $params[1]);
	}

	public function testOrByValues()
	{
		$this->wb->addCondition('a = ? AND b = ?', array(1, 2));
		$this->assertEquals('(a = ? AND b = ?)', $this->wb->getConditions());
		$params = $this->wb->getParameters();
		$this->assertEquals(2, count($params));
		$this->assertEquals(1, $params[0]);
		$this->assertEquals(2, $params[1]);
	}
}
 