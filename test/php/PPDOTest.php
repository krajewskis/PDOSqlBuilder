<?php

/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 2.12.14
 * Time: 12:38
 */

use PPDO\PPDO;

class PPDOTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var PPDO
	 */
	private $ppdo;

	public function setUp()
	{
		$pdo = new PDO('sqlite::memory:');
//		$pdo = $this->getMock('PDO', array(), array(), '', false);
		$this->ppdo = new PPDO($pdo);
	}

	public function testFrom()
	{
		$instance = $this->ppdo->from('test');
		$this->assertInstanceOf('PPDO\Query\SelectQuery', $instance);
	}

	public function testInsertInto()
	{
		$instance = $this->ppdo->insertInto('test');
		$this->assertInstanceOf('PPDO\Query\InsertQuery', $instance);
	}

	public function testUpdate()
	{
		$instance = $this->ppdo->update('test');
		$this->assertInstanceOf('PPDO\Query\UpdateQuery', $instance);
	}

	public function testDelete()
	{
		$instance = $this->ppdo->delete('test');
		$this->assertInstanceOf('PPDO\Query\DeleteQuery', $instance);
	}
} 