# Description of the Skeleton

This a skeleton of the Symfony 4.1 application. If you are not comfortable with using it, you may use any framework you 
like and create a skeleton on your own.

### What is included

The skeleton has 
- A default `App` namespace. Please keep all your code inside this namespace;
- A start page [ http://localhost:8001 ](http://localhost:8001) with Symfony's greetings
- An endpoint which returns a sum of two parameters - [http://localhost:8001/sum/3/4](
http://localhost:8001/sum/3/4);
- one unit-test and one behat test for this end-point. Please remember, you are free to use any testing approach; 
  we've prepared this tests just to save your time on installation of these popular testing frameworks;
- We've prepared a PHP container with all required php extension, it might be easier to use this container if you don't
  have PHP on your machine, but our docker just wraps Symfony server command, which can run locally 

To run tests use following command (if you use Docker)

```
docker-compose run php composer install        # to install dependencies
docker-compose up                              # to run your app
docker-compose run php /www/vendor/bin/phpunit # to run unit tests
docker-compose run php /www/vendor/bin/behat   # to run behat tests
```

Or if you don't use docker:

```
composer install                      # to install dependencies
bin/console server:run 127.0.0.1:8001 # to run your app
./vendor/bin/phpunit                  # to run unit tests
./vendor/bin/behat                    # to run behat tests
```
