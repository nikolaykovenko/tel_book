<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 23.02.15
 */

namespace simpleCMS\controllers;
use simpleCMS\model\TelNumbers;

/**
 * Контроллер стартовой страницы
 * @package simpleCMS\controllers
 */
class Start extends AController
{

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        $telModel = new TelNumbers();
        $this->setVariable('telData', $telModel->findAll());
        
        return $this->render('index.twig');
    }
}
