@echo off

REM ==============================
REM Main entrypoint for PHPUnit
REM ==============================

call scripts\tools\php-unit\batch\bootstrap\clean.cmd
call scripts\tools\php-unit\batch\bootstrap\setup.cmd

echo Running PHPUnit with setup...

php bin\phpunit --testdox ^
    --cache-result-file=var\tools\php-unit\.phpunit.result.cache ^
    --coverage-html=var\tools\php-unit\html ^
    --coverage-clover=var\tools\php-unit\clover.xml
