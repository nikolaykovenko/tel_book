<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 23.02.15
 */

namespace simpleCMS\model;
use simpleCMS\exceptions\ValidationException;


/**
 * Модель телефонного номера
 * @package simpleCMS\model
 */
class TelNumbers extends AModel
{
    
    /**
     * Возвращает название таиблицы в БД
     * @return string
     */
    public function getTableName()
    {
        return 'tel_numbers';
    }

    /**
     * Параметры, которые можно присваивать в матоматическом режиме
     * @return array
     */
    public function safeParams()
    {
        return ['tel', 'fio', 'city'];
    }

    /**
     * @inheritdoc
     */
    public function insert(\stdClass $instance)
    {
        $instance->tel = $this->prepareTelNumber($instance->tel);
        return parent::insert($instance);
    }

    /**
     * @inheritdoc
     */
    public function updateItem(\stdClass $instance)
    {
        $instance->tel = $this->prepareTelNumber($instance->tel);
        return parent::updateItem($instance);
    }

    /**
     * Преобразовывает телефонный номер по шаблону для лучшей читабельности
     * @param $tel
     * @return string
     */
    public static function telFormat($tel)
    {
//        С точки зрения быстродействия и нагрузки, конечно, регулярные выражения при каждой выдаче результатов
//        не очень правильно. В случае необходимости, можно оптимизировать.
        return preg_replace("/^([\d]+)([\d]{2})([\d]{2})([\d]{3})$/", "$1-$2-$3-$4", $tel);
    }

    
    

    /**
     * Валидация телефонного номера
     * @param string $tel
     * @return bool
     * @throws ValidationException
     */
    private function prepareTelNumber($tel)
    {
        $tel = preg_replace("/[\D]/", '', $tel);
        $telLen = mb_strlen($tel, 'utf-8');
        
        if ($telLen >= 10 and $telLen <= 14) {
            return $tel;
        }

        throw new ValidationException('Phone number is incorrect');
    }
}
