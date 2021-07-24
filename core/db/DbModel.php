<?php

namespace app\core\db;

use app\core\Application;
use app\core\Model;


abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    public function primaryKey(): string
    {
        return 'id';
    }

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare(
            "INSERT INTO $tableName (" . implode(",", $attributes) . ") 
                VALUES (" . implode(",", $params) . ")"
        );
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public function update($attributes, $values, $where)
    {
        $tableName = $this->tableName();
        $where_attributes = array_keys($where);
        $where_sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $where_attributes));
        $set_sql = implode(",", array_map(fn($set_attr) => "$set_attr = :set_$set_attr", $attributes));
        $statement = self::prepare('UPDATE ' . $tableName . ' SET ' . $set_sql . ' WHERE ' . $where_sql);
        foreach ($attributes as $attribute) {
            $statement->bindValue(":set_$attribute", $values[$attribute]);
        }
        foreach ($where_attributes as $attribute) {
            $statement->bindValue(":$attribute", $where[$attribute]);
        }
        $statement->execute();
        return true;
    }

    public static function prepare($sql): \PDOStatement
    {
        return Application::$app->db->prepare($sql);
    }

    public static function findOne($where, $select = ['*'])
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $fields = implode(', ', $select);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT $fields FROM $tableName WHERE $sql LIMIT 1");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public static function findAll($param = [], $select = ['*'])
    {
        $tableName = static::tableName();
        $fields = implode(', ', $select);
        $statement = self::prepare(
            'SELECT ' . $fields . ' FROM ' . $tableName . ' ORDER BY ' . $param["sort"] . ' ' . $param["orderBy"] . ' LIMIT ? OFFSET ?'
        );

        $statement->bindParam(1, $param["limit"], \PDO::PARAM_INT);
        $statement->bindParam(2, $param["offset"], \PDO::PARAM_INT);

        $statement->execute();
        if ($statement->rowCount() > 0) {
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        }
        return false;
    }

    public static function numRows()
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT COUNT(*) FROM $tableName");
        $statement->execute();
        return $statement->fetchColumn();
    }
}