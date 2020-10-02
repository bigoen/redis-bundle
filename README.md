BigoenRedisBundle
============================== 

Setup
------------
```
composer require bigoen/redis-bundle
```

```yaml
# config/packages/bigoen_redis.yaml

bigoen_redis:
    clients:
        session:
            dsn: '127.0.0.1/1'
            prefix: 'demo:session:*'
            namespace: 'demo:session'
        monolog:
            dsn: '127.0.0.1/2'
            key: 'demo:monolog'
        doctrine_metadata_cache:
            dsn: '127.0.0.1/3'
            prefix: 'demo:metadata_cache:*'
            namespace: 'demo:metadata_cache'
        doctrine_result_cache:
            dsn: '127.0.0.1/3'
            prefix: 'demo:result_cache:*'
            namespace: 'demo:result_cache'
        doctrine_query_cache:
            dsn: '127.0.0.1/3'
            prefix: 'demo:query_cache:*'
            namespace: 'demo:query_cache'
        doctrine_second_level_cache:
            dsn: '127.0.0.1/4'
            prefix: 'demo:second_level_cache:*'
```
Commands:
------------
clientName: monolog, session, doctrine_metadata_cache etc.
```
sc redis:flush {clientName}
```
Examples:
------------
RedisHelper
```php
use Bigoen\RedisBundle\Utils\RedisHelper;

// create from dsn.
$helper = new RedisHelper('redis://127.0.0.1/1');
// set and add namespaces.
$helper->setNamespace("test");
$helper->addNamespace("sub");
// create redis.
$redis = $helper->getRedis();
```
RedisClientHelper
```php
use Bigoen\RedisBundle\Utils\RedisClientHelper;

class TestController
{
    public function __invoke(RedisClientHelper $helper)
    {
        // create redis.
        $redis = $helper->setClient("doctrine_query_cache")->createRedis();
        // get namespace or other client parameters.
        $namespace = $helper->getParameter('namespace');
        $redis->set("{$namespace}:key", "test");
    }
}
```
