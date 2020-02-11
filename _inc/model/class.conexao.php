<?php

class Conexao
{
    private $conn = "";

    public function __construct()
    {
        try {
            $host = "mysql:host=" . DB_HOST . "; port=" . DB_PORT . "; dbname=" . DB_NAME ."; charset=" . DB_CHARSET;
            $this->conn = new PDO($host, DB_USER, DB_PASS, array(PDO::ATTR_PERSISTENT => false)) or die (PDO::ERRMODE_WARNING);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException ('Sistema em manutenção.');
        }
    }

    public function select($sql, $associarCampos = true, $replaceTags = true)
    {
        $i = 0;
        $array = array();
        $arrayTag = array("<", ">", '"');
        $arrayCar = array("&lt;", "&gt;", "&quot;");

        $fetch = PDO::FETCH_ASSOC;

        if (!$associarCampos) {
            $fetch = PDO::FETCH_NUM;
        }

        $rs = $this->conn->query(trim($sql));

        while ($row = $rs->fetch($fetch)) {
            foreach ($row as $key => $value) {
                if ($replaceTags) {
                    $array[$i][$key] = str_replace($arrayTag, $arrayCar, $value);
                } else {
                    $array[$i][$key] = $value;
                }
            }
            $i++;
        }
        return $array;
    }

    public function getLastInsertId($sequence)
    {
        return $this->conn->lastInsertId($sequence);
    }

    public function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }

    public function exec($sql)
    {
        return $this->conn->exec($sql);
    }

    public function begin()
    {
        $this->conn->beginTransaction();
    }

    public function commit()
    {
        $this->conn->commit();
    }

    public function rollback()
    {
        $this->conn->rollback();
    }

    public function inTransaction()
    {
        return $this->conn->inTransaction();
    }

    public function prepareSqlForDate()
    {
        $this->conn->query('set datestyle = "ISO, DMY";');
    }

    public function disableSqlForDate()
    {
        $this->conn->query('set datestyle = default;');
    }

    public function getConn()
    {
        return $this->conn;
    }

}