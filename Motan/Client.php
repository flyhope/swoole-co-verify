<?php
/**
 * motan server
 *
 * @since  2021/3/14 6:28
 * @author chengxuan <i@chengxuan.li>
 */
namespace Scv\Motan;

class Client extends \Scv\Comm\MClient
{
    public function execute() {
        $app_name = 'agent-test';
        $service = 'li.chengxuan.swoole';
        $group = 'motan-server-mesh-example';
        $remote_method = 'test';
        $params = [];
        $cx = new \Motan\MClient($app_name);
        $request = new \Motan\Request(
            $service, $remote_method, $params
        );
        $request->setGroup($group);
        try {
            $res = $cx->doCall($request);
            if ($res) {
                var_dump($res);
            } else {
                var_dump($cx->getResponse());
            }
        } catch (\Throwable $e) {
            var_dump($e->getMessage());
        }
    }
    
//    public static function start() {
//        \Scv\Comm\Verify::client(1, function () {
//            $max = 10;
//            $obj = new self();
//            $obj->_channel = new \Swoole\Coroutine\Channel(1);
//            for ($i = 0; $i < $max; ++$i) {
//                \Swoole\Coroutine::create([$obj, 'execute']);
//            }
//
//            for ($i = 0; $i < $max; ++$i) {
//                $obj->_channel->pop();
//            }
//        });
//    }
}