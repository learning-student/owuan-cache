<?php


namespace Anonym\Components\Cache\Interfaces;

/**
 * Interface DriverAdapterInterface
 * @package Anonym\Components\Cache
 */
interface DriverAdapterInterface
{

    /**
     * Verinin değerini döndürür
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name);

    /**
     * stores a value in cache, returns true in success and false in failure
     *
     * @param string $name
     * @param mixed $value
     * @param int $time
     * @return bool
     */
    public function set(string $name, $value, int $time = 3600) : bool;

    /**
     * @param string $name Değer ismi
     * @return mixed
     */
    public function delete(string $name): bool;


    /**
     * Öyle bir değerin olup olmadığına bakar
     *
     * @param string $name
     * @return mixed
     */
    public function exists(string $name): bool;

}
