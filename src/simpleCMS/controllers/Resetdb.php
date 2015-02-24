<?php
/**
 * @package default
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 23.02.15
 */

namespace simpleCMS\controllers;

/**
 * Заполнение БД фейковыми значениями
 * @package simpleCMS\controllers
 */
class Resetdb extends AController
{

    /**
     * Выполнение контроллера
     * @return string
     * @throws \Exception в случае ошибки
     */
    public function execute()
    {
        $telModel = new \simpleCMS\model\TelNumbers();
        
        $this->appHelper->getDbh()->prepare("TRUNCATE {$telModel->getTableName()}")->execute();
        $faker = \Faker\Factory::create('ru_RU');
        for ($i = 0; $i < 100; $i++) {
            $item = new \StdClass;
            $item->fio = $faker->name;
            $item->city = $faker->city;
            $item->tel = $faker->unique()->phoneNumber;

            $telModel->insert($item);
        }

        echo 'DB is refilled with new values';
    }
}
