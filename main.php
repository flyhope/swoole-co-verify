<?php
/**
 * main entrance
 *
 * @since  2021/3/14 6:21
 * @author chengxuan <i@chengxuan.li>
 */

use function Swoole\Coroutine\run;
require './vendor/autoload.php';
Swoole\Runtime::enableCoroutine($flags = SWOOLE_HOOK_ALL);

class verifyMain {
    
    public \Swoole\Coroutine\Channel $channel;
    
    public function __construct() {
        $this->channel = new \Swoole\Coroutine\Channel(100);
    }
    
    public function run(string $name, callable $callback) {
        echo "\n============= {$name} ============= \n";
        $callback($this->channel);
        $this->channel->pop();
    }
    
}

run(function () {
    $verify = new verifyMain();
    $verify->run('Motan', '\Scv\Motan\Main::run');
    $verify->run('Memcached', '\Scv\Memcached\Main::run');
    
    // easy swoole not support ascii yet
//    $verify->run('EasySwooleMemcache', '\Scv\EasySwooleMemcache\Main::run');
});
