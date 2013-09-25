# Symfony 2

## Todo-List
- Sidebar (+ cache)

## Install
- Copy ```app/config/parameters.dist.yml``` to ```app/config/parameters.yml``` and change parameters for your database configuration
- Import Symfony2 using composer : ```composer install```
- Create database : ```doctrine:database:create```
- Create schema of database : ```doctrine:schema:create```
- Load DataFixtures : ```doctrine:fixtures:load``` and validate with **Y** to continue
- Enjoy !