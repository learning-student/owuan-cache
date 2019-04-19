<?php


namespace Anonym\Components\Cache\Interfaces;

/**
 * Interface CacheInterface
 * @package Anonym\Components\Cache
 */
interface CacheInterface
{

    /**
     * Sürücü seçimini yapar
     *
     * @param string $driver
     * @param array $configs
     * @return mixed
     */
    public function driver($driver = '', array $configs = []);
}
