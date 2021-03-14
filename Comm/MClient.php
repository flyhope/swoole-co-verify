<?php
/**
 * client retry max
 *
 * @since  2021/3/14 8:16
 * @author chengxuan <i@chengxuan.li>
 */
namespace Scv\Comm;
abstract class MClient {
    
    public int $max = 10;
    
    abstract public function execute();
    
    public static function start() {
        \Scv\Comm\Verify::client(1, function () {
            $obj = new static();
            $channel = new \Swoole\Coroutine\Channel(1);
            for ($i = 0; $i < $obj->max; ++$i) {
                \Swoole\Coroutine::create(function() use ($obj, $channel) {
                    $obj->execute();
                    $channel->push(true);
                });
            }
            
            for ($i = 0; $i < $obj->max; ++$i) {
                $channel->pop();
            }
        });
    }
}