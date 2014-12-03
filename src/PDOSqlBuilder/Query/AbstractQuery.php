<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 3.12.14
 * Time: 9:01
 */

namespace PDOSqlBuilder\Query;


abstract class AbstractQuery
{
	protected $pdo;
	public static $debug;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

} 