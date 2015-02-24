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
        if (isset($_GET['search']) and !empty($_GET['search'])) {
            $where = "`tel` like :search";
            $whereValues = ['search' => '%' . $_GET['search'] . '%'];
        } else {
            $where = '';
            $whereValues = [];
        }
        
        $telModel = new TelNumbers();
        $this->setVariable('telData', $telModel->findAll($where, $whereValues));
        
        return $this->render('telephones-list.twig');
    }
}
