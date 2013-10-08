<?php

/**
 *
 * @author Stef
 */

class DatabaseClass extends PDO
{

	private $host   ='localhost';
	private $user   ='root';
	private $pass   ='1234';
	private $dbname ='test_db';

	private $dbh;
	private $error;
	private $stmt;
	private $query;

	private $table;
	private $order;
	private $group;
	private $columns;
	private $where;
	private $whereValue;
	private $joins;


	public function __construct()
	{

		$dsn= 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
		$options = array(
			PDO::ATTR_PERSISTENT   =>TRUE,
			PDO::ATTR_ERRMODE      => PDO::ERRMODE_EXCEPTION
		);

		try {
			$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
		}
		catch (PDOException $e)
		{
			echo 'Failed to connect to Database ' . $e->getMesssage();
		}

	}


	public function select()
	{
		$this->whereValue = array();
		$this->table = '';
		$this->query = 'SELECT';
		$this->where = array();
		$this->group = array();
		$this->order = array();
		return $this;
	}

	public function from($table, $columns = array())
	{
		$this->table = $table;
		$this->columns = $columns;
		return $this;
	}

	public function where($col, $val)
	{
		$this->where[] = array($col, $val);
		return $this;
	}

	public function order($col, $met)
	{
		$this->order = array($col, strtoupper($met));
		return $this;
	}

	public function group ($col)
	{
		$this->group[] = $col;
		return $this;
	}

	public function update ($table, $cols = array(), $clause)
	{
		$updateQuery = '';
		$tmp = array();
		foreach ($cols as $col => $newValue)
		{
			if (is_string($newValue))
			{
				$tmp = $col . ' =  ? ';
			}
			elseif (is_numeric($newValue))
			{
				$tmp = $col . ' = ' . $newValue;
			}
			$tmpCols[] = $tmp;
		}
		$updateQuery .= ' UPDATE ' . $table . ' SET ' . implode(', ',  $tmpCols) . ' WHERE ' . $clause;

		$stmt= $this->dbh->prepare($updateQuery);
		$stmt->execute(array_values($cols));
	}


	public function insert($table, $cols = array())
	{
		$count = count($cols);
		$insertQuery = 'INSERT INTO `' . $table . '` (`' . implode('`, `', array_keys($cols)) . '`) VALUES (';
		for ($i = 0; $i< $count; $i++)
		{
			$insertQuery .='? ,';
		}
		$insertQuery = substr($insertQuery, 0, -1);
		$stmt = $this->dbh->prepare($insertQuery);
		$stmt->execute(array_values($cols));
	}

	public function delete($table, $val = array())
	{
			$deleteQuery = ' DELETE FROM ' .$table;
			if(!empty($val))
			{
				$deleteQuery.= ' WHERE ';
				foreach ($val as $cond => $value)
				{
					$deleteVal = (is_string($val)) ? "'" . $value . "'" : $value;
					$delete[] = str_replace('?', $deleteVal, $cond);
				}
				$deleteQuery .= implode(' AND ', $delete);
			}

			$stmt = $this->dbh->prepare($deleteQuery);
			$stmt->execute();
	}

	public function joinLeft($table, $clause, $cols = array())
	{
		$this->joins[] = array('type' => '' , 'table' => $table, 'clause' => $clause, 'cols' => $cols);
		return $this;
	}


	public function joinRight($table, $clause, $cols = array())
	{
		$this->joins[] = array('type' => '' , 'table' => $table, 'clause' => $clause, 'cols' => $cols);
		return $this;
	}


	public function join($table, $clause, $cols = array())
	{
		$this->joins[] = array('type' => '', 'table' => $table, 'clause' => $clause, 'cols' => $cols);
		return $this;
	}

	public function _validateColumn($table, $col, $as = NULL)
	{
		if ((!is_null ($as)) && (is_string($as)) && ($as !== ''))
		{
			$col .= ' AS ' . $as;
		}


		if (strpos($col, '.') === false)
		{
			$matchBracketClose = strpos($col, ')');
			$matchBracketOpen = strrpos($col, '(');
			if (($matchBracketOpen !== false) && ($matchBracketClose !== false))
			{
				$matchBracketOpen++;
				$matchLength = $matchBracketClose - $matchBracketOpen - 1;
				$match = substr($col, $matchBracketOpen, $matchLength);
				$innerCol = $table . '.' . $match;
				$col = str_replace($match, $innerCol, $col);
			}
			else
			{
				$col = $table . '.' . $col;
			}
		}
		return $col;
	}





	public function fetch()
	{
		$this->_buildQuery();
		$stmt = $this->dbh->prepare($this->query);
		if ($this->whereValue != NULL)
		{
			$stmt->execute($this->whereValue);
		}
		else
		{
			$stmt->execute();
		}
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	private function _buildQuery()
	{
		$this->query .=' * ';
		$this->query .=' FROM ' . $this->table;
		if (!empty($this->where))
		{
			foreach ($this->where as $where)
			{
				$this->whereValue = $where[1];
				$whereClause[] = $where[0];
			}
			$this->query .=' WHERE ' . implode(' AND ', $whereClause);
		}

		if (!empty($this->group))
		{
			$this->query .= ' GROUP BY ' . implode(', ', $this->group);
		}

		if (!empty($this->order))
		{
			$this->query .= ' ORDER BY ' . $this->order;
		}

		return $this->query;

	}



}
