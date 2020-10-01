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
        monolog:
            dsn: '127.0.0.1/2'
            key: 'demo:monolog'
        doctrine_metadata_cache:
            dsn: '127.0.0.1/3'
            prefix: 'demo:metadata_cache:*'
        doctrine_result_cache:
            dsn: '127.0.0.1/3'
            prefix: 'demo:result_cache:*'
        doctrine_query_cache:
            dsn: '127.0.0.1/3'
            prefix: 'demo:query_cache:*'
        doctrine_second_level_cache:
            dsn: '127.0.0.1/4'
            prefix: 'demo:second_level_cache:*'
```

**Commands:**

clientName: monolog, session, doctrine_metadata_cache etc.
```
sc redis:flush {clientName}
```
