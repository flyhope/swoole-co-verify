<?php
/**
 * start motan agent server
 *
 * @since  2021/3/13 22:25
 * @author chengxuan <i@chengxuan.li>
 */

namespace Scv\Curl;

class Main
{
    public static string $host = '127.0.0.1';
    
    public static int $port = 9503;
    
    public static function run(\Swoole\Coroutine\Channel $channel)
    {
        // start server
        $server = new \Scv\Motan\Server(self::$host, self::$port);
        \Swoole\Coroutine::create([$server, 'start']);
    
        // start client
        \Swoole\Coroutine::create(
            function () use ($channel, $server) {
                Client::start();
                $server->shutdown();
                $channel->push(true);
            }
        );
    }
}
