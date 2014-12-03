<?php
/**
 * Created by PhpStorm.
 * User: krajewski
 * Date: 3.12.14
 * Time: 10:46
 */

namespace PDOSqlBuilder\Query;


use PDOSqlBuilder\Builder\SelectBuilder;
use PDOSqlBuilder\Builder\WhereBuilder;

class SelectQuery extends AbstractQuery
{
	/**
	 * @var \PDO
	 */
	private $selectBuilder;
	private $query;
	private $sth;

	public function __construct(\PDO $pdo, $table)
	{
		parent::__construct($pdo);
		$this->selectBuilder = new SelectBuilder($table, new WhereBuilder());
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
			$this->query = $this->selectBuilder->buildQuery();
		}
		$this->sth = $this->pdo->prepare($this->query);
		return $this;
	}

	public function execute()
	{
		if (!$this->sth) {
			$this->prepare();
		}
		return $this->sth->execute($this->selectBuilder->getParameters());
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