# slim-todo
Simple To-Do SPA using PHP Slim, Doctrine and React

## Install ##

1. Clone source code: `git clone https://github.com/kobyshi/slim-todo.git && cd slim-todo`
2. Create local sqlite schema for development purposes: `mkdir data && php vendor/bin/doctrine orm:schema-tool:create`
3. Install both backend and frontend required dependencies: `npm install` (or simply `yarn` if available, recommended!! find out more [here](https://yarnpkg.com/))
4. Build client bundle: `npm run build`

## Run ##

Using local php web-server: `npm start` (or again, `yarn start` using [yarn](https://yarnpkg.com/)
