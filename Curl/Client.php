<?php
/**
 * motan server
 *
 * @since  2021/3/14 6:28
 * @author chengxuan <i@chengxuan.li>
 */
namespace Scv\Curl;

class Client extends \Scv\Comm\MClient
{
    public function execute() {
        $url = 'http://127.0.0.1:9503/motan';
        $defaults = array(
            CURLOPT_HEADER         => 0,
            CURLOPT_URL            => $url,
            CURLOPT_FRESH_CONNECT  => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE   => 1,
            CURLOPT_TIMEOUT        => 4,
        );
    
        $ch = curl_init();
        curl_setopt_array($ch, $defaults);
        $result = curl_exec($ch);
        var_dump($result);
    }
}