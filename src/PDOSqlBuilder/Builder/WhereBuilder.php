<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 15.10.14
 * Time: 17:04
 */

namespace PDOSqlBuilder\Builder;


class WhereBuilder
{
	private $conditions = array();
	private $parameters = array();

	public function addCondition($condition, $param = null)
	{
		if (is_array($condition) && is_null($param)) {
			foreach ($condition as $key => $val) {
				$this->addCondition($key, $val);
			}

		} else if (!is_array($condition)) {
			if (preg_match('/^[a-z0-9]*$/', $condition) && !is_array($param)) {
				if ($param === true) {
					$param = 1;
				} else if ($param === false) {
					$param = 0;
				}
				$this->conditions[] = $condition . ' = ?';
				$this->parameters[] = $param;

			} else if (preg_match('/^[a-z0-9]$/', $condition) && is_array($param)) {
				$this->conditions[] = $condition . ' IN (' . trim(str_repeat('?,', count($param)), ',') . ')';
				$this->parameters = array_merge($this->parameters, $param);

			} else {
				$this->conditions[] = $condition;
				$this->parameters[] = $param;
			}

		} else {
			throw new \ErrorException('NOT_ALLOWED');
		}
	}

	public function hasConditions()
	{
		return (bool)count($this->conditions);
	}

	public function getConditions()
	{
		return '(' . implode(') AND (', $this->conditions) . ')';
	}

	public function getParameters()
	{
		return $this->parameters;
	}
} 