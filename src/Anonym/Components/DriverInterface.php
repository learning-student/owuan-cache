<?php

namespace Anonym\Components\Cache;

/**
 * Interface DriverInterface
 * @package Anonym\Components\Cache
 */
interface DriverInterface
{

    /**
     *
     *
     * @return bool
     */
    public function check();

    /**
     * Ayarlarý kullanýr ve bazý baþlangýç iþlemlerini gerçekleþtirir
     *
     * @param array $configs
     * @return mixed
     */
    public function boot(array $configs = []);
}
