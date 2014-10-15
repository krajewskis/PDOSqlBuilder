<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 24.9.14
 * Time: 17:17
 */

namespace PDOSqlBuilder\Builder;


use PDOSqlBuilder\PDOSqlBuilder;

abstract class AbstractBuilder
{
	protected $pdo;
	protected $table;
	public static $debug;

	public function __construct(\PDO $pdo, $table)
	{
		$this->pdo = $pdo;
		$this->table = $table;
	}
}