<?php

abstract class System_Controller
{
    public $args;
    protected $_connection;

    public $view;

    public function setArgs($args)
    {
        $this->args = $args;
    }
    public function getArgs()
    {

        $count = count($this->args);
        $arguments = [];

        for ($i = 0; $i < $count; $i += 2) {
            $arguments [$this->args[$i]] = $this->args[$i + 1];
        }
        return $arguments;
    }

    public function __construct()
    {
        $this->view = new System_View();
    }
    public function getParams(){
        return $_REQUEST;
    }


}