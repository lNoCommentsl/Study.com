<?php

abstract class System_Db_Table
{
    protected $_connection;
    public function __construct()
    {
        $this->_connection = System_Registry::get('db');
    }

    /**
     * @return PDO
     */
    public function getConnection(){
        return $this->_connection;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

}