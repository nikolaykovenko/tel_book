<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 23.02.15
 */

namespace simpleCMS\controllers;
use simpleCMS\model\TelNumbers;


/**
 * Обновление элемента
 * @package simpleCMS\controllers
 */
class UpdateItem extends AItemController
{

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        parse_str($_POST['form'], $params);
        
        $item = $this->getItem();
        $model = new TelNumbers();
        foreach ($params as $param => $value) {
            if (in_array($param, $model->safeParams())) {
                $item->$param = $value;
            }
        }
        
        try {
            $model->updateItem($item);
            $this
                ->setVariable('status', 'ok')
                ->setVariable('message', 'Элемент успешно сохранен');
            
        } catch (\Exception $e) {
            $this
                ->setVariable('status', 'error')
                ->setVariable('message', $e->getMessage());
//            Ошибки нужно было бы доработать, они должны выдавать более понятную пользователю информацию и
//            не раскрывать внутреннюю структуру приложения, для простоты упущено
        }
        
        return $this->render('json-result.twig');
    }
}
