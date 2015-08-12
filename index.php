<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */

include 'vendor/autoload.php';

$cache = new \Anonym\Components\Cache\Cache();
$driver = $cache->driver('memcache', [
    'host' =>
]);