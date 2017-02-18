<?php
abstract class System_Controller
{
    /**
     *
     * @var System_View $view 
     */
    public $view;
    
    /**
     *
     * @var array 
     */
    public $args;
    
    /**
     * 
     * @param array $args
     */
    public function setArgs($args)
    {
        $this->args = $args;
    }
    
    /**
     * 
     * @return array
     */
    public function getArgs()
    {
        //$this->args = array_combine([0,1], $this->args);
        
        $count = count($this->args);
        $arguments = [];
        
        for($i = 0; $i < $count - 1; $i += 2) {
            $arguments[$this->args[$i]] = $this->args[$i + 1];
        }
        
        return $arguments;
    }
    
    public function __construct()
    {
        $this->view = new System_View();
    }
    
    public function getParams()
    {
        return $_REQUEST;
    }
}