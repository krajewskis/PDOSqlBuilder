<?php

/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 24.9.14
 * Time: 17:07
 */

namespace PPDO;

use PPDO\Query\AbstractQuery;
use PPDO\Query\DeleteQuery;
use PPDO\Query\InsertQuery;
use PPDO\Query\SelectQuery;
use PPDO\Query\UpdateQuery;

class PPDO implements PPDOInterface
{
	private $pdo;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function setDebug($debug)
	{
		AbstractQuery::$debug = $debug;
	}

	public function from($table)
	{
		return new SelectQuery($this->pdo, $table);
	}

	public function insertInto($table)
	{
		return new InsertQuery($this->pdo, $table);
	}

	public function update($table)
	{
		return new UpdateQuery($this->pdo, $table);
	}

	public function delete($table)
	{
		return new DeleteQuery($this->pdo, $table);
	}
}