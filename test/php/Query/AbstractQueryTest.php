<?php

/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 3.12.14
 * Time: 16:50
 */
abstract class AbstractQueryTest extends \PHPUnit_Framework_TestCase
{
	public function setUp(PDO $pdo, $sql)
	{
		$sql = explode(';', trim($sql));
		foreach ($sql as $query) {
			$pdo->exec(trim($query));
		}
	}
} 