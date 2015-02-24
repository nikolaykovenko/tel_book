<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 23.02.15
 */

namespace simpleCMS\controllers;


/**
 * Генерация формы для добавления элемента
 * @package simpleCMS\controllers
 */
class GetAddForm extends AController
{

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        return $this->render('forms/add-form.twig');
    }
}
