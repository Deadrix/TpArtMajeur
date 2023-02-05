# TpArtMajeur

Symfony 4.4 / PHP 7.4 project

First, run the following commands :
composer install
yarn install
yarn run build

Then, configure BDD in .env file

Then run the following commands :
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load

While accessing the BackOffice, use the following creditentials :
ID : admin@admin.fr
PWD : admin
