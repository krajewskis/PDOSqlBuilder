<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 24.9.14
 * Time: 17:14
 */

namespace PPDO\Builder;


class SelectBuilder extends AbstractBuilder
{
	private $columns;
	private $join = array();
	private $where;
	private $group;
	private $order;
	private $limit;
	private $offset;

	private $query;

	public function __construct($table, WhereBuilder $where)
	{
		parent::__construct($table);
		$this->where = $where;
	}

	public function columns($columns)
	{
		$this->columns = $columns;
		return $this;
	}

	public function leftJoin($table, $condition)
	{
		$this->join[] = array(true, $table, $condition);
		return $this;
	}

	public function join($table, $condition)
	{
		$this->join[] = array(false, $table, $condition);
		return $this;
	}

	public function where($conditions, $parameters = null)
	{
		$this->where->addCondition($conditions, $parameters);
		return $this;
	}

	public function group($group)
	{
		$this->group = $group;
		return $this;
	}

	public function order($order)
	{
		$this->order = $order;
		return $this;
	}

	public function limit($limit)
	{
		$this->limit = $limit;
		return $this;
	}

	public function offset($offset)
	{
		$this->offset = $offset;
		return $this;
	}

	public function build()
	{
		$this->query = 'SELECT ' . (!empty($this->columns) ? $this->columns : '*');
		$this->query .= ' FROM ' . $this->table;

		foreach ($this->join as $join) {
			$this->query .= ($join[0] ? ' LEFT ' : '') . 'JOIN ' . $join[1] . ' ON ' . $join[2];
		}

		if ($this->where->hasConditions()) {
			$this->query .= ' WHERE ' . $this->where->getConditions();
		}

		if (!empty($this->group)) {
			$this->query .= ' GROUP BY ' . $this->group ;
		}

		if (!empty($this->order)) {
			$this->query .= ' ORDER BY ' . $this->order ;
		}

		if (!is_null($this->limit)) {
			$this->query .= ' LIMIT ' . $this->limit ;
		}

		if (!is_null($this->offset)) {
			$this->query .= ' OFFSET ' . $this->offset ;
		}

		$this->query = trim($this->query);

		if (self::$debug) {
			print $this->query. PHP_EOL;
		}

		return $this->query;
	}

	public function getParameters()
	{
		return $this->where->getParameters();
	}
}