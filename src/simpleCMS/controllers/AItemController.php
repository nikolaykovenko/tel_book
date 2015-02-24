<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 23.02.15
 */

namespace simpleCMS\controllers;
use simpleCMS\exceptions\Exception404;
use simpleCMS\model\TelNumbers;


/**
 * Контроллер с функционалом получания данных об элементе
 * @package simpleCMS\controllers
 */
abstract class AItemController extends AController
{

    /**
     * Возврашает элемент с id, переданным в get
     * @return \stdClass
     * @throws \Exception
     * @throws Exception404
     */
    protected function getItem()
    {
        $model = new TelNumbers();

        if (!isset($_GET['id'])) {
            throw new Exception404;
        }
        $id = (int) $_GET['id'];

        $item = $model->findOne("id = :id", ['id' => $id]);
        if (empty($item)) {
            throw new \Exception('Элемент #' . $_GET['id'] . ' не найден');
        }
        
        return $item;
    }
}
