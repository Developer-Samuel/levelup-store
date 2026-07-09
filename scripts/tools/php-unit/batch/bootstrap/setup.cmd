@echo off

REM ==============================
REM Ensure 'tools' directory in 'var' exists
REM ==============================

call scripts\tools\common\batch\directory\create.cmd var\tools

REM ==============================
REM Setup PHPUnit tools directory
REM ==============================

call scripts\tools\common\batch\directory\create.cmd var\tools\php-unit
call scripts\tools\common\batch\directory\create.cmd var\tools\php-unit\html
