<?php

class System_Router
{
    /**
     * Путь к файлу
     * @var string
     */
    private $_path;

    /**
     *
     * @param string $path
     * @throws Exception
     */
    public function setPath($path)
    {

        $path = trim($path, '/\\');
        $path .= DS;

        if (!is_dir($path)) {
            throw new Exception ('Invalid controller path: \'' . $path . '\'');
        }

        $this->_path = $path;
    }

    /**
     * Анализирует строку запроса, подгружает файл с нужным классом
     * @throws Exception
     */
    public function start()
    {
// Анализируем путь
        $this->_getController($file, $controllerName, $action, $args);

// Файл доступен?
        if (!is_readable($file)) {
            throw new Exception('404 error! Controller ' . '\'' . $controllerName . '\'' . ' not found');
        }

// Подключаем файл
        include_once $file;

// Создаём экземпляр контроллера
        $class = 'Controller_' . $controllerName;

//print_r($args);


        $controller = new $class();
        $controller->setArgs($args);

// Действие доступно?
        if (!is_callable([$controller, $action])) {
            throw new Exception('404 error. Action ' . '\'' . $action . '\'' . ' Not Found');
        }

        call_user_func([$controller, $action]);



        /**
         * @var System_View $view
         */
        $viewFileName = 'View' . DS . $controllerName . DS . substr($action, 0, -6) . '.phtml';
        
        $view = $controller->view;

        $layoutFileName = 'View' . DS . 'layout.phtml';

        include_once $layoutFileName;


    }

    /**
     *
     * @param string $file
     * @param string $controller
     * @param string $action
     * @param string $args
     */
    private function _getController(&$file, &$controller, &$action, &$args)
    {
        $route = empty($_GET['route']) ? 'index' : $_GET['route'];

// Получаем раздельные части
        $route = trim($route, '/\\');

        $parts = explode('/', $route);

// Находим путь к файлу с контроллером

        if (empty($parts[0])) {
            $controller = 'Index';
        } else {
//$controller = ucfirst($parts[0]);
//unset($parts[0]);
            $controller = ucfirst(array_shift($parts));

        }

        if (empty($parts[0])) {
            $action = 'indexAction';
        } else {
//$action = $parts[1] . 'Action';
//unset($parts[1]);
            $action = array_shift($parts) . 'Action';
        }
        $file = $this->_path . $controller . '.php';

        $args = $parts;
    }
}