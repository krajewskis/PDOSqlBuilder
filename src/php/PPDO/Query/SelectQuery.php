<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 3.12.14
 * Time: 10:46
 */

namespace PPDO\Query;


use PPDO\Builder\SelectBuilder;
use PPDO\Builder\WhereBuilder;

class SelectQuery extends AbstractQuery
{
	/**
	 * @var \PPDO\Builder\SelectBuilder
	 */
	private $selectBuilder;
	private $query;
	private $parameters;
	private $executed;
	private $sth;

	public function __construct(\PDO $pdo, $table)
	{
		parent::__construct($pdo);
		$this->selectBuilder = new SelectBuilder($table, new WhereBuilder());
	}

	public function columns($columns)
	{
		$this->selectBuilder->columns($columns);
		return $this;
	}

	public function leftJoin($table, $condition)
	{
		$this->selectBuilder->leftJoin($table, $condition);
		return $this;
	}

	public function join($table, $condition)
	{
		$this->selectBuilder->join($table, $condition);
		return $this;
	}

	public function where($conditions, $parameters = null)
	{
		$this->selectBuilder->where($conditions, $parameters);
		return $this;
	}

	public function group($group)
	{
		$this->selectBuilder->group($group);
		return $this;
	}

	public function order($order)
	{
		$this->selectBuilder->order($order);
		return $this;
	}

	public function limit($limit)
	{
		$this->selectBuilder->limit($limit);
		return $this;
	}

	public function offset($offset)
	{
		$this->selectBuilder->offset($offset);
		return $this;
	}

	public function prepare()
	{
		if (!$this->query) {
			$this->query = $this->selectBuilder->build();
		}

		try {
			$this->sth = $this->pdo->prepare($this->query);

		} catch (\PDOException $e) {
			throw new QueryException($this->query, null, $e);
		}

		if (!$this->sth) {
			throw new QueryException($this->query);
		}

		return $this;
	}

	public function execute()
	{
		if (!$this->sth) {
			$this->prepare();
		}
		$this->parameters = $this->selectBuilder->getParameters();
		$this->executed = true;

		try {
			$execute = $this->sth->execute($this->parameters);

		} catch (\PDOException $e) {
			throw new QueryException($this->query . PHP_EOL . print_r($this->parameters, true), null, $e);
		}

		if (!$execute) {
			throw new QueryException($this->query . PHP_EOL . print_r($this->parameters, true));
		}

		return $execute;
	}

	public function setFetchMode($style, $argument = null)
	{
		$this->prepare();

		if (is_null($argument)) {
			$this->sth->setFetchMode($style);

		} else if (!is_null($argument)) {
			$this->sth->setFetchMode($style, $argument);
		}

		return $this;
	}

	public function fetch($style = null, $argument = null)
	{
		if (!$this->executed) {
			$this->execute();
		}

		$result = null;

		if (is_null($style) && is_null($argument)) {
			$result = $this->sth->fetch();

		} else if (!is_null($style) && is_null($argument)) {
			$result = $this->sth->fetch($style);

		} else if (!is_null($style) && !is_null($argument)) {
			$result = $this->sth->fetch($style, $argument);
		}

		$this->sth = null;

		return $result;
	}

	public function fetchAll($style = null, $argument = null)
	{
		if (!$this->executed) {
			$this->execute();
		}

		$result = null;

		if (is_null($style) && is_null($argument)) {
			$result = $this->sth->fetchAll();

		} else if (!is_null($style) && is_null($argument)) {
			$result = $this->sth->fetchAll($style);

		} else if (!is_null($style) && !is_null($argument)) {
			$result = $this->sth->fetchAll($style, $argument);
		}

		$this->sth = null;

		return $result;
	}
} 