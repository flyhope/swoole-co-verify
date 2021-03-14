<?php
/**
 *
 *
 * @since  2021/3/14 6:28
 * @author chengxuan <i@chengxuan.li>
 */

namespace Scv\Motan;

class Server
{
 
    public \Swoole\Coroutine\Http\Server $server;
    public string $host;
    public int $port;
    
    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }
    
    public function start()
    {
        $this->server = new \Swoole\Coroutine\Http\Server($this->host, $this->port, false);
        $this->server->handle(
            '/motan',
            function ($request, $response) {
                usleep(500000);
                $response->end("ok");
            }
        );
        
        echo "Start server {$this->host}:{$this->port}\n";
        $this->server->start();
    }
    
    public function shutdown() {
        return $this->server->shutdown();
    }
}
