

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Docker

Antes que nada debemos generar las imagenes de php con el Dockerfile, para ello, 

	*abrimos la siguiente carpera "desarrolloPRIL/docker/dockerfile/pril y corremos el siguiente comando

		docker build -t pril_php:0.1 .

	*abrimos la siguiente carpera "desarrolloPRIL/docker/dockerfile/registral y corremos el siguiente comando

		docker build -t registral_php:0.1 .

Luego de crear la imagen de php, debemos crear y arrancar los contenedores que son necesario para el ambiente del sistema.
    
   	*Levantamos/Creamos los contenedores
		
		-ambiente prod
		docker-compose -p app -f docker-compose.yml -f docker-compose-prod.yml up -d 
		
		-ambiente dev
		docker-compose -p app -f docker-compose.yml -f docker-compose-dev.yml up -d 

	*Borramos los contenedores (borra los contenedores)

		docker-compose -p app down

******************Ahora debemos importar el sql inicial del sistema******************
Creamos el esquema de la bd desde docker
        (PROD)
	docker exec -i app_mimysql_1 mysql -u root -proot --execute 'create database pril DEFAULT CHARACTER SET utf8'
         
        (DEV)
	docker exec -i app_mimysql_1 mysql -u root -proot --execute 'create database pril DEFAULT CHARACTER SET utf8'

Importamos el sql inicial que se encuentra en /desarrolloPRIL/bd_inicial

	docker exec -i app_mimysql_1 mysql -u root -p pril < bd_inicial.sql

Realizar los pasos en el siguiente orden:

1- Ahora debemos ejecutar el comando composer install. Como tenemos php en un contenedor debemos ejecutar el mismo comando dentro del contenedor. Para ello debemos 
entrar al contenedor con el siguiente comando: 
	docker exec -ti app_prilphp_1 bash. 
Luego ir a la carpeta de la aplicación desde la terminal y correr el comando : 
	composer install




CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
- Refer to the README in the `tests` directory for information specific to basic application tests.


TESTING
-------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](http://codeception.com/).
By default there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
vendor/bin/codecept run
```

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser. 


### Running  acceptance tests

To execute acceptance tests do the following:  

1. Rename `tests/acceptance.suite.yml.example` to `tests/acceptance.suite.yml` to enable suite configuration

2. Replace `codeception/base` package in `composer.json` with `codeception/codeception` to install full featured
   version of Codeception

3. Update dependencies with Composer 

    ```
    composer update  
    ```

4. Download [Selenium Server](http://www.seleniumhq.org/download/) and launch it:

    ```
    java -jar ~/selenium-server-standalone-x.xx.x.jar
    ```

    In case of using Selenium Server 3.0 with Firefox browser since v48 or Google Chrome since v53 you must download [GeckoDriver](https://github.com/mozilla/geckodriver/releases) or [ChromeDriver](https://sites.google.com/a/chromium.org/chromedriver/downloads) and launch Selenium with it:

    ```
    # for Firefox
    java -jar -Dwebdriver.gecko.driver=~/geckodriver ~/selenium-server-standalone-3.xx.x.jar
    
    # for Google Chrome
    java -jar -Dwebdriver.chrome.driver=~/chromedriver ~/selenium-server-standalone-3.xx.x.jar
    ``` 
    
    As an alternative way you can use already configured Docker container with older versions of Selenium and Firefox:
    
    ```
    docker run --net=host selenium/standalone-firefox:2.53.0
    ```

5. (Optional) Create `yii2_basic_tests` database and update it by applying migrations if you have them.

   ```
   tests/bin/yii migrate
   ```

   The database configuration can be found at `config/test_db.php`.


6. Start web server:

    ```
    tests/bin/yii serve
    ```

7. Now you can run all available tests

   ```
   # run all available tests
   vendor/bin/codecept run

   # run acceptance tests
   vendor/bin/codecept run acceptance

   # run only unit and functional tests
   vendor/bin/codecept run unit,functional
   ```

### Code coverage support

By default, code coverage is disabled in `codeception.yml` configuration file, you should uncomment needed rows to be able
to collect code coverage. You can run your tests and collect coverage with the following command:

```
#collect coverage for all tests
vendor/bin/codecept run -- --coverage-html --coverage-xml

#collect coverage only for unit tests
vendor/bin/codecept run unit -- --coverage-html --coverage-xml

#collect coverage for unit and functional tests
vendor/bin/codecept run functional,unit -- --coverage-html --coverage-xml
```

You can see code coverage output under the `tests/_output` directory.
