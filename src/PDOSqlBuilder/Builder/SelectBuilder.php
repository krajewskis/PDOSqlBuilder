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
	private $query;

	private $limit;
	private $offset;

	private $statement;

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

	private function build()
	{
		$this->query = 'SELECT * FROM ' . $this->table . PHP_EOL;
		if (!is_null($this->limit)) {
			$this->query .= 'LIMIT ' . $this->limit . PHP_EOL;
		}
		if (!is_null($this->offset)) {
			$this->query .= 'OFFSET ' . $this->offset . PHP_EOL;
		}

		$this->query = trim($this->query);

		if (self::$debug) {
			print $this->query . PHP_EOL;
		}
	}

	public function execute()
	{
		$this->build();
		return $this->pdo->query($this->query);
	}

	public function setFetchMode($style = null, $argument = null)
	{
		if (!$this->statement) {
			$this->statement = $this->execute();
		}

		if (!is_null($style) && is_null($argument)) {
			$this->statement->setFetchMode($style);

		} else if (!is_null($style) && !is_null($argument)) {
			$this->statement->setFetchMode($style, $argument);
		}

		return $this;
	}

	public function fetchAll($style = null, $argument = null)
	{
		if (!$this->statement) {
			$this->statement = $this->execute();
		}

		if (is_null($style) && is_null($argument)) {
			$result = $this->statement->fetchAll();

		} else if (!is_null($style) && is_null($argument)) {
			$result = $this->statement->fetchAll($style);

		} else if (!is_null($style) && !is_null($argument)) {
			$result = $this->statement->fetchAll($style, $argument);
		}

		$this->statement = null;
		return $result;
	}
}