<?php

class db_driver
{
    public $conn,
        $servername = "localhost",
        $username = "root",
        $password = "",
        $db_name = "shopmatkinh_db";

    // Hàm kết nối 
    function connect()
    {
        if (!$this->conn) {
            $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->db_name) or die('Lỗi kết nối');
            mysqli_query($this->conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
            mysqli_query($this->conn, "set names 'utf8'");
            mysqli_set_charset($this->conn, "utf8");
        }
    }

    function disconnect(){
        if($this->conn){
            mysqli_close($this->conn);
        }
    }

    function insert($table, $data){
        $this->connect();
        $field_list = '';
        $value_list = '';
        foreach($data as $key => $value){
            $field_list .= ",$key";
            $value_list .= ",'" .  mysqli_escape_string($this->conn, $value) . "'";
        }
        $sql = 'INSERT INTO ' . $table . '(' . trim($field_list, ',') . ') VALUES (' . trim($value_list, ',') . ')';
        return mysqli_query($this->conn, $sql);
    }

    function update($table, $data, $where)
    {
        $this->connect();
        $sql = '';
        foreach ($data as $key => $value) {
            $sql .= "$key = '" . mysqli_escape_string($this->conn, $value) . "',";
        }
        $sql = 'UPDATE ' . $table . ' SET ' . trim($sql, ',') . ' WHERE ' . $where;
        return mysqli_query($this->conn, $sql);
    }

    function remove($table, $where)
    {
        $this->connect();
        $sql = "DELETE FROM $table WHERE $where";
        return mysqli_query($this->conn, $sql);
    }

    function get_list($sql)
    {
        $this->connect();
        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            die('Câu truy vấn bị sai ' . $sql);
        }
        $return = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $return[] = $row;
        }
        mysqli_free_result($result);
        return $return;
    }

    function get_row($sql)
    {
        $this->connect();
        $result = mysqli_query($this->conn, $sql);
        if (!$result) {
            die('Câu truy vấn bị sai ' . $sql);
        }
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        if ($row) {
            return $row;
        }
        return false;
    }

}
