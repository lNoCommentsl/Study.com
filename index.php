<?php
error_reporting(E_ALL);;
function dump($dump)
{
   echo '<pre>';
    print_r($dump, true);
   echo '<pre/>';
}
function echoPre ($a){
    echo '<pre>';
    print_r($a). '<br/>';
    echo '<pre/>';
}
define('DS', DIRECTORY_SEPARATOR);
// Узнаём путь к файлам сайта
$site_path = realpath(dirname(__FILE__) . DS) . DS;

define('SITE_PATH', $site_path);

$config = file_get_contents(SITE_PATH. DS. 'config.xml');

// Модель это логика работы приложения
// Создается классы для оброботки и получения данных

$configXML = new SimpleXMLElement($config);

$host     = (string)$configXML->db->host;
$dbname   = (string)$configXML->db->dbname;
$username = (string)$configXML->db->username;
$password = (string)$configXML->db->password;

try {
    $dsn ='mysql:host='.$host.';dbname='.$dbname;
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo "Error!: ". $e-> getMessage();
}

spl_autoload_register('loadClass');

function loadClass ($className){
    $path = explode('_', $className);
    $file = '';
    foreach ($path as $value){
        $file .= $value . DS ;
    }
    $file = substr($file, 0, -1) .'.php';
    if (file_exists($file)){
        include_once "$file";
    } else {
        throw new Exception('File '.$file.' not found', 1);
    }
}

try {
    System_Registry :: set('db', $db);
    $router = new System_Router();
    $router->setPath(SITE_PATH . 'Controller');
    $router->start();

}
catch(Exception $e) {
    echo $e->getMessage();
}