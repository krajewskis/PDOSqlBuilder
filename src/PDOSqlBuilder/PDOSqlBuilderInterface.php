<?php

/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 24.9.14
 * Time: 17:08
 */

namespace PDOSqlBuilder;

interface PDOSqlBuilderInterface
{
	public function __construct(\PDO $pdo);

	public function from($table);

	public function insertInto($table);

	public function update($table);

	public function deleteFrom($table);

}