<?php
/**
 *
 *
 * @since  2021/3/14 7:57
 * @author chengxuan <i@chengxuan.li>
 */

namespace Scv\Comm;
class Verify {
    public static function client(int $max_time, callable $callback) {
        $time_start = microtime(true);
        $callback();
        $time_use = microtime(true) - $time_start;
        $result = $time_use < $max_time ? 'yes' : 'no';
    
        printf("Time use: %.2f, support:%s\n", $time_use, $result);
    }
}