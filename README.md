dispatcher.dev
==============

installation:

1. $ composer install
2. set parameters.yml configs
3. $ php bin/console d:m:m
4. create user:

$ php bin/console dispatcher:user:create --username username --password password --email email@email.com

5. go to http://domain.com/user/login and start working :)