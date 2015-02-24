<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 24.02.15
 */

namespace simpleCMS\controllers;


use simpleCMS\model\TelNumbers;

/**
 * Вставка нового элемента
 * @package simpleCMS\controllers
 */
class InsertItem extends AController
{

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        parse_str($_POST['form'], $params);
        $item = new \stdClass();
        $model = new TelNumbers();
        
        foreach ($params as $param => $value) {
            if (in_array($param, $model->safeParams())) {
                $item->$param = $value;
            }
        }

        try {
            $model->insert($item);
            $this
                ->setVariable('status', 'ok')
                ->setVariable('message', 'Элемент успешно добавлен');

        } catch (\Exception $e) {
            $this
                ->setVariable('status', 'error')
                ->setVariable('message', $e->getMessage());
        }

        return $this->render('json-result.twig');
    }
}
