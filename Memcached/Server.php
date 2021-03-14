<?php
/**
 *
 *
 * @since  2021/3/14 7:11
 * @author chengxuan <i@chengxuan.li>
 */

namespace Scv\Memcached;

class Server
{
    
    public \Swoole\Coroutine\Server $server;
    public string $host;
    public int $port;
    
    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }
    
    public function start()
    {
        $this->server = new \Swoole\Coroutine\Server(
            $this->host,
            $this->port,
            false,
            true
        );
        $this->server->set(
            array(
                'open_eof_split' => true,   //打开EOF_SPLIT检测
                'package_eof'    => "\r\n", //设置EOF
                'send_timeout'   => 10,
            )
        );
        
        //接收到新的连接请求 并自动创建一个协程
        $this->server->handle(
            function (\Swoole\Coroutine\Server\Connection $conn) {
                while (true) {
                    //接收数据
                    $data = $conn->recv(2);

                    if ($data === '' || $data === false) {
                        $errCode = swoole_last_error();
                        $errMsg = socket_strerror($errCode);
                        echo "errCode: {$errCode}, errMsg: {$errMsg}\n";
                        $conn->close();
                        break;
                    }

                    // set data
                    if (strpos($data, 'test') !== false) {
                        sleep(1);
                        $conn->send("VALUE test 1 1\r\na\r\n");
                    }
                }
            }
        );
        
        echo "Start server {$this->host}:{$this->port}\n";
        $this->server->start();
    }
    
    public function shutdown()
    {
        return $this->server->shutdown();
    }
    
}

