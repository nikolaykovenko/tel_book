<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 24.02.15
 */

namespace simpleCMS\controllers;
use simpleCMS\model\TelNumbers;

/**
 * Удаление элемента
 * @package simpleCMS\controllers
 */
class DeleteItem extends AItemController
{

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        $item = $this->getItem();
        $model = new TelNumbers();

        try {
            $model->deleteItem($item->id);
            $this
                ->setVariable('status', 'ok')
                ->setVariable('message', 'Элемент успешно удален');

        } catch (\Exception $e) {
            $this
                ->setVariable('status', 'error')
                ->setVariable('message', $e->getMessage());
        }

        return $this->render('json-result.twig');
    }
}
