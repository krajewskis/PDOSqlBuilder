<?php

/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 24.9.14
 * Time: 17:07
 */

namespace PDOSqlBuilder;

use PDOSqlBuilder\Builder\SelectBuilder;
use PDOSqlBuilder\Query\AbstractQuery;
use PDOSqlBuilder\Query\SelectQuery;

class PDOSqlBuilder implements PDOSqlBuilderInterface
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
		$builder = new SelectQuery($this->pdo, $table);
		return $builder;
	}

	public function insertInto($table)
	{
		$builder = new InsertBuilder($this->pdo, $table);
		return $builder;
	}

	public function update($table)
	{
		$builder = new UpdateBuilder($this->pdo, $table);
		return $builder;
	}

	public function deleteFrom($table)
	{
		$builder = new DeleteBuilder($this->pdo, $table);
		return $builder;
	}
}