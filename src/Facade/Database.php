<?php

/**
 * Facade para realizar multiples operaciones con bases de datos
 */
class Database
{
    protected static $pdo;

    /**
     * Method to intance connection
     * @param mixed $dsn
     * @param mixed $username
     * @param mixed $password
     */

    public static function setConnection($dsn, $username, $password)
    {
        self::$pdo = new PDO($dsn, $username, $password);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    /**
     * Method to execute query
     *
     * @param mixed $query
     * @param array $params
     * @return void
     */
    public static function select($query, $params = [])
    {
        try {
            $statement = self::$pdo->prepare($query);
            $statement->execute($params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
            return false;
        }
    }


    /**
     * Method to insert a row to database
     *
     * @param mixed $table
     * @param array|string $data
     * @return void
     */
    public static function insert($table, $data)
    {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));
            $query = "INSERT INTO $table ($columns) VALUES ($values)";
            $statement = self::$pdo->prepare($query);
            $statement->execute($data);
            return self::$pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Error al insertar datos: " . $e->getMessage();
            return false;
        }
    }


    /**
     * Method to update mutiples rows to specific table
     *
     * @param string $table
     * @param array $data
     * @param string $where
     * @return void
     */
    public static function update($table, $data, $where)
    {
        try {
            $set = "";
            foreach ($data as $key => $value) {
                $set .= "$key=:$key, ";
            }
            $set = rtrim($set, ", ");
            $query = "UPDATE $table SET $set WHERE $where";
            $statement = self::$pdo->prepare($query);
            $statement->execute($data);
            return $statement->rowCount();
        } catch (PDOException $e) {
            echo "Error al actualizar datos: " . $e->getMessage();
            return false;
        }
    }


    /**
     * Method to insert multiples row to specific table
     *
     * @param string $table
     * @param array $data
     * @return void
     */
    public static function insertMultiple($table, $data)
    {
        try {

            $columns = implode(", ", array_keys($data[0]));
            $values = [];

            foreach ($data as $row) {
                $rowValues = "(" . implode(", ", array_fill(0, count($row), "?")) . ")";
                $values = array_merge($values, array_values($row));
            }

            $placeholders = implode(", ", array_fill(0, count($data), $rowValues));
            $query = "INSERT INTO $table ($columns) VALUES $placeholders";

            $statement = self::$pdo->prepare($query);
            $statement->execute($values);
            return self::$pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Error al insertar datos múltiples: " . $e->getMessage();
            return false;
        }
    }

    public static function beginTransaction()
    {
        self::$pdo->beginTransaction();
    }

    public static function commit()
    {
        self::$pdo->commit();
    }

    public static function rollBack()
    {
        self::$pdo->rollBack();
    }
}
