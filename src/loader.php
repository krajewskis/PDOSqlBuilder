<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 8.9.14
 * Time: 9:53
 */

spl_autoload_register(function ($className) {
	$filename = __DIR__ . '/' . str_replace('\\', '/', $className) . ".php";
	if (file_exists($filename)) {
		include($filename);
		if (class_exists($className)) {
			return true;
		}
	}
	return false;
});