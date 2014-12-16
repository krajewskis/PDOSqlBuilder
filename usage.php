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
$ppdo->setDebug(true);
$ppdo->from('test')->columns('code')->order('code')->execute();