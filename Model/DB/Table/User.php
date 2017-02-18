<?php
class Model_Db_Table_User extends System_Db_Table
{
    
    protected $_name = 'user';

    /**
     * 
     * @param int $id
     * @return array
     */
    public function getById($id)
    {
        $sql    = 'select * from ' . $this->getName() . ' where id = ?';
        
        $sth = $this->getConnection()->prepare($sql);
        $sth->execute([$id]);
        
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        
        return $result;
    }
    
    
    
    /**
     * @param array $params
     * @return int 
     */
    public function create($params)
    {
        $login      = trim($params['email']);
        $password   = trim($params['password']);
        $sql = 'INSERT INTO ' . $this->getName() . ' (email,password) VALUES(?,?)';
        $sth = $this->getConnection()->prepare($sql);
        
        $result = $sth->execute([$login, sha1($password)]);
        
        if($result) {
            return $this->getConnection()->lastInsertId();
        }
    }
    
    /**
     * 
     * @param array $params
     * @param int $mode
     * @return array
     */
    public function checkIfExists($params, $mode = Model_User::MODE_REGISTER)
    {
        $login      = trim($params['email']);
        $password   = trim($params['password']);
        
        $requestParams = [$login];
        
        $sql = 'select * from ' . $this->getName() . ' where email = ?';
        
        
        
        
//        if($mode == Model_User::MODE_LOGIN) {
//            $sql .= 'AND password = ?';
//            array_push($requestParams, sha1($password));
//        }
        
        /**
         * @var PDOStatement $sth 
         */
        $sth = $this->getConnection()->prepare($sql);
        $sth->execute($requestParams);
        $result = $sth->fetchAll(PDO::FETCH_OBJ);        
        
        return $result;
    }
}