<?php
abstract class System_Db_Table
{
    /**
     * 
     * @var PDO $_connection
     *  
     */
    protected $_connection;
    
    public function __construct()
    {
        $this->_connection = System_Registry::get('connection');
    }
    
    /**
     * 
     * @return PDO
     */
    public function getConnection()
    {
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