<?php

use Carbon\Carbon;

/**
 * Clase que contiene varios metodos para trabajar con las fechas 
 * 
 */

class Date
{

    /**
     * Method to get current date time 
     * 
     */

    public static function getCurrentDateTime()
    {
        return Carbon::now();
    }

    /**
     * Method to get future days
     * @param mixed $days
     * 
     */

    public static function getFutureDate($days)
    {
        return Carbon::now()->addDays($days);
    }

    /**
     * Method to get past days
     *
     * @param [mixed] $days
     * @return void
     */
    public static function getPastDate($days)
    {
        return Carbon::now()->subDays($days);
    }

    /**
     * Method to get format date 
     *
     * @param [mixed] $date
     * @param string $format
     * @return void
     */
    public static function formatDate($date, $format = 'Y-m-d')
    {
        return Carbon::parse($date)->format($format);
    }
}