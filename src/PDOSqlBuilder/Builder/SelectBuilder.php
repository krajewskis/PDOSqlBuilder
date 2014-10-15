<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 24.9.14
 * Time: 17:14
 */

namespace PDOSqlBuilder\Builder;


class SelectBuilder extends AbstractBuilder
{
	private $where;
	private $limit;
	private $offset;

	private $query;

	/**
	 * @var \PDOStatement
	 */
	private $sth;

	public function __construct(\PDO $pdo, $table)
	{
		parent::__construct($pdo, $table);
		$this->where = new WhereBuilder();
	}

	public function where($conditions, $parameters = null)
	{
		$this->where->addCondition($conditions, $parameters);
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

	protected function buildQuery()
	{
		$this->query = 'SELECT * FROM ' . $this->table;
		if ($this->where->hasConditions()) {
			$this->query .= ' WHERE ' . $this->where->getConditions();
		}
		if (!is_null($this->limit)) {
			$this->query .= ' LIMIT ' . $this->limit;
		}
		if (!is_null($this->offset)) {
			$this->query .= ' OFFSET ' . $this->offset;
		}

		$this->query = trim($this->query);

		if (self::$debug) {
			print $this->query . PHP_EOL;
		}
	}

	public function prepare()
	{
		if (!$this->query) {
			$this->buildQuery();
		}
		$this->sth = $this->pdo->prepare($this->query);
		return $this;
	}

	public function execute()
	{
		if (!$this->sth) {
			$this->prepare();
		}
		return $this->sth->execute($this->where->getParameters());
	}

	public function setFetchMode($style = null, $argument = null)
	{
		if (!$this->sth) {
			$this->sth = $this->execute();
		}

		if (!is_null($style) && is_null($argument)) {
			$this->sth->setFetchMode($style);

		} else if (!is_null($style) && !is_null($argument)) {
			$this->sth->setFetchMode($style, $argument);
		}

		return $this;
	}

	public function fetchAll($style = null, $argument = null)
	{
		if (!$this->sth) {
			$this->execute();
		}

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