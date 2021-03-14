<?php
/**
 * test memcached entrance
 *
 * @since  2021/3/14 7:40
 * @author chengxuan <i@chengxuan.li>
 */
namespace Scv\EasySwooleMemcache;

class Main
{
    public static string $host = '127.0.0.1';
    
    public static int $port = 9501;
    
    public static function run(\Swoole\Coroutine\Channel $channel)
    {
        // start server
        $server = new \Scv\Memcached\Server(self::$host, self::$port);
        \Swoole\Coroutine::create([$server, 'start']);
        
        // start client
        \Swoole\Coroutine::create(
            function () use ($channel, $server) {
                sleep(1);
    
                \Scv\Comm\Verify::client(1, function () {
                    $client = new Client(self::$host, self::$port);
                    $client->execute();
                });
                
                $channel->push(true);
                $server->shutdown();
            }
        );
    }
}