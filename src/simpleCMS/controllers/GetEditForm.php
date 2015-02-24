<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 23.02.15
 */

namespace simpleCMS\controllers;

/**
 * Генерация формы редактирования
 * @package simpleCMS\controllers
 */
class GetEditForm extends AItemController
{

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        $this->setVariable('item', $this->getItem());
        return $this->render('forms/edit-form.twig');
    }
}
