@echo off

REM ================================
REM Clean old PHP-CS-Fixer folder
REM ================================

call scripts\tools\common\batch\directory\clean.cmd var\tools\php-cs-fixer
