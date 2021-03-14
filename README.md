## Usage

### init
```bash
docker run --rm --interactive --tty --volume $PWD:/app composer install
```

### test motan

#### start motan service

need motan agent https://github.com/weibocom/motan-go
```bash
motan-go -c ./motan/config/motan.yaml
```

### start test
```bash
php -c ./config/php-cli.ini --ini ./main.php
```

## Result

* motan: yes
* memcached: no
* EasySwooleMemcache: not support ascii
