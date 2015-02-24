<?php
/**
 * @package simpleCMS
 * @author Nikolay Kovenko <nikolay.kovenko@gmail.com>
 * @date 23.02.15
 */

namespace simpleCMS\model;

use simpleCMS\core\ApplicationHelper;

/**
 * Базовая модель
 * @package simpleCMS\model
 */
abstract class AModel
{

    /**
     * @var ApplicationHelper
     */
    protected $appHelper;

    /**
     * @var \PDO
     */
    protected $dbh;

    /**
     * Конструктор
     * @throws \Exception
     */
    public function __construct()
    {
        $this->appHelper = ApplicationHelper::getInstance();
        $this->dbh = $this->appHelper->getDbh();
    }

    /**
     * Возвращает все записи, попадающие под параметры выборки
     * @param string $where параметр where
     * @param array $whereValues значения для подстновки
     * @return array
     */
    public function findAll($where = '', $whereValues = [])
    {
        $sth = $this->selectQueryExecute($where, $whereValues);

        $result = [];
        while ($obj = $sth->fetch()) {
            $result[] = $obj;
        }

        return $result;
    }

    /**
     * Возвращает первую запись, попадающую под параметр выборки
     * @param string $where параметр where
     * @param array $whereValues значения для подстновки
     * @return array
     */
    public function findOne($where = '', $whereValues = [])
    {
        return $this->selectQueryExecute($where, $whereValues)->fetch();
    }

    /**
     * Удаляет элемент
     * @param int $itemId
     * @return bool
     * @throws \Exception
     */
    public function deleteItem($itemId)
    {
        return $this->execute(
            $this->dbh->prepare("delete from `{$this->getTableName()}` where `id` = :id"),
            ['id' => $itemId]
        );
    }

    /**
     * Добавляет новую запись
     * @param \stdClass $instance
     * @return bool
     * @throws \Exception в случае ошибки
     */
    public function insert(\stdClass $instance)
    {
        $safeParams = $this->safeParams();
        if (count($safeParams) == 0) {
            return false;
        }
        
        $sth = $this->dbh->prepare(
            "insert into {$this->getTableName()} {$this->prepareSet($instance, $bindParams)}"
        );
        
        if ($this->execute($sth, $bindParams)) {
            $instance->id = $this->dbh->lastInsertId();
            return true;
        }
    }

    /**
     * Обновляет запись в БД
     * @param \stdClass $instance
     * @return bool
     * @throws \Exception
     */
    public function updateItem(\stdClass $instance)
    {
        if (!property_exists($instance, 'id')) {
            throw new \Exception('Вы не можете обновить запись без id');
        }
        
        $sth = $this->dbh->prepare(
            "update {$this->getTableName()} {$this->prepareSet($instance, $bindParams)} where id = :update_id" 
        );
        $bindParams['update_id'] = $instance->id;
        
        return $this->execute($sth, $bindParams);
    }

    /**
     * Подготавливает параметр set для пере
     * @param \stdClass $instance представитель класса
     * @param array $bindParams массив со значениями параметров для последующей подстановки в выражениями
     * @return string
     * @throws \Exception в случае ошибки
     */
    private function prepareSet(\stdClass $instance, &$bindParams)
    {
        $safeParams = $this->safeParams();
        if (count($safeParams) == 0) {
            throw new \Exception('Safe params is not defined for model');
        }
        
        $bindParams = [];
        $query = "set ";
        foreach ($safeParams as $param) {
            if (property_exists($instance, $param)) {
                $query .= "`{$param}` = :{$param}, ";
                $bindParams[$param] = $instance->$param;
            }
        }

        return mb_substr($query, 0, -2);
    }


    /**
     * Производит запрос на выборку данных
     * @param string $where
     * @param array $whereValues
     * @return \PDOStatement
     */
    private function selectQueryExecute($where = '', $whereValues = [])
    {
        $sth = $this->dbh->prepare(
            "select * from {$this->getTableName()}" . (!empty($where) ? " where " . $where : '')
        );
        $sth->setFetchMode(\PDO::FETCH_OBJ);
        $sth->execute($whereValues);
        return $sth;
    }

    /**
     * Выполняет запрос
     * @param \PDOStatement $sth
     * @param array $bindParams
     * @return bool
     * @throws \Exception
     */
    private function execute(\PDOStatement $sth, array $bindParams)
    {
        if ($sth->execute($bindParams)) {
            return true;
        }

        throw new \Exception(implode(' ', $sth->errorInfo()));
    }

    
    /**
     * Возвращает название таиблицы в БД
     * @return string
     */
    abstract public function getTableName();

    /**
     * Параметры, которые можно присваивать в матоматическом режиме
     * @return array
     */
    abstract public function safeParams();
}
