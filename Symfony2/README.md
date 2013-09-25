# Symfony 2

## Notes
- No SQL dump file was needed, the defaults data are added by doctrine fixtures bundle (see install explaination just below)
- Category count_post property does not exist because it's more powerfull to count posts each time the cache was re-generated
- The sidebar view was rendered into PublicController and the result was in file cache or APC cache (if APC extension was enabled)
- AbstractController contains helpers for Public and Admin controllers for pagination and getting the best cache, like it was explain in previous point

## Install
- Copy ```app/config/parameters.dist.yml``` to ```app/config/parameters.yml``` and change parameters for your database configuration
- Import Symfony2 using composer : ```composer install```
- Create database : ```doctrine:database:create```
- Create schema of database : ```doctrine:schema:create```
- Load DataFixtures : ```doctrine:fixtures:load``` and validate with **Y** to continue
- Enjoy !