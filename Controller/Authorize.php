<?php
class Controller_Authorize extends System_Controller
{
    public function registerAction()
    {
        header('Content-Type: application/json');
      
        $params = $this->getParams();
        
        $userModel  = new Model_User();
        try {
            $userId     = $userModel->register($params);
//            $this->setSessParam('currentUser', $userId); 
//            if($this->getParamByKey('save') == 'true') {
//                $this->setSessParam('is_save', 1);   
//            }
            $userData = [
                'id'    =>  $userId,
                'email' =>  trim($params['email'])
            ];
           
            echo json_encode($userData);
            die();
        }
        catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            die();
        }
    }
}