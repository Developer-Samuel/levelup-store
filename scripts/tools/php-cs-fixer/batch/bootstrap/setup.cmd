@echo off

REM ────────────── Ensure 'tools' directory in 'var' exists ──────────────
call scripts\tools\common\batch\directory\create.cmd var\tools

REM ────────────── Setup PHP-CS-Fixer tools directory ──────────────
call scripts\tools\common\batch\directory\create.cmd var\tools\php-cs-fixer
