<?php

interface IDataStore {
    function save(array $items);
}

class MySQLDataStore implements IDataStore {
    
    private $_config = array(
        'host' => '127.0.0.1',
        'db'   => 'aaa_test',
        'user' => 'root',
        'pswd' => '',
    );

    function save(array $items) {
        $mysqli = new mysqli(
            $this->_config['host'], $this->_config['user'], 
            $this->_config['pswd'], $this->_config['db']
        );
        if (mysqli_connect_errno()) {
            $error = sprintf("Connect failed: %s\n", mysqli_connect_error());
            throw new Exception($error);
        }
        $mysqli->set_charset("utf8");

        $insert_query = '';
        foreach ($items as $item) {
            $title = $mysqli->real_escape_string((string)$item->title);
            $description = $mysqli->real_escape_string((string)$item->description);
            $sql = sprintf(
                "insert into news (title, description) values ('%s', '%s');",
                $title, $description
            );
            $insert_query .= $sql;
        }

        $res = $mysqli->multi_query($insert_query);

        $mysqli->close();

        return $res;
    }
}