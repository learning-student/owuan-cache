<?php
/**
 * Bu Dosya AnonymFramework'e ait bir dosyadır.
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @see http://gemframework.com
 *
 */

namespace Anonym\Components\Cache;
use Anonym\Bootstrap\ServiceProvider;
use Anonym\Facades\Config;
/**
 * service provider of cache component
 *
 * Class CacheServiceProvider
 * @package Anonym\Components\Cache
 */
class CacheServiceProvider extends ServiceProvider
{

    public function register(){

        $this->singleton('cache', function(){
           $configs = Config::get();
        });

    }

}