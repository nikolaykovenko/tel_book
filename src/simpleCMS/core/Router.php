<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 23.02.15
 */

namespace simpleCMS\core;

/**
 * Простой роутинг
 * @package simpleCMS\core
 */
class Router
{
    /**
     * Простой выбор названия конроллера на основе запроса
     * @param array $request
     * @return string
     */
    public static function getControllerName(array $request)
    {
        if (empty($request) or !isset($request['mode']) or empty($request['mode'])) {
            $request = ['mode' => 'start'];
        }
        
        return 'simpleCMS\controllers\\' . ucfirst($request['mode']);
    }
}
