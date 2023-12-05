<?php
/**
 * Clase encargada de medir el tiempo de ejecución de una tarea 
 * Utilice los tres métodos para poder determinar el tiempo de ejecución del misma 
 * Método start (Es recomendable invocarlo en el inicio de la clase o en el constructor) 
 * Método end (Cuando termine la ejecución de un proceso, estructura de control o bucle) 
 * Método duration (Es recomendable invocarlo al final de la clase) 
 */
class ExecutionTime
{
    protected static $startTime;
    protected static $endTime;


    /**
     * Method to init the execution time meter
     *
     * @return void
     */
    public static function start()
    {
        self::$startTime = microtime(true);
    }

    /**
     * Method to end the execution time meter
     *
     * @return void
     */
    public static function end()
    {
        self::$endTime = microtime(true);
    }

    /**
     * Method to get duration of the execution
     *
     * @return void
     */
    public static function duration()
    {
        return number_format((self::$endTime - self::$startTime), 5);
    }
}
