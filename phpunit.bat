set PHPBIN="c:\wamp\bin\php\php5.5.12\php.exe"
%PHPBIN% "c:\wamp\bin\php\php5.5.12\composer.phar" self-update
%PHPBIN% "c:\wamp\bin\php\php5.5.12\composer.phar" install -dev
%PHPBIN%  -d safe_mode=Off ./vendor/phpunit/phpunit/composer/bin/phpunit -c ./ --coverage-html ./build/coverage
REM --coverage-text
pause
phpunit.bat