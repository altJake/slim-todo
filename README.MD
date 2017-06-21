# slim-todo
Simple To-Do SPA using PHP Slim, Doctrine and React

## Install ##

1. Clone source code: `git clone https://github.com/kobyshi/slim-todo.git`
2. Install required packages: `cd slim-todo && composer install`
3. Create local sqlite schema for development purposes: `mkdir data && php vendor/bin/doctrine orm:schema-tool:create`

## Run ##

Using local php web-server: `php -S localhost:8080 -t public`
