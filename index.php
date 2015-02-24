<?php
/**
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 23.02.15
 */

header("Content-Type: text/html; charset=utf-8");
require_once 'vendor/autoload.php';
require_once 'autoload.php';
$loader = new \Example\Psr4AutoloaderClass();
$loader->register();
$loader->addNamespace('simpleCMS', __DIR__ . '/src/simpleCMS');


$config = require_once 'config.php';
$appHelper = simpleCMS\core\ApplicationHelper::getInstance();
$appHelper->setConfig($config);

try {
    $controllerName = \simpleCMS\core\Router::getControllerName($_GET);
    /** @var \simpleCMS\controllers\AController $controller */
    
    if (!class_exists($controllerName)) {
        throw new \simpleCMS\exceptions\Exception404;
    }
    
    $controller = new $controllerName();
    echo $controller->execute();
    
} catch (\simpleCMS\exceptions\Exception404 $e) {
    header("HTTP/1.0 404 Not Found");
    echo $appHelper->render('404.twig');
} catch (Exception $e) {
    echo $e->getMessage();
}
