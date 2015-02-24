<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 24.02.15
 */

namespace simpleCMS\controllers;


use simpleCMS\model\TelNumbers;

/**
 * Поиск элементов
 * @package simpleCMS\controllers
 */
class SearchItems extends AController
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
        
        return $this->render('telephones-list.twig');
    }
}
