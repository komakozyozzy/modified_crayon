<?php
include_once "config.php";


class Database
{
    private static $con;
    private static $numCons = 0;
    private $host;
    private $database;
    private $user;
    private $password;
    private $debug;
    private $debug_email;

    function __construct() {
        $config = new ConfigINI();
        $this->host = $config->getDBSetting("host");
        $this->database = $config->getDBSetting("database");
        $this->user = $config->getDBSetting("username");
        $this->password = $config->getDBSetting("password");

        $this->debug = true;
        $this->debug_email = "nchlssmith1@gmail.com";
        $this->connect();
        self::$numCons++;
    }

    function configure($host, $database, $user, $password)
    {
        $this->host = $host;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        self::$connect();
    }

    function connect()
    {
        self::$con = mysql_connect($this->host, $this->user, $this->password) or $this->logError(mysql_errno(), mysql_error());
        mysql_select_db($this->database) or $this->logError(mysql_errno(), mysql_error());
    }

    function disconnect()
    {
        if (is_resource(self::$con)) mysql_close(self::$con);
    }

    function runQuery($sql)
    {
        if (!mysql_ping(self::$con)) $this->connect();
        $query = mysql_query($sql, self::$con);
        if ($query === FALSE)
        {
            $this->logError(mysql_errno(), mysql_error(), $sql);
            return $query;
        }
        else return $query;
    }

    function logError($errno, $error, $sql=null)
    {
        $err_msg = "MySQL Error (".$errno."): ".$error."\r\nRequest_URI: ".$_SERVER["REQUEST_URI"];
        if ($sql) $err_msg .= "\r\nQuery: ".$sql;
        if ($this->debug) die ($err_msg);
        else
        {
            date_default_timezone_set("America/Belize");
            error_log("\r\n\r\n[".date('l jS \of F Y h:i:s A')."] ".$err_msg, 3, "mysql_error.log");
            error_log("[".date('l jS \of F Y h:i:s A')."] ".$err_msg, 1, $this->debug_email, "FROM: errors@theenvite.com");
        }
    }

    function query($sql)
    {
        $arr = array();
        $quer = $this->runQuery($sql);
        if (!is_resource($quer)) return array();
        while($result = mysql_fetch_assoc($quer))
        {
            $arr[] = $result;
        }
        return $arr;
    }

    function findId($table, $where){
        $sql = "SELECT * FROM $table WHERE $where LIMIT 1";
        $query = $this->runQuery($sql);
        if ($query) $res = mysql_fetch_array($query);
        if ($res) return $res[0];
        return FALSE;
    }

    function get($table, $where){
        $sql = "SELECT * FROM $table WHERE $where LIMIT 1";
        $query = $this->runQuery($sql);
        if ($query) $res = mysql_fetch_assoc($query);
        if ($res) return $res;
        return FALSE;
    }

    function getAll($table){
        $sql = "SELECT * FROM $table";
        return $this->query($sql);
    }

    function insert($table, $info){
        // $info[FIELDNAME] = VALUE;
        $fields = '';
        $values = '';
        $first = TRUE;
        foreach ($info as $field => $value){
            if ($first){
                $first = FALSE;
            }else{
                $fields .= ', ';
                $values .= ', ';
            };
            $fields .= $field;
            $values .= "'".mysql_real_escape_string(trim($value), self::$con)."'";
        };
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $this->runQuery($sql);
        $id = mysql_insert_id(self::$con);
        return $id;
    }


    //echo $id = getId('t_user', array('username'=>'yasser', 'userContactId'=>70));
    function getId($table, $values)
    {

        if ($table && $values && is_array($values))
        {
            $str = '';
            foreach ($values as $k => $v)
            {
                $str .= "BINARY ".$k ."='". mysql_real_escape_string($v, self::$con) . "' AND ";
            }

            $str= rtrim($str, ' AND ');

            $sql = "SELECT * FROM $table WHERE $str LIMIT 1";
            $query = $this->runQuery($sql);
            if ($query)
            {
                $result =  mysql_fetch_array($query);
                return $result[0];
            }
        }

    }


    //update('t_user', array('username'=>"yas;ser", 'userContactId'=>'50', 'userSession'=>50), array('username'=>"yasser", 'userContactId'=>50));
    function update($table, $values, $where)
    {
        if ($table && $values && is_array($values))
        {
            $vals = '';
            $wher = '';
            foreach($values as $k => $v)
            {
                $vals .= $k."='".mysql_real_escape_string($v, self::$con)."', ";
            }
            $vals = rtrim($vals, ", ");
            foreach($where as $k => $v)
            {
                $wher .= $k."='".mysql_real_escape_string($v, self::$con)."' AND ";
            }
            $wher = rtrim($wher, " AND ");
            $sql = "UPDATE $table SET $vals WHERE ($wher)";
            $this->runQuery($sql);
        }
    }


    //findOrInsert('t_user', array('username'=>"yasser", 'userContactId'=>"75"));
    function findOrInsert($table, $values)
    {
        if ($table && $values && is_array($values))
        {
            $id = $this->getId($table, $values);
            if ($id) return $id;
            else
            {
                foreach($values as $k => $v)
                {
                    $fields .= $k.", ";
                    $vals .= "'".mysql_real_escape_string($v, self::$con)."', ";
                }
                $fields = rtrim($fields, ', ');
                $vals = rtrim($vals, ', ');
            }
            $sql = "INSERT INTO $table ($fields) VALUES ($vals)";
            $this->runQuery($sql);
            return mysql_insert_id(self::$con);
        }

    }


    function getVal($table, $values, $col)
    {
        if ($table && $values && is_array($values))
        {
            $str = '';
            foreach ($values as $k => $v)
            {
                $str .= $k ."='". mysql_real_escape_string($v, self::$con) . "' AND ";
            }

            $str= rtrim($str, ' AND ');

            $sql = "SELECT * FROM $table WHERE $str LIMIT 1";
            $query = $this->runQuery($sql);
            if ($query)
            {
                $result =  mysql_fetch_assoc($query);
                return $result[$col];
            }
        }
    }

    function __destruct()
    {
        self::$numCons--;
        if (self::$numCons == 0){
            $this->disconnect();
        };
    }

}

?>
