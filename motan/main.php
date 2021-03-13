<?php
/**
 * start motan agent server
 *
 * @since 2021/3/13 22:25
 * @author chengxuan <i@chengxuan.li>
 */

use Swoole\Coroutine\Http\Server;
use function Swoole\Coroutine\run;

$host = '127.0.0.1';
$port = 9502;

define('D_AGENT_ADDR', '127.0.0.1:9990');

include './vendor/autoload.php';
Swoole\Runtime::enableCoroutine($flags = SWOOLE_HOOK_ALL);

function startTest(Server $server)
{
    $time_start = microtime(true);
    $channel = new Swoole\Coroutine\Channel(1);
    $max = 10;
    for ($i = 0; $i < $max; ++$i) {
        \Swoole\Coroutine::create(function () use ($channel) {
            sleep(1);
            $app_name = 'agent-test';
            $service = 'li.chengxuan.swoole';
            $group = 'motan-server-mesh-example';
            $remote_method = 'test';
            $params = [];
            $cx = new Motan\MClient($app_name);
            $request = new \Motan\Request($service, $remote_method, $params);
            $request->setGroup($group);
            try {
                $res = $cx->doCall($request);
                if ($res) {
                    var_dump($res);
                } else {
                    var_dump($cx->getResponse());
                }
            } catch (Exception $e) {
                var_dump($e->getMessage());
            }
            $channel->push(true);
        });
    }
    
    for ($i = 0; $i < $max; ++$i) {
        $channel->pop();
    }
    $time_use = microtime(true) - $time_start;
    $result = $time_use < 2 ? 'yes' : 'no';
    
    printf("Time use: %.2f, support:%s\n", $time_use, $result);
    $server->shutdown();
}

run(function () use ($host, $port) {
    
    // start motan agent proxy server
    $server = new Server($host, $port, false);
    $server->handle('/motan', function ($request, $response) {
        $response->end("ok");
    });
    
    \Swoole\Coroutine::create(function () use($server) {
        startTest($server);
    });
    
    echo "Start server {$host}:{$port}\n";
    $server->start();
});
