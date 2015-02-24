<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 23.02.15
 */

namespace simpleCMS\controllers;

use simpleCMS\core\ApplicationHelper;

/**
 * Базовый контроллер
 * @package simpleCMS\controllers
 */
abstract class AController
{
    /**
     * @var ApplicationHelper
     */
    protected $appHelper;

    /**
     * @var array массив переменных шаблона
     */
    protected $variables = [];

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->appHelper = ApplicationHelper::getInstance();
    }

    /**
     * @param string $variable
     * @param mixed $value
     * @return $this
     */
    protected function setVariable($variable, $value)
    {
        $this->variables[$variable] = $value;
        return $this;
    }

    /**
     * Рендеринг шаблона
     * @param string $template
     * @return string
     */
    protected function render($template)
    {
        return $this->appHelper->render($template, $this->variables);
    }

    
    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    abstract public function execute();
}
