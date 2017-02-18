<?php
class Controller_User extends System_Controller
{
    public function profileAction()
    {
        $userId = $this->getArgs()['id'];
       
        try {
            $modelUser = Model_User :: getById($userId);
            $this->view->setParam('user', $modelUser);
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
    }
}