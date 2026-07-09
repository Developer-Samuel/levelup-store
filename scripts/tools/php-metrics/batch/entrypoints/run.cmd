@echo off

REM ================================
REM Main entrypoint for PHP-Metrics
REM ================================

call scripts\tools\php-metrics\batch\bootstrap\clean.cmd
call scripts\tools\php-metrics\batch\bootstrap\setup.cmd

echo Running PHP-Metrics...

REM Running PHP-Metrics with the specified config file
phpmetrics --report-html=var/tools/php-metrics/reports src/

echo Done! PHP-Metrics reports generated.
