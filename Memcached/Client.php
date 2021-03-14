<?php
/**
 * memcached client test
 *
 * @since  2021/3/14 7:11
 * @author chengxuan <i@chengxuan.li>
 */
namespace Scv\Memcached;

class Client
{
    public string $host;
    public int $port;
    
    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }
    
    public function execute() {
        $mc = new \Memcached();
        $mc->addServer($this->host, $this->port);
        $mc->setOption(\Memcached::OPT_POLL_TIMEOUT, 2000);
        $mc->setOption(\Memcached::OPT_CONNECT_TIMEOUT, 2000);
        $mc->setOption(\Memcached::OPT_SEND_TIMEOUT, 2000);
        $mc->setOption(\Memcached::OPT_RECV_TIMEOUT, 2000);
        $result = $mc->get('test');
        echo "result:{$result}\r\n";
    }
}