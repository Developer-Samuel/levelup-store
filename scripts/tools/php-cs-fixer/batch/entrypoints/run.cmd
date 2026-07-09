@echo off

REM ================================
REM Main entrypoint for PHP-CS-Fixer
REM ================================

call scripts\tools\php-cs-fixer\batch\bootstrap\clean.cmd
call scripts\tools\php-cs-fixer\batch\bootstrap\setup.cmd

echo Running PHP-CS-Fixer...

REM Running PHP-CS-Fixer with the specified config file
php-cs-fixer fix --config=.php-cs-fixer.dist.php --cache-file=var\tools\php-cs-fixer\.php-cs-fixer.cache --verbose --diff

echo Done! PHP-CS-Fixer reports generated.
