<?php

class CSVDB
{
    /**
     * @var string database name str
     */
    var $dbName;
    /**
     * @var string current table name str
     */
    var $curTableName;

    function __construct($dbName = "")
    {
        $this->dbName = $dbName;
    }

    function __destruct()
    {
        return true;
    }


    function exec($sql)
    {
        $sql = trim($sql);
        $sqlParts = preg_split('/ /', $sql, 2);
        $command = array_shift($sqlParts);
        echo $command;
        switch ($command) {
            case "create":
                $this->handleCreate($sqlParts[0]);
                break;
            case "insert":
                $this->handleInsert($sqlParts[0]);
                break;
        }
    }

    function handleCreate($sql)
    {
        $sqlParts = preg_split('/ /', $sql, 2);
        $command = array_shift($sqlParts);
        echo $command;
        switch ($command) {
            case "database":
                $this->handleCreateDB($sqlParts[0]);
                break;
            case "table":
                $this->handleCreateTable($sqlParts[0]);
                break;
        }
    }

    private function handleCreateDB($sql)
    {
        if (!file_exists($sql)) {
            mkdir($sql);
        }
        $this->dbName = $sql;
    }

    /**
     * @param $sql [[[ post (id,title,content,time) ]]]
     */
    private function handleCreateTable($sql)
    {
        $sqlParts = preg_split('/ /', $sql, 2);
        $tableName = array_shift($sqlParts);
        $table = fopen($this->dbName . "/" . $tableName . ".csv", "w");
        $columnStr = trim(trim($sqlParts[0], "()"));
        fwrite($table, $columnStr);
        fclose($table);
    }

    private function handleInsert($sql)
    {
        $sqlParts = preg_split('/ /', $sql, 2);
        if ($sqlParts[0] == "into") {
            array_shift($sqlParts);
        }
        $sqlParts = preg_split('/ /', $sql, 2);
        $this->curTableName = $sqlParts[0];
        $columnStr = trim(trim($sqlParts[1], "()"));

    }
}
