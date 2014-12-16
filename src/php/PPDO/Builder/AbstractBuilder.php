<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 24.9.14
 * Time: 17:17
 */

namespace PPDO\Builder;


abstract class AbstractBuilder
{
	protected $table;

	public static $debug;

	public function __construct($table)
	{
		$this->table = $table;
	}

	abstract public function build();
}