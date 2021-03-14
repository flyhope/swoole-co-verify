<?php
/**
 * memcached client test
 *
 * @since  2021/3/14 7:11
 * @author chengxuan <i@chengxuan.li>
 */

namespace Scv\EasySwooleMemcache;

class Client
{
    public string $host;
    public int $port;
    
    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }
    
    public function execute()
    {
        $config = new \EasySwoole\Memcache\Config(
            [
                'host' => $this->host,
                'port' => $this->port,
            ]
        );
        
        $client = new \EasySwoole\Memcache\Memcache($config);
        $result = $client->get('test', 1000);
        echo "result:{$result}\r\n";
    }
}
