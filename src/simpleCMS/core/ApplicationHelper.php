<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 23.02.15
 */

namespace simpleCMS\core;

/**
 * Класс для быстрого доступа к основным элементам ЦМС
 * Синглтон
 */
class ApplicationHelper
{

    /**
     * @var static|null
     */
    private static $instance;

    /**
     * @var array|null
     */
    private $config = null;

    /**
     * @var \PDO|null экземпляр подключения к БД
     */
    private $dbh;
    
    private $renderer;

    /**
     * Возвращает экземпляр объекта
     * @return ApplicationHelper
     */
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Возвращает экземпляр подключения к БД
     * @return \PDO
     * @throws \Exception в случае ошибки
     */
    public function getDbh()
    {
        if (is_null($this->dbh)) {
            $config = $this->getConfigParam('db');
            if (empty($config)) {
                throw new \Exception('DB config is not set');
            }
            
            $this->dbh = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }
        
        return $this->dbh;
    }

    /**
     * Рендерит переданный шаблон
     * @param string $template
     * @param array $variables
     * @return string
     */
    public function render($template, array $variables = [])
    {
        if (empty($this->renderer)) {
            $loader = new \Twig_Loader_Filesystem($this->getConfigParam('templatesPath'));
            $this->renderer = new \Twig_Environment($loader);
            
            $telNumberFilter = new \Twig_SimpleFilter('telNumber', ['simpleCMS\model\TelNumbers', 'telFormat']);
            $this->renderer->addFilter('telNumber', $telNumberFilter);
        }
        
        return $this->renderer->render($template, $variables);
    }

    /**
     * Устанавливает параметры конфигурации
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Возвращает значение параметра конфигурации
     * @param string $param
     * @return mixed
     */
    public function getConfigParam($param)
    {
        if (isset($this->config[$param])) {
            return $this->config[$param];
        }
        
        return null;
    }
    
    

    /**
     * Конструктор
     */
    private function __construct()
    {

    }
}
