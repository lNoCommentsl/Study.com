<?php

class Model_User
{
    /**
     * Register mode
     */
    const MODE_REGISTER = 1;
    const MODE_LOGIN = 2;
    /**
     *
     * @var int
     */
    public  $id;

    /**
     *
     * @var string
     */
    public  $name;

    /**
     *
     * @var string
     */
    public  $email;

    /**
     *
     * @var string
     */
    private $_password;

    /**
     *
     * @var string
     */
    public  $photo;

    /**
     *
     * @var int
     */
    public  $role_id;
    /**
     *
     * @param int $userId
     * @return Model_User
     * @throws Exception
     */
    public static function getById($userId)
    {
        $dbUser   =  new Model_Db_Table_User();
        $userData = !empty($dbUser->getById($userId)[0]) ? $dbUser->getById($userId)[0] : '';

        if(!empty($userData)) {
            $modelUser = new self();
            $modelUser->id        = $userData->id;
            $modelUser->name      = $userData->first_name. ' '. $userData->last_name;
            $modelUser->email     = $userData->email;
            $modelUser->photo     = $userData->photo;
            $modelUser->role_id   = $userData->role_id;

            return $modelUser;
        } else {
            throw new Exception('User not found', /*System_Exception::NOT_FOUND*/23);
        }
    }

    /**
     *
     * @param array $params
     * @throws Exception
     */
    public function register($params)
    {
        if(!$this->_validate($params))
        {
            throw new Exception('The entered data is invalid', System_Exception::VALIDATE_ERROR);
        }

        $tableUser = new Model_Db_Table_User();

        $resIfExists = $tableUser->checkIfExists($params);

        if(!empty($resIfExists)) {
            throw new Exception('Such account is already exists.', System_Exception :: ALREADY_EXISTS);
        } else {
            
            $resCreate = $tableUser->create($params);

            if(!$resCreate) {
                throw new Exception('Can\'t create new user. Try later.', System_Exception :: ERROR_CREATE_USER);
            }
            return $resCreate;
        }
    }

    /**
     *
     * @param array $params
     * @return boolean
     */
    private function _validate($params)
    {
        $login      = !empty($params['email']) ? $params['email'] : '';
        $password   = !empty($params['password']) ? $params['password'] : '';


        if(!$password || !$login) {
            return false;
        }

        if(strlen($login > 20)) {
            return false;
        }
        if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
}
