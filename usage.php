<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 24.9.14
 * Time: 17:18
 */

require_once __DIR__ . '/src/loader.php';

$pdo = new \PDO('mysql:host=localhost;dbname=sql_builder', 'sql_builder', '27N6ST7W1m43rCK');
//$pdo = new \PDO('pgsql:host=localhost;dbname=sql_builder', 'sql_builder', '27N6ST7W1m43rCK');
$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);


$query = new \PDOSqlBuilder\PDOSqlBuilder($pdo);
$query->setDebug(true);
$list = $query->from('test')->limit(1)->offset(0)->setFetchMode(PDO::FETCH_OBJ)->fetchAll();

print_r($list);
