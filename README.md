BigoenStoreReceiptValidatorBundle
============================== 

Setup
------------
**Composer repository**
```
# composer.json

"repositories": [
  {
    "type":"composer",
    "url":"https://composer.bigoen.net"
  }
]
```
or if you creates with unit tests. 
```
# composer.json

"repositories": [
        {
            "type": "vcs",
            "url": "git@gitlab.bigoen.net:symfony-bundle/security-bundle.git"
        }
    ],
    "gitlab-domains": ["gitlab.bigoen.net"]
]
```
**Composer Repository (Global)**
```
composer config -g repositories.bigoen composer https://composer.bigoen.net
```

```
composer require bigoen/store-receipt-validator-bundle
```

Details for integration,
https://phabricator.bigoen.com/phame/post/view/96/google_play_store_%C3%B6deme_kontrol_entegrasyonu/
```dotenv
# .env.local

###> bigoen/store-receipt-validator-bundle ###
GOOGLE_SERVICE_PACKAGE_NAME='com.txtlapp'
GOOGLE_SERVICE_AUTH_CONFIG_PATH='google-service-account-config.json'
###< bigoen/store-receipt-validator-bundle ###
```
```.gitignore
# .gitignore

###> bigoen/store-receipt-validator-bundle ###
google-service-account-config.json
###< bigoen/store-receipt-validator-bundle ###
```
