<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 24.9.14
 * Time: 17:18
 */

require_once __DIR__ . '/src/loader.php';

for ($i = 1; $i <= 3; $i++) {
	if ($i == 1) {
		print 'SQLite';
		$pdo = new \PDO('sqlite:' . __DIR__ . '/db/db.sqlite3');

	} else if ($i == 2) {
		print 'MySQL';
		$pdo = new \PDO('mysql:host=localhost;dbname=sql_builder', 'sql_builder', '27N6ST7W1m43rCK');

	} else if ($i == 3) {
		print 'PgSQL';
		$pdo = new \PDO('pgsql:host=localhost;dbname=sql_builder', 'sql_builder', '27N6ST7W1m43rCK');

	}
	$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
	$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

	print PHP_EOL . PHP_EOL;

	$pdob = new \PDOSqlBuilder\PDOSqlBuilder($pdo);
	$pdob->setDebug(true);
	$list = $pdob->from('test')->where('id', array(1, 2))->fetchAll(PDO::FETCH_OBJ);

	print_r($list);

//	$sth = $pdo->prepare('SELECT * FROM test WHERE id = ? AND code = ? AND description LIKE ? AND status1 = ? AND status2 = ? AND date(created) >= ? AND date(updated) <= ?');
//	$sth->execute(array(1, 'FIRST', '%scp%', 1, 0, '2013-01-01', '2014-01-01'));
////	$sth->debugDumpParams();
//	$sth->setFetchMode(PDO::FETCH_OBJ);
//	$list = $sth->fetchAll();
//
//	print_r($list);
//	var_dump($list[0]->status1);

	print PHP_EOL;
}

