<?php


namespace Anonym\Components\Cache\Interfaces;

/**
 * Interface FlushableInterface
 * @package Anonym\Components\Cache
 */
interface FlushableInterface
{
    /**
     * Önbelleğe alınan tüm verileri siler
     *
     * @return mixed
     */
    public function flush();
}
