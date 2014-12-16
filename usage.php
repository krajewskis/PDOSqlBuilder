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

$ppdo->from('test')->columns('id')->where('id', 1)->group('code')->order('code')->limit(1)->offset(0)->execute();

$ppdo->from('test a')->columns('a.id')->leftJoin('test b', 'a.id = b.id')->where('a.id', 1)->group('a.code')->order('a.code')->limit(1)->offset(0)->execute();