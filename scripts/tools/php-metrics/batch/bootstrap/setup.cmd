@echo off

REM ────────────── Ensure 'tools' directory in 'var' exists ──────────────
call scripts\tools\common\batch\directory\create.cmd var\tools

REM ────────────── Setup PHP-Metrics tools directory ──────────────
call scripts\tools\common\batch\directory\create.cmd var\tools\php-metrics

REM ────────────── Ensure reports directory exists ──────────────
call scripts\tools\common\batch\directory\create.cmd var\tools\php-metrics\reports
