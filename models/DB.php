<?php

namespace models;

/**
 * Class DB
 * @package models
 * @author Djordje Mancovic <dj.mancovic@gmail.com>
 */
class DB {

    /**
     * @var null
     */
    protected $host;
    /**
     * @var null
     */
    protected $username;
    /**
     * @var null
     */
    protected $password;
    /**
     * @var null
     */
    protected $db;

    /**
     * @var bool
     */
    protected $isSubQuery = false;
    /**
     * @var
     */
    protected $_pdo;

    /**
     * @param null $host
     * @param null $username
     * @param null $password
     * @param null $db
     */
    protected function __construct($host = NULL, $username = NULL, $password = NULL, $db = NULL)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->db = $db;
        if ($host == null && $username == null && $db == null) {
            $this->isSubQuery = true;
        }

        $this->connect();
    }

    /**
     *
     */
    protected function connect()
    {
        if ($this->isSubQuery) {
            return;
        }
        $this->_pdo = new \PDO("mysql:host=$this->host;dbname=$this->db", $this->username, $this->password)
        or die('There was a problem connecting to the database');
        $this->_pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
    }

    /**
     * @param $table
     * @param $limit
     * @param $orderBy
     * @param $order
     * @return mixed
     */
    protected function fetch($table, $limit = 1000, $orderBy, $order) {
        $query = "SELECT * FROM $table ORDER BY $orderBy $order LIMIT :limit";
        $stmt = $this->_pdo->prepare($query);
        $stmt->bindValue(':limit', (int) $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @param $table
     * @param $params
     */
    protected function insertIgnore($table, $params) {
        $columns = $this->generateColumns($params);
        $questionMarks = $this->generateQuestionMarks($params[0]);

        $query = "INSERT IGNORE $table ( $columns ) VALUES ";
        $qPart = array_fill(0, count($params), $questionMarks);
        $query .=  implode(",",$qPart);
        $stmt = $this->_pdo->prepare($query);

        $this->bindParamsMultiple($params, $stmt);

        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * @param $params
     * @return string
     */
    protected function generateColumns($params) {
        $param = $params[0];
        $keys = array_flip($param);

        return implode(', ', $keys);

    }

    /**
     * @param $param
     * @return string
     */
    protected function generateQuestionMarks($param) {
        $questionMarks = '(';
        foreach ($param as $value) {
            $questionMarks .= "?,";
        }
        $questionMarks = rtrim($questionMarks, ',');
        $questionMarks .= ')';

        return $questionMarks;
    }

    /**
     * @param $params
     * @param $stmt
     */
    protected function bindParamsMultiple($params, $stmt) {
        $i = 1;

        foreach ($params as $param) {

            foreach ($param as $key => $value) {
                $stmt->bindValue($i++, $value);
            }

        }
    }

}

