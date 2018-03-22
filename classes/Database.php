<?php
/**
 * Created by PhpStorm.
 * User: nullptr
 * Date: 3/22/2018
 * Time: 4:30 PM
 */
//db wrapper for obv reasons

class Database {
    //singleton design pattern, this db wrapper can also be used outside of the application

    /*
     * getInstance static method so that we dont query our db again and again
     */
    private static $_instance = null;

    /*
     * private properties
     */
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;

    //construction function to connect to database

    private function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:host='. Config::get('mysql/host') .';dbname=' . Config::get('mysql/db') . '', Config::get('mysql/username'), Config::get('mysql/password'));

        }
        catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if(!isset(self::$_instance))
        {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function query($sql, $params = array())
    {
        $this->_error = false;

        if($this->_query = $this->_pdo->prepare($sql))
        {
            $x =1;
            if(count($params)) {
                foreach($params as $param)
                {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }

    public function action($action, $table, $where = array())
    {
        if(count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=');

            $field    = $where[0];
            $operator = $where[1];
            $value    = $where[2];

            if(in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if(!$this->query($sql, array($value))->error()) {

                    return $this;

                }
            }
        }
        return false;

    }

    public function get($table, $where)
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where)
    {
        return $this->action('SELECT', $table, $where);
    }

    public function insert($table, $fields = array()) {

        if(count($fields)){
            $keys = array_keys($fields);
            $values = null;
            $x =1;

            $sql = "INSERT INTO users (`" . implode('`, `', $keys) . "`)";

            echo $sql;
        }


        return false;
    }

    public function update(){}

    public function results()
    {
        return $this->_results;
    }
    public function first()
    {
        return $this->results()[0];
    }

    public function error() {
        return $this->_error;
    }

    public function count() {
        return $this->_count;
    }


}