<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 24.9.14
 * Time: 17:18
 */

require_once __DIR__ . '/src/php/loader.php';

$pdo = new \PDO('sqlite:' . __DIR__ . '/test/db/db.sqlite3');
$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

$ppdo = new \PPDO\PPDO($pdo);

//$ppdo->setDebug(true);

class ExampleModel
{
}

$model = new ExampleModel();

//var_dump($ppdo->from('test')->where('id', 1)->limit(1)->fetch(PDO::FETCH_OBJ));

//var_dump($model);
//var_dump($ppdo->from('test')->where('id', 1)->limit(1)->setFetchMode(PDO::FETCH_CLASS, get_class($model))->fetch());

var_dump($ppdo->from('test')->where('id', 1)->limit(1)->setFetchMode(PDO::FETCH_INTO, $model)->fetch());
var_dump($model);
